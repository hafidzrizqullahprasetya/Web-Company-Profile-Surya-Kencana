/**
 * Google Maps URL Helper
 * Utilities untuk konversi dan validasi Google Maps URL
 */

export interface MapLocation {
  lat: number
  lng: number
}

export interface MapUrlResult {
  embedUrl: string
  isValid: boolean
  error?: string
}

/**
 * Convert berbagai format Google Maps URL ke format embed yang benar
 * Menghindari CORS error dengan menggunakan embed URL yang proper
 */
export function convertToEmbedUrl(url: string): MapUrlResult {
  if (!url || typeof url !== 'string') {
    return {
      embedUrl: '',
      isValid: false,
      error: 'Invalid URL',
    }
  }

  try {
    // Jika sudah embed URL yang valid, return as is
    if (url.includes('google.com/maps/embed')) {
      return {
        embedUrl: url,
        isValid: true,
      }
    }

    // Method 1: Extract coordinates dari URL
    // Format: @-6.123456,107.123456,15z
    const coordMatch = url.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*)/)
    if (coordMatch) {
      const [, lat, lng] = coordMatch
      const embedUrl = `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960!2d${lng}!3d${lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM8KwMDAnMDAuMCJTIDEwN8KwMDAnMDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890!5m2!1sen!2sid`
      return {
        embedUrl,
        isValid: true,
      }
    }

    // Method 2: Extract place ID
    // Format: /maps/place/.../@... atau /maps?q=...
    const placeIdMatch = url.match(/!1s(0x[a-f0-9]+:0x[a-f0-9]+)/)
    if (placeIdMatch) {
      const placeId = placeIdMatch[1]
      return {
        embedUrl: `https://www.google.com/maps/embed/v1/place?key=&q=place_id:${placeId}`,
        isValid: true,
      }
    }

    // Method 3: Extract query/search parameter
    const queryMatch = url.match(/[?&]q=([^&]+)/)
    if (queryMatch) {
      const query = queryMatch[1]
      return {
        embedUrl: `https://www.google.com/maps/embed/v1/place?key=&q=${query}`,
        isValid: true,
      }
    }

    // Method 4: Extract dari format /place/Name/@coords
    const placeNameMatch = url.match(/\/place\/([^/@]+)/)
    const coordsMatch = url.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*)/)
    if (placeNameMatch || coordsMatch) {
      let embedUrl = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960'

      if (coordsMatch && coordsMatch[1] && coordsMatch[2]) {
        const [, lat, lng] = coordsMatch
        embedUrl += `!2d${lng}!3d${lat}`
      }

      if (placeNameMatch && placeNameMatch[1]) {
        const placeName = encodeURIComponent(placeNameMatch[1].replace(/\+/g, ' '))
        embedUrl += `!1m2!1s${placeName}`
      }

      embedUrl += '!5e0!3m2!1sen!2sid!4v1234567890!5m2!1sen!2sid'

      return {
        embedUrl,
        isValid: true,
      }
    }

    // Fallback: Try to create a simple embed URL
    // If URL contains google.com/maps, try to make it work
    if (url.includes('google.com/maps') || url.includes('maps.google.com')) {
      // Clean up the URL
      const sanitizedUrl = url
        .replace(/&g_ep=.*?(&|$)/g, '')
        .replace(/&usp=.*?(&|$)/g, '')
        .replace(/&source=.*?(&|$)/g, '')
        .replace(/&entry=.*?(&|$)/g, '')
        .replace(/&sa=.*?(&|$)/g, '')

      // If it's a /maps URL without embed, try to extract what we can
      // Return the cleaned URL and let iframe try to load it
      return {
        embedUrl: sanitizedUrl,
        isValid: true, // Changed to true since it's still a valid Google Maps URL
        error: undefined,
      }
    }

    // Not a Google Maps URL at all
    return {
      embedUrl: url,
      isValid: false,
      error: 'Not a valid Google Maps URL',
    }
  } catch (error) {
    console.error('Error converting map URL:', error)
    return {
      embedUrl: url,
      isValid: false,
      error: error instanceof Error ? error.message : 'Unknown error',
    }
  }
}

/**
 * Extract coordinates dari Google Maps URL
 */
export function extractCoordinates(url: string): MapLocation | null {
  if (!url) return null

  try {
    // Format: @lat,lng atau @lat,lng,zoom
    const match = url.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*)/)
    if (match && match[1] && match[2]) {
      return {
        lat: parseFloat(match[1]),
        lng: parseFloat(match[2]),
      }
    }

    // Format: ll=lat,lng
    const llMatch = url.match(/ll=(-?\d+\.?\d*),(-?\d+\.?\d*)/)
    if (llMatch && llMatch[1] && llMatch[2]) {
      return {
        lat: parseFloat(llMatch[1]),
        lng: parseFloat(llMatch[2]),
      }
    }

    return null
  } catch (error) {
    console.error('Error extracting coordinates:', error)
    return null
  }
}

/**
 * Validate apakah URL adalah Google Maps URL yang valid
 */
export function isValidGoogleMapsUrl(url: string): boolean {
  if (!url || typeof url !== 'string') return false

  const googleMapsPatterns = [
    /google\.com\/maps/i,
    /goo\.gl\/maps/i,
    /maps\.google\.com/i,
    /maps\.app\.goo\.gl/i,
  ]

  return googleMapsPatterns.some((pattern) => pattern.test(url))
}

/**
 * Generate Google Maps URL dari coordinates
 */
export function createMapsUrlFromCoords(lat: number, lng: number, zoom = 15): string {
  return `https://www.google.com/maps/@${lat},${lng},${zoom}z`
}

/**
 * Generate Google Maps embed URL dari coordinates
 */
export function createEmbedUrlFromCoords(lat: number, lng: number, zoom = 15): string {
  return `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960!2d${lng}!3d${lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM8KwMDAnMDAuMCJTIDEwN8KwMDAnMDAuMCJF!5e0!3m2!1sen!2sid!4v${Date.now()}!5m2!1sen!2sid&z=${zoom}`
}

/**
 * Clean Google Maps URL dari tracking parameters
 */
export function cleanMapsUrl(url: string): string {
  if (!url) return ''

  try {
    const urlObj = new URL(url)
    const paramsToRemove = ['g_ep', 'usp', 'source', 'entry', 'sa']

    paramsToRemove.forEach((param) => {
      urlObj.searchParams.delete(param)
    })

    return urlObj.toString()
  } catch (error) {
    // If URL parsing fails, do simple string replacement
    return url
      .replace(/&g_ep=.*?(&|$)/g, '')
      .replace(/&usp=.*?(&|$)/g, '')
      .replace(/&source=.*?(&|$)/g, '')
      .replace(/&entry=.*?(&|$)/g, '')
      .replace(/&sa=.*?(&|$)/g, '')
  }
}

/**
 * Get Google Maps URL untuk direction/navigation
 */
export function createDirectionUrl(origin: string, destination: MapLocation | string): string {
  const dest =
    typeof destination === 'string' ? destination : `${destination.lat},${destination.lng}`

  return `https://www.google.com/maps/dir/?api=1&origin=${encodeURIComponent(origin)}&destination=${encodeURIComponent(dest)}`
}
