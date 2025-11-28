import { ref, computed, watch } from 'vue'
import type { Ref } from 'vue'
import {
  convertToEmbedUrl,
  isValidGoogleMapsUrl,
  extractCoordinates,
  cleanMapsUrl,
  createDirectionUrl,
  type MapUrlResult,
  type MapLocation,
} from '@/utils/googleMaps'

export interface GoogleMapsOptions {
  autoConvert?: boolean
  onError?: (error: string) => void
  fallbackUrl?: string
}

export function useGoogleMaps(
  mapUrl: Ref<string | null | undefined>,
  options: GoogleMapsOptions = {},
) {
  const { autoConvert = true, onError, fallbackUrl } = options

  const embedUrl = ref<string>('')
  const isLoading = ref(true)
  const hasError = ref(false)
  const errorMessage = ref<string>('')
  const coordinates = ref<MapLocation | null>(null)

  const isValid = computed(() => {
    if (!mapUrl.value) return false
    return isValidGoogleMapsUrl(mapUrl.value)
  })

  const canEmbed = computed(() => {
    return embedUrl.value && !hasError.value
  })

  const openInGoogleMaps = () => {
    if (!mapUrl.value) return
    window.open(mapUrl.value, '_blank', 'noopener,noreferrer')
  }

  const getDirectionUrl = (origin: string = 'Current Location') => {
    if (!coordinates.value && !mapUrl.value) return ''

    if (coordinates.value) {
      return createDirectionUrl(origin, coordinates.value)
    }

    return createDirectionUrl(origin, mapUrl.value!)
  }

  const processMapUrl = (url: string) => {
    isLoading.value = true
    hasError.value = false
    errorMessage.value = ''
    embedUrl.value = ''
    coordinates.value = null

    try {
      // Validate URL
      if (!isValidGoogleMapsUrl(url)) {
        throw new Error('Invalid Google Maps URL format')
      }

      // Extract coordinates if available
      coordinates.value = extractCoordinates(url)

      // Convert to embed URL if autoConvert is enabled
      if (autoConvert) {
        const result: MapUrlResult = convertToEmbedUrl(url)

        if (!result.isValid) {
          if (result.error) {
            console.warn('Map URL conversion warning:', result.error)
          }
          // Even if not valid, try to use the URL if it's still a Google Maps URL
          embedUrl.value = result.embedUrl || cleanMapsUrl(url)
        } else {
          embedUrl.value = result.embedUrl
          console.log('✅ Map URL converted to embed format successfully')
        }
      } else {
        embedUrl.value = cleanMapsUrl(url)
      }
    } catch (error) {
      const message = error instanceof Error ? error.message : 'Failed to process map URL'
      hasError.value = true
      errorMessage.value = message

      if (fallbackUrl) {
        embedUrl.value = fallbackUrl
        console.warn('Using fallback map URL')
      }

      if (onError) {
        onError(message)
      }

      console.error('Map URL processing error:', error)
    } finally {
      isLoading.value = false
    }
  }

  // Watch for URL changes
  watch(
    mapUrl,
    (newUrl) => {
      if (newUrl) {
        processMapUrl(newUrl)
      } else {
        embedUrl.value = ''
        hasError.value = false
        isLoading.value = false
      }
    },
    { immediate: true },
  )

  const retry = () => {
    if (mapUrl.value) {
      processMapUrl(mapUrl.value)
    }
  }

  const reset = () => {
    embedUrl.value = ''
    isLoading.value = false
    hasError.value = false
    errorMessage.value = ''
    coordinates.value = null
  }

  return {
    // State
    embedUrl,
    isLoading,
    hasError,
    errorMessage,
    coordinates,

    // Computed
    isValid,
    canEmbed,

    // Methods
    openInGoogleMaps,
    getDirectionUrl,
    retry,
    reset,
  }
}

// Standalone helper for quick embed URL conversion
export function useMapEmbedUrl(url: string): string {
  if (!url) return ''

  try {
    if (!isValidGoogleMapsUrl(url)) {
      console.warn('Not a valid Google Maps URL:', url)
      return url
    }

    const result = convertToEmbedUrl(url)
    return result.embedUrl || cleanMapsUrl(url)
  } catch (error) {
    console.error('Error converting to embed URL:', error)
    return url
  }
}
