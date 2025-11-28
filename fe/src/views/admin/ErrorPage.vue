<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
      <!-- Error Icon -->
      <div class="mb-8">
        <i
          :class="errorIcon"
          class="text-8xl text-primary"
          :style="{
            animation:
              errorType === 'network' || errorType === 'timeout'
                ? 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                : 'none',
          }"
        ></i>
      </div>

      <!-- Error Code -->
      <h1 class="text-6xl md:text-7xl font-bold text-gray-900 mb-4">
        {{ errorCode }}
      </h1>

      <!-- Error Title -->
      <h2 class="text-2xl md:text-3xl font-bold text-gray-700 mb-4">
        {{ errorTitle }}
      </h2>

      <!-- Error Description -->
      <p class="text-gray-600 mb-8 max-w-lg mx-auto">
        {{ errorDescription }}
      </p>

      <!-- Loading Indicator for Connection Errors -->
      <div v-if="errorType === 'network' || errorType === 'timeout'" class="mt-8">
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
        <p class="text-gray-600 text-sm mb-2">Mencoba terhubung kembali ke server...</p>
        <p class="text-gray-500 text-xs">Percobaan: {{ retryCount }}</p>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
        <button
          @click="goBack"
          class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center justify-center gap-2"
        >
          <i class="fa-solid fa-arrow-left"></i>
          <span>Kembali</span>
        </button>
        <button
          @click="goToDashboard"
          class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-2"
        >
          <i class="fa-solid fa-home"></i>
          <span>Dashboard</span>
        </button>
        <button
          v-if="errorType === 'network' || errorType === 'timeout' || errorType === 'server'"
          @click="retryNow"
          class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2"
        >
          <i class="fa-solid fa-rotate-right"></i>
          <span>Coba Lagi</span>
        </button>
      </div>

      <!-- Technical Details (collapsible) -->
      <div v-if="showTechnicalDetails" class="mt-12">
        <button
          @click="technicalDetailsOpen = !technicalDetailsOpen"
          class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-2 mx-auto"
        >
          <i
            :class="technicalDetailsOpen ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'"
          ></i>
          <span>Detail Teknis</span>
        </button>
        <div
          v-if="technicalDetailsOpen"
          class="mt-4 text-left bg-gray-800 text-gray-100 p-4 rounded-lg text-xs font-mono max-w-lg mx-auto"
        >
          <div class="mb-2"><strong>Error Type:</strong> {{ errorType }}</div>
          <div v-if="route.query.status" class="mb-2">
            <strong>Status Code:</strong> {{ route.query.status }}
          </div>
          <div class="mb-2"><strong>Path:</strong> {{ route.fullPath }}</div>
          <div class="mb-2">
            <strong>Timestamp:</strong> {{ new Date().toLocaleString('id-ID') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRoute, useRouter } from 'vue-router'
import { computed, onMounted, onUnmounted, ref } from 'vue'
import api from '@/services/api'

const route = useRoute()
const router = useRouter()

const retryCount = ref(0)
const technicalDetailsOpen = ref(false)

const errorType = computed(() => (route.query.type as string) || '404')

const errorCode = computed(() => {
  switch (errorType.value) {
    case 'network':
      return 'ERR_NETWORK'
    case 'timeout':
      return 'TIMEOUT'
    case 'server':
      return route.query.status || '500'
    case 'unauthorized':
      return '401'
    case 'forbidden':
      return '403'
    case '404':
    default:
      return '404'
  }
})

const errorTitle = computed(() => {
  switch (errorType.value) {
    case 'network':
      return 'Tidak Dapat Terhubung ke Server'
    case 'timeout':
      return 'Koneksi Timeout'
    case 'server':
      return 'Server Mengalami Masalah'
    case 'unauthorized':
      return 'Akses Tidak Diizinkan'
    case 'forbidden':
      return 'Akses Ditolak'
    case '404':
    default:
      return 'Halaman Tidak Ditemukan'
  }
})

const errorDescription = computed(() => {
  switch (errorType.value) {
    case 'network':
      return 'Backend server tidak dapat dijangkau. Pastikan server sedang berjalan dan koneksi internet Anda stabil.'
    case 'timeout':
      return 'Permintaan memakan waktu terlalu lama. Server mungkin sedang sibuk atau koneksi internet Anda lambat.'
    case 'server':
      return 'Server mengalami kesalahan internal. Tim teknis kami telah diberitahu dan sedang menangani masalah ini.'
    case 'unauthorized':
      return 'Anda tidak memiliki izin untuk mengakses halaman ini. Silakan login terlebih dahulu.'
    case 'forbidden':
      return 'Akses ke halaman ini dibatasi. Hubungi administrator jika Anda memerlukan akses.'
    case '404':
    default:
      return 'Halaman yang Anda cari tidak ditemukan. Mungkin sudah dipindahkan atau dihapus.'
  }
})

const errorIcon = computed(() => {
  switch (errorType.value) {
    case 'network':
      return 'fa-solid fa-wifi-slash'
    case 'timeout':
      return 'fa-solid fa-clock'
    case 'server':
      return 'fa-solid fa-server'
    case 'unauthorized':
      return 'fa-solid fa-lock'
    case 'forbidden':
      return 'fa-solid fa-ban'
    case '404':
    default:
      return 'fa-solid fa-circle-exclamation'
  }
})

const showTechnicalDetails = computed(() => {
  return ['network', 'timeout', 'server'].includes(errorType.value)
})

const goBack = () => {
  router.back()
}

const goToDashboard = () => {
  router.push('/admin/dashboard')
}

const retryNow = () => {
  window.location.reload()
}

let retryInterval: number | undefined

const checkConnection = async () => {
  if (
    errorType.value === 'network' ||
    errorType.value === 'timeout' ||
    errorType.value === 'server'
  ) {
    retryCount.value++
    try {
      await api.getSiteSettings()
      window.location.href = '/admin/dashboard'
    } catch {
      console.log(`Retry attempt ${retryCount.value} failed, will retry...`)
    }
  }
}

onMounted(() => {
  if (
    errorType.value === 'network' ||
    errorType.value === 'timeout' ||
    errorType.value === 'server'
  ) {
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
@keyframes pulse {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>
