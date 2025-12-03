export interface ParsedMapData {
  type: 'coordinates' | 'location_name' | 'url' | 'invalid';
  value: string;
}

export function useMapParser() {
  const parseMapLink = (input: string): ParsedMapData => {
    if (!input || input.trim() === '') return { type: 'invalid', value: '' }

    // Check if it's coordinates format (e.g., "-7.7828701,110.283376")
    if (/^-?\d+(\.\d+)?,\s*-?\d+(\.\d+)?$/.test(input)) {
      return { type: 'coordinates', value: input.trim() }
    }

    // Try to parse as URL
    try {
      const url = new URL(input)

      // Extract coordinates from URL (e.g., "@-7.7828701,110.283376")
      const coordsMatch = url.pathname.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/)
      if (coordsMatch && coordsMatch[1] && coordsMatch[2]) {
        return { type: 'coordinates', value: `${coordsMatch[1]},${coordsMatch[2]}` }
      }

      // Extract place name from URL (e.g., "/place/PT+Surya+Kencana")
      const placeMatch = url.pathname.match(/\/place\/([^/@]+)/)
      if (placeMatch && placeMatch[1]) {
        return { type: 'location_name', value: decodeURIComponent(placeMatch[1].replace(/\+/g, ' ')) }
      }

      // If it's a Google Maps short link, return as-is
      if (url.hostname === 'maps.app.goo.gl') {
        return { type: 'url', value: input }
      }
    } catch (e) {
      // Not a valid URL - treat as location name
      return { type: 'location_name', value: input.trim() }
    }

    // Return as location name for search
    return { type: 'location_name', value: input.trim() }
  }

  return { parseMapLink }
}
