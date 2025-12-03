import api, { type SiteSetting } from '@/services/api'
import { ref } from 'vue'

const settings = ref<SiteSetting | null>(null)
const isLoading = ref(false)
const error = ref<string | null>(null)
let fetchPromise: Promise<void> | null = null

export function useSiteSettings() {
  const fetchSettings = async (forceRefresh = false) => {
    if (fetchPromise) {
      return fetchPromise
    }

    if (settings.value && !forceRefresh) {
      return Promise.resolve()
    }

    fetchPromise = (async () => {
      try {
        isLoading.value = true
        error.value = null

        const data = await api.getSiteSettings()
        settings.value = data
      } catch (err: any) {
        console.error('Error fetching site settings:', err)
        error.value = err.response?.data?.error || err.message || 'Failed to load site settings'
      } finally {
        isLoading.value = false
        fetchPromise = null
      }
    })()

    return fetchPromise
  }

  const refresh = async () => {
    return fetchSettings(true)
  }

  return {
    settings,
    isLoading,
    error,
    fetchSettings,
    refresh,
  }
}
