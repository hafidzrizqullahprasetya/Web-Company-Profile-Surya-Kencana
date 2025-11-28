import { ref, onMounted } from 'vue'
import { landingPageApi, type LandingPageData } from '@/services'

// --- KONFIGURASI SMART CACHE ---
const CACHE_KEY = 'landing_page_data_prod'
const ENABLE_CACHE = true

// State Global (Singleton)
const landingPageData = ref<LandingPageData | null>(null)
const isLoading = ref(false)
const error = ref<string | null>(null)
let fetchPromise: Promise<void> | null = null

// --- HELPER FUNCTIONS ---
const loadFromCache = (): boolean => {
  try {
    const cachedString = localStorage.getItem(CACHE_KEY)
    if (!cachedString) {
      console.log('📭 Cache kosong, akan mengambil data baru.')
      return false
    }

    const { data } = JSON.parse(cachedString)
    if (data) {
      landingPageData.value = data
      console.log('⚡ Data dimuat instan dari cache lokal.')
      return true
    }
  } catch (err) {
    console.error('❌ Cache rusak, menghapus...', err)
    localStorage.removeItem(CACHE_KEY)
  }
  return false
}

/**
 * Simpan data baru ke LocalStorage
 */
const saveToCache = (data: LandingPageData) => {
  try {
    const payload = {
      data,
      timestamp: Date.now(),
      version: data.cacheVersion || 'unknown',
    }
    localStorage.setItem(CACHE_KEY, JSON.stringify(payload))
    console.log(`💾 Cache diperbarui (v${data.cacheVersion})`)
  } catch (err) {
    console.error('Gagal menyimpan cache:', err)
  }
}

export function useLandingPageData() {
  const fetchLandingPageData = async (forceRefresh = false): Promise<void> => {
    // Hindari double fetch
    if (fetchPromise) return fetchPromise

    isLoading.value = true
    error.value = null

    // 1. Load Cache Dulu (Instant Load)
    const hasCache = !forceRefresh && loadFromCache()

    // 2. Fetch ke Backend (Revalidasi)
    fetchPromise = landingPageApi
      .getLandingPageData()
      .then((newData) => {
        const currentData = landingPageData.value
        const isDifferent =
          !currentData ||
          (newData.cacheVersion && currentData.cacheVersion
            ? newData.cacheVersion !== currentData.cacheVersion
            : JSON.stringify(newData.siteSettings) !== JSON.stringify(currentData.siteSettings) ||
              JSON.stringify(newData.hero) !== JSON.stringify(currentData.hero) ||
              newData.products.length !== currentData.products.length)

        if (isDifferent || forceRefresh) {
          landingPageData.value = newData
          if (ENABLE_CACHE) {
            saveToCache(newData)
          }
          console.log('🌐 Data disinkronisasi dari server.')
        } else {
          console.log('✅ Data server identik dengan cache. Tidak ada perubahan UI.')
        }
      })
      .catch((err) => {
        console.error('Gagal fetch data server:', err)

        // Use cache if available
        if (!hasCache) {
          error.value = err.message || 'Gagal memuat data.'
          console.error('❌ Gagal fetch dan tidak ada cache.')
        } else {
          console.warn('⚠️ Menggunakan data cache offline.')
        }
      })
      .finally(() => {
        isLoading.value = false
        fetchPromise = null
      })

    return fetchPromise
  }

  // Paksa ambil ulang (misal tombol refresh manual)
  const refresh = async (): Promise<void> => {
    await fetchLandingPageData(true)
  }

  // Auto-run saat composable dipanggil pertama kali
  onMounted(() => {
    if (!landingPageData.value && !isLoading.value) {
      fetchLandingPageData()
    }
  })

  return {
    data: landingPageData,
    isLoading,
    error,
    refresh,
    fetch: fetchLandingPageData,
  }
}
