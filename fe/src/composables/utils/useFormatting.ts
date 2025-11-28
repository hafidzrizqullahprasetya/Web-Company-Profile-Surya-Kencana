/**
 * Composable untuk fungsi-fungsi formatting umum
 */
export function useFormatting() {
  /**
   * Format harga ke format IDR
   */
  const formatPrice = (price: number | undefined): string => {
    if (!price) return 'Rp 0'
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
      maximumFractionDigits: 0,
    }).format(price)
  }

  /**
   * Format title (mengganti baris baru dengan tag <br>)
   */
  const formatTitle = (title?: string): string => {
    if (!title) return ''
    return title.replace(/\n/g, '<br />')
  }

  return {
    formatPrice,
    formatTitle,
  }
}