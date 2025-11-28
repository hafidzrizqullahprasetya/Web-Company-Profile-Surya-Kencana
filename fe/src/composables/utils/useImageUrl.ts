import { computed } from 'vue'

/**
 * Composable untuk mengelola URL gambar untuk berbagai format dan fallback
 */
export function useImageUrl() {
  const cdnUrl = computed(() =>
    import.meta.env.VITE_CDN_URL || 'https://pub-2fb44babc7a4420e8fa728891ac101ef.r2.dev'
  )

  /**
   * Menghasilkan URL dari path gambar dengan CDN
   */
  const getImageUrl = (imagePath: string | undefined): string => {
    if (!imagePath) {
      return 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'
    }
    if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
      return imagePath
    }
    return `${cdnUrl.value}/${imagePath}`
  }

  /**
   * Mendapatkan URL untuk format tertentu (webp, jpeg, dll)
   */
  const getImageUrlForFormat = (url: string, format: string = 'webp'): string => {
    if (
      url.includes('placehold.co') ||
      url.includes('ui-avatars.com') ||
      !url.match(/\.(jpg|jpeg|png)$/i)
    ) {
      return url
    }
    return url.replace(/\.(jpg|jpeg|png)$/i, `.${format}`)
  }

  /**
   * Menghasilkan URL placeholder jika error
   */
  const getPlaceholderUrl = (): string => {
    return 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'
  }

  return {
    getImageUrl,
    getImageUrlForFormat,
    getPlaceholderUrl,
  }
}