import { computed } from 'vue'

/**
 * Composable untuk mengelola URL dan fungsi WhatsApp
 */
export function useWhatsApp() {
  /**
   * Membuat URL untuk menghubungi melalui WhatsApp
   */
  const createWhatsAppUrl = (contactInfo: { phone?: string } | null, message?: string): string => {
    if (!contactInfo?.phone) return '#'

    const phoneNumber = contactInfo.phone.replace(/[^\d+]/g, '')
    let formattedNumber = phoneNumber

    if (phoneNumber.startsWith('0')) {
      formattedNumber = '62' + phoneNumber.substring(1)
    } else if (phoneNumber.startsWith('8')) {
      formattedNumber = '62' + phoneNumber
    }

    const defaultMessage = 'Halo, saya ingin bertanya tentang produk/mesin yang tersedia.'
    const finalMessage = message || defaultMessage
    const encodedMessage = encodeURIComponent(finalMessage)

    return `https://wa.me/${formattedNumber}?text=${encodedMessage}`
  }

  return {
    createWhatsAppUrl,
  }
}