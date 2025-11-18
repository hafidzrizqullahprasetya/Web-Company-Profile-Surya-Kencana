import { ref, onMounted } from 'vue'
import api, { type LandingPageData } from '@/services/api'

const CACHE_KEY = 'landing_page_data_v3'
const CACHE_DURATION = 30 * 1000 //
const ENABLE_CACHE = false

// Clean up old cache keys
if (typeof localStorage !== 'undefined') {
  localStorage.removeItem('landing_page_data')
  localStorage.removeItem('landing_page_data_v2')
}

const landingPageData = ref<LandingPageData | null>(null)
const isLoading = ref(false)
const error = ref<string | null>(null)
let fetchPromise: Promise<void> | null = null

// Try to load from localStorage on module load
const loadFromCache = () => {
  try {
    const cached = localStorage.getItem(CACHE_KEY)
    if (cached) {
      const { data, timestamp, cacheVersion } = JSON.parse(cached)
      const now = Date.now()
      const age = Math.round((now - timestamp) / 1000) 

      console.log('💾 Found cache in localStorage', {
        age: `${age}s`,
        cacheVersion,
        maxAge: `${CACHE_DURATION / 1000}s`
      })

      // Check if cache is still valid (within 5 minutes)
      if (now - timestamp < CACHE_DURATION) {
        landingPageData.value = data
        // Store current cache version for later comparison
        if (cacheVersion) {
          sessionStorage.setItem('cache_version', cacheVersion.toString())
          console.log('✅ Loaded from cache, version:', cacheVersion)
        }
        return true
      } else {
        console.log('⏰ Cache expired, removing...')
        // Cache expired, remove it
        localStorage.removeItem(CACHE_KEY)
        sessionStorage.removeItem('cache_version')
      }
    } else {
      console.log('📭 No cache found in localStorage')
    }
  } catch (err) {
    console.error('❌ Error loading from cache:', err)
    localStorage.removeItem(CACHE_KEY)
    sessionStorage.removeItem('cache_version')
  }
  return false
}

// Save to localStorage
const saveToCache = (data: LandingPageData) => {
  try {
    localStorage.setItem(CACHE_KEY, JSON.stringify({
      data,
      timestamp: Date.now(),
      cacheVersion: data.cacheVersion
    }))
    // Store cache version in sessionStorage for quick validation
    if (data.cacheVersion) {
      sessionStorage.setItem('cache_version', data.cacheVersion.toString())
    }
  } catch (err) {
    console.error('Error saving to cache:', err)
  }
}

// Check if cache version is outdated (lightweight check)
const checkCacheVersion = async () => {
  try {
    const currentVersion = sessionStorage.getItem('cache_version')
    console.log('🔍 Checking cache version...', { currentVersion })

    if (!currentVersion) {
      console.log('⚠️ No cache version found in sessionStorage')
      return false
    }

    const response = await api.getLandingPageData()
    const newVersion = response.cacheVersion

    console.log('📡 Got response from backend', { currentVersion, newVersion })

    // If versions differ, cache is outdated
    if (newVersion && newVersion.toString() !== currentVersion) {
      console.log('🔄 Cache outdated, refreshing...', { current: currentVersion, new: newVersion })
      localStorage.removeItem(CACHE_KEY)
      sessionStorage.removeItem('cache_version')
      landingPageData.value = response
      saveToCache(response)
      return true
    }

    console.log('✅ Cache is up to date')
    return false
  } catch (err) {
    console.error('❌ Error checking cache version:', err)
    return false
  }
}

export function useLandingPageData() {
  const fetchLandingPageData = async (skipCache = false) => {
    // If already loading, return the existing promise
    if (fetchPromise) {
      return fetchPromise
    }

    // If data already loaded and not forcing refresh, don't fetch again
    if (landingPageData.value && !skipCache) {
      return
    }

    // Try to load from cache first (unless skipCache is true or cache is disabled)
    if (ENABLE_CACHE && !skipCache && loadFromCache()) {
      console.log('Loaded from localStorage cache')
      // Check if cache version is still valid in background
      checkCacheVersion()
      return
    }

    isLoading.value = true
    error.value = null

    fetchPromise = api
      .getLandingPageData()
      .then((response) => {
        landingPageData.value = response
        error.value = null
        if (ENABLE_CACHE) {
          saveToCache(response) // Save to localStorage only if cache is enabled
        }
      })
      .catch((err) => {
        console.error('Error fetching landing page data:', err)
        error.value = err.message || 'Failed to load landing page data'
        landingPageData.value = null
      })
      .finally(() => {
        isLoading.value = false
        fetchPromise = null
      })

    return fetchPromise
  }

  // Force refresh data (clear cache and fetch again)
  const refresh = async () => {
    landingPageData.value = null
    fetchPromise = null
    localStorage.removeItem(CACHE_KEY) // Clear localStorage cache
    await fetchLandingPageData()
  }

  // Auto-fetch on mount if data not yet loaded
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
