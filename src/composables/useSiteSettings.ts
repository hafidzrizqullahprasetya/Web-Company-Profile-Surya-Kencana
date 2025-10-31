import { ref } from 'vue'
import api, { type SiteSetting } from '@/services/api'

// Shared state across all components
const settings = ref<SiteSetting | null>(null)
const isLoading = ref(false)
const error = ref<string | null>(null)
let fetchPromise: Promise<void> | null = null

export function useSiteSettings() {
  const fetchSettings = async () => {
    // If already loading, return existing promise
    if (fetchPromise) {
      return fetchPromise
    }

    // If already loaded, return immediately
    if (settings.value) {
      return Promise.resolve()
    }

    fetchPromise = (async () => {
      try {
        isLoading.value = true
        error.value = null
        const data = await api.getSiteSettings()
        settings.value = data
      } catch (err) {
        console.error('Error fetching site settings:', err)
        error.value = 'Failed to load site settings'
      } finally {
        isLoading.value = false
        fetchPromise = null
      }
    })()

    return fetchPromise
  }

  return {
    settings,
    isLoading,
    error,
    fetchSettings,
  }
}
