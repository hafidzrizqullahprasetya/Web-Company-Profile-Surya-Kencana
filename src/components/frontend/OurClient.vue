<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="py-24 bg-white" id="clients">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <span
          class="inline-block px-8 py-1.5 bg-gray-100 text-gray-800 text-xs font-medium uppercase mb-8"
        >
          {{ siteSettings?.clients_label || 'Our Partners' }}
        </span>
        <h2
          v-html="siteSettings?.clients_title || 'Trusted<br><span class=\'relative inline-block z-10\'>Clients<span class=\'absolute left-1 bottom-5 w-[96%] h-5 bg-yellow-400 -z-10\'></span></span>'"
          class="text-5xl md:text-6xl lg:text-7xl font-medium uppercase text-gray-900 mb-5"
        ></h2>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="flex flex-col items-center justify-center py-20 text-center">
        <div
          class="w-12 h-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin mb-4"
        ></div>
        <p class="text-secondary text-base">Loading our partners...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="flex flex-col items-center justify-center py-20 text-center">
        <div class="mb-4">
          <svg class="w-16 h-16 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <p class="text-red-500 text-base mb-4 font-medium">{{ error }}</p>
        <button
          @click="retryFetch"
          class="bg-primary text-white px-6 py-3 text-sm font-semibold rounded-lg transition-all duration-300 hover:bg-primary/90"
        >
          Coba Lagi
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="!clients || clients.length === 0" class="flex flex-col items-center justify-center py-20 text-center">
        <div class="mb-4">
          <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
        <p class="text-gray-600 text-base">No partners available yet</p>
      </div>

      <!-- Custom Infinite Slider with Descriptions -->
      <div v-else class="relative overflow-hidden">
        <div class="client-slider flex" :class="{ pause: isHovered }">
          <!-- Duplicate clients for infinite effect -->
          <div
            v-for="(client, index) in [...clients, ...clients]"
            :key="`${client.id}-${index}`"
            class="client-item flex-shrink-0 p-6 transition-all duration-300 hover:-translate-y-1"
          >
            <div class="bg-white rounded-xl border border-gray-200 p-6 h-full flex flex-col items-center justify-center shadow-sm hover:shadow-md transition-shadow">
              <div class="h-20 flex items-center justify-center mb-4">
                <img
                  :src="getLogoUrl(client)"
                  :alt="client.client_name"
                  class="max-h-20 max-w-full object-contain"
                  @error="handleImageError"
                />
              </div>
              <div class="text-center">
                <h3 class="font-semibold text-gray-900 text-sm mb-1">
                  {{ client.client_name }}
                </h3>
                <p class="text-xs text-gray-600">
                  {{ client.institution }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api, { type OurClient, type SiteSetting } from '@/services/api'

const clients = ref<OurClient[]>([])
const siteSettings = ref<SiteSetting | null>(null)
const isLoading = ref(true)
const error = ref<string | null>(null)
const isHovered = ref(false)

const fetchClients = async () => {
  try {
    isLoading.value = true
    error.value = null
    const [clientsData, settingsData] = await Promise.all([
      api.getClients(),
      api.getSiteSettings()
    ])
    clients.value = clientsData
    siteSettings.value = settingsData
  } catch (err) {
    console.error('Error loading clients:', err)
    error.value = 'Failed to load partners'
    clients.value = []
  } finally {
    isLoading.value = false
  }
}

const retryFetch = () => {
  fetchClients()
}

const getLogoUrl = (client: OurClient): string => {
  // First, try to use the logo_url provided by the API
  if (client.logo_url) {
    return client.logo_url
  }
  
  // If logo_url is not provided, try to construct using logo_path
  if (client.logo_path) {
    // If it's already a full URL, return it
    if (client.logo_path.startsWith('http://') || client.logo_path.startsWith('https://')) {
      return client.logo_path
    }
    // Otherwise, construct URL from storage path
    return `${import.meta.env.VITE_API_BASE_URL?.replace('/api', '') || 'http://127.0.0.1:8000'}/storage/${client.logo_path}`
  }
  
  // If neither is available, return placeholder
  return 'https://placehold.co/150x80/e5e7eb/6b7280?text=No+Image'
}

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement
  target.src = 'https://placehold.co/150x80/e5e7eb/6b7280?text=No+Image'
}

onMounted(() => {
  fetchClients()
})
</script>

<style scoped>
.client-slider {
  animation: slide 15s linear infinite; /* Made it faster (15s instead of 20s/40s) */
  will-change: transform;
}

.client-slider:hover,
.client-slider.pause {
  animation-play-state: paused;
}

@keyframes slide {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%); /* Move by width of first set of items */
  }
}

.client-item {
  min-width: 250px;
  max-width: 250px;
}
</style>
