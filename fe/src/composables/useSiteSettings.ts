import { ref } from 'vue'
import api, { type SiteSetting } from '@/services/api'

// Cache configuration
const CACHE_KEY = 'site_settings_cache'
const CACHE_DURATION = 5 * 60 * 1000 // 5 minutes

// Shared state across all components
const settings = ref<SiteSetting | null>(null)
const isLoading = ref(false)
const error = ref<string | null>(null)
let fetchPromise: Promise<void> | null = null

// Default fallback settings
const DEFAULT_SETTINGS: Partial<SiteSetting> = {
  company_name: 'Surya Kencana',
  company_email: 'info@suryakencana.com',
  company_phone: '',
  company_address: '',
  company_logo_url: '',
  whatsapp_number: '',
  google_maps_url: '',
  instagram_url: '',
  facebook_url: '',
  linkedin_url: '',
  youtube_url: '',
}

// Load from cache
const loadFromCache = (): boolean => {
  try {
    const cached = localStorage.getItem(CACHE_KEY)
    if (!cached) return false

    const { data, timestamp } = JSON.parse(cached)
    const age = Date.now() - timestamp

    // Use cache if less than CACHE_DURATION old
    if (age < CACHE_DURATION && data) {
      settings.value = data
      console.log('⚡ Site settings loaded from cache')
      return true
    }
  } catch (err) {
    console.warn('Failed to load site settings cache:', err)
    localStorage.removeItem(CACHE_KEY)
  }
  return false
}

// Save to cache
const saveToCache = (data: SiteSetting) => {
  try {
    const payload = { data, timestamp: Date.now() }
    localStorage.setItem(CACHE_KEY, JSON.stringify(payload))
  } catch (err) {
    console.warn('Failed to save site settings cache:', err)
  }
}

export function useSiteSettings() {
  const fetchSettings = async (forceRefresh = false) => {
    // If already loading, return existing promise
    if (fetchPromise) {
      return fetchPromise
    }

    // If already loaded and not forcing refresh, return immediately
    if (settings.value && !forceRefresh) {
      return Promise.resolve()
    }

    // Try to load from cache first for instant display
    const hasCache = loadFromCache()

    fetchPromise = (async () => {
      try {
        isLoading.value = true
        error.value = null

        const data = await api.getSiteSettings()
        settings.value = data
        saveToCache(data)

        console.log('✅ Site settings loaded from server')
      } catch (err: any) {
        console.error('Error fetching site settings:', err)

        // If we have cache, use it as fallback
        if (hasCache && settings.value) {
          console.warn('⚠️ Using cached site settings as fallback')
          error.value = null // Clear error since we have fallback data
        } else {
          // No cache available, use default settings as last resort
          console.warn('⚠️ Using default site settings as fallback')
          settings.value = DEFAULT_SETTINGS as SiteSetting
          error.value = 'Using default settings - could not connect to server'
        }
      } finally {
        isLoading.value = false
        fetchPromise = null
      }
    })()

    return fetchPromise
  }

  // Force refresh settings
  const refresh = async () => {
    return fetchSettings(true)
  }

  // Clear cache
  const clearCache = () => {
    localStorage.removeItem(CACHE_KEY)
    settings.value = null
    console.log('🗑️ Site settings cache cleared')
  }

  return {
    settings,
    isLoading,
    error,
    fetchSettings,
    refresh,
    clearCache,
  }
}
