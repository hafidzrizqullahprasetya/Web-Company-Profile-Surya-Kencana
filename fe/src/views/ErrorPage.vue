<template>
  <div
    class="min-h-screen bg-gradient-to-br from-primary/10 via-white to-primary/5 flex items-center justify-center p-4"
  >
    <div class="max-w-2xl w-full text-center">
      <!-- Error Code -->
      <h1
        class="text-9xl md:text-[12rem] font-bold text-primary mb-8 tracking-tighter animate-pulse"
      >
        {{ errorCode }}
      </h1>

      <!-- Error Title -->
      <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
        {{ errorTitle }}
      </h2>

      <!-- Loading Indicator for Connection Error -->
      <div v-if="errorType === 'connection'" class="mt-8">
        <div class="flex items-center justify-center gap-3 mb-4">
          <div
            class="w-3 h-3 bg-primary rounded-full animate-bounce"
            style="animation-delay: 0ms"
          ></div>
          <div
            class="w-3 h-3 bg-primary rounded-full animate-bounce"
            style="animation-delay: 150ms"
          ></div>
          <div
            class="w-3 h-3 bg-primary rounded-full animate-bounce"
            style="animation-delay: 300ms"
          ></div>
        </div>
        <p class="text-gray-600 text-sm">Mencoba terhubung kembali...</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRoute } from 'vue-router'
import { computed, onMounted, onUnmounted } from 'vue'
import api from '@/services/api'

const route = useRoute()

// Get error type from route query or props
const errorType = computed(() => (route.query.type as string) || '404')

const errorCode = computed(() => {
  switch (errorType.value) {
    case 'connection':
      return '500'
    case '404':
    default:
      return '404'
  }
})

const errorTitle = computed(() => {
  switch (errorType.value) {
    case 'connection':
      return 'Gagal Terhubung ke Server'
    case '404':
    default:
      return 'Halaman Tidak Ditemukan'
  }
})

// Auto retry for connection errors
let retryInterval: number | undefined
let retryAttempts = 0
const MAX_AUTO_RETRIES = 5

const checkConnection = async () => {
  if (errorType.value === 'connection') {
    retryAttempts++

    // Stop auto-retry after MAX_AUTO_RETRIES attempts
    if (retryAttempts > MAX_AUTO_RETRIES) {
      if (retryInterval) {
        clearInterval(retryInterval)
        retryInterval = undefined
      }
      console.log('Auto-retry stopped after', MAX_AUTO_RETRIES, 'attempts')
      return
    }

    try {
      // Try to fetch site settings as a health check
      await api.getSiteSettings()
      // If successful, reload page to go back to normal
      window.location.href = '/'
    } catch (error) {
      // Still can't connect, keep retrying
      console.log(`Retry attempt ${retryAttempts}/${MAX_AUTO_RETRIES} failed`)
    }
  }
}

onMounted(() => {
  if (errorType.value === 'connection') {
    // Start checking connection every 5 seconds (less aggressive)
    retryInterval = window.setInterval(checkConnection, 5000)
  }
})

onUnmounted(() => {
  if (retryInterval) {
    clearInterval(retryInterval)
  }
})
</script>

<style scoped>
@keyframes ping {
  75%,
  100% {
    transform: scale(2);
    opacity: 0;
  }
}

.animate-ping {
  animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
}
</style>
