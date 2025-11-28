/**
 * Composable untuk fungsi-fungsi penanganan gambar
 */
export function useImageHandling() {
  /**
   * Tangani error saat image gagal dimuat
   */
  const handleImageError = (event: Event, fallbackUrl?: string) => {
    const target = event.target as HTMLImageElement
    const fallback = fallbackUrl || 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'
    target.src = fallback
  }

  /**
   * Membuat URL preview untuk file yang dipilih
   */
  const getPreviewUrl = (file: File): string => {
    return URL.createObjectURL(file)
  }

  /**
   * Membuang object URL untuk menghindari memory leak
   */
  const revokePreviewUrl = (url: string) => {
    URL.revokeObjectURL(url)
  }

  return {
    handleImageError,
    getPreviewUrl,
    revokePreviewUrl,
  }
}