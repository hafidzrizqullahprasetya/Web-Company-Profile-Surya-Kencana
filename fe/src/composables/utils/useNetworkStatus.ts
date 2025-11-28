import { ref, onMounted, onUnmounted } from 'vue'

/**
 * Composable untuk monitor status koneksi internet
 * Berguna untuk memberikan feedback ke user saat offline/online
 */
export function useNetworkStatus() {
  const isOnline = ref(navigator.onLine)
  const wasOffline = ref(false)

  const updateOnlineStatus = () => {
    const newStatus = navigator.onLine

    // Track jika sempat offline
    if (!newStatus) {
      wasOffline.value = true
    }

    // Jika kembali online setelah sempat offline
    if (newStatus && wasOffline.value) {
      console.log('🟢 Koneksi internet kembali normal')
      wasOffline.value = false

      // Trigger event untuk reload data jika diperlukan
      window.dispatchEvent(new CustomEvent('network-restored'))
    }

    isOnline.value = newStatus
  }

  const handleOnline = () => {
    console.log('🟢 Network: Online')
    updateOnlineStatus()
  }

  const handleOffline = () => {
    console.log('🔴 Network: Offline')
    updateOnlineStatus()
  }

  onMounted(() => {
    window.addEventListener('online', handleOnline)
    window.addEventListener('offline', handleOffline)
  })

  onUnmounted(() => {
    window.removeEventListener('online', handleOnline)
    window.removeEventListener('offline', handleOffline)
  })

  return {
    isOnline,
    wasOffline,
  }
}
