import { landingPageApi, type LandingPageData } from '@/services'
import { onMounted, ref } from 'vue'

const landingPageData = ref<LandingPageData | null>(null)
const isLoading = ref(false)
const error = ref<string | null>(null)
let fetchPromise: Promise<void> | null = null

export function useLandingPageData() {
  const fetchLandingPageData = async (forceRefresh = false): Promise<void> => {
    if (fetchPromise && !forceRefresh) return fetchPromise

    isLoading.value = true
    error.value = null

    fetchPromise = landingPageApi
      .getLandingPageData()
      .then((newData) => {
        landingPageData.value = newData
        error.value = null
        isLoading.value = false
      })
      .catch((err) => {
        console.error('Error fetching landing page data:', err)
        landingPageData.value = null
        const errorMessage = err.response?.data?.error || err.message || 'Failed to connect to server'
        error.value = errorMessage
        isLoading.value = false
      })
      .finally(() => {
        fetchPromise = null
      })

    return fetchPromise
  }

  const refresh = async (): Promise<void> => {
    await fetchLandingPageData(true)
  }

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
