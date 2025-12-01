export function useMapParser() {
  const parseMapLink = (input: string): string => {
    if (!input) return ''

    if (/^-?\d+(\.\d+)?,\s*-?\d+(\.\d+)?$/.test(input)) {
      return input
    }

    try {
      const url = new URL(input)

      const coordsMatch = url.pathname.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/)
      if (coordsMatch && coordsMatch[1] && coordsMatch[2]) {
        console.log('[useMapParser] Extracted coordinates from URL')
        return `${coordsMatch[1]},${coordsMatch[2]}`
      }

      const placeMatch = url.pathname.match(/\/place\/([^/@]+)/)
      if (placeMatch && placeMatch[1]) {
        console.log('[useMapParser] Extracted place name from URL')
        return decodeURIComponent(placeMatch[1].replace(/\+/g, ' '))
      }

      if (url.hostname === 'maps.app.goo.gl') {
        console.log('[useMapParser] Short link detected, using as fallback query')
        return 'PT. Surya Kencana Gemilang Teknik'
      }
    } catch (e) {
      console.warn('[useMapParser] Invalid URL format:', input, e)
    }

    console.log('[useMapParser] Returning input as-is:', input)
    return input
  }

  return { parseMapLink }
}
