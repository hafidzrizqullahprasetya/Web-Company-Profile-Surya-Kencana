<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="py-24 bg-white" id="clients">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <span
          class="inline-block px-8 py-1.5 bg-gray-100 text-gray-800 text-xs font-medium uppercase mb-8"
        >
          Our Partners
        </span>
        <h2 class="text-5xl md:text-6xl lg:text-7xl font-medium uppercase text-gray-900 mb-5">
          Trusted
          <span class="relative inline-block z-10">
            Clients
            <span class="absolute left-1 bottom-5 w-[96%] h-5 bg-yellow-400 -z-10"></span>
          </span>
        </h2>
      </div>

      <!-- Custom Infinite Slider -->
      <div v-if="clients.length > 0" class="relative overflow-hidden">
        <div class="client-slider flex" :class="{ pause: isHovered }">
          <!-- Duplicate clients for infinite effect -->
          <div
            v-for="(client, index) in [...clients, ...clients]"
            :key="`${client.id}-${index}`"
            class="client-item flex-shrink-0 text-center p-4 transition-all duration-300 hover:-translate-y-1.25"
          >
            <img
              :src="
                client.logo_url ||
                `https://placehold.co/150x80/F5F6E4/1C1817?text=${client.client_name}`
              "
              :alt="client.client_name"
              class="mx-auto max-h-20 object-contain"
            />
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-else-if="isLoading" class="text-center py-20">
        <div
          class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-yellow-400"
        ></div>
        <p class="mt-4 text-gray-600">Loading clients...</p>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-20">
        <div class="mb-4">
          <i-lucide:user class="w-16 h-16 text-gray-300" />
        </div>
        <p class="text-gray-600 text-lg">No clients available at the moment.</p>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api, { type OurClient } from '@/services/api'

const clients = ref<OurClient[]>([])
const isLoading = ref(true)
const isHovered = ref(false)

onMounted(async () => {
  try {
    isLoading.value = true
    clients.value = await api.getClients()
  } catch (error) {
    console.error('Error loading clients:', error)
    clients.value = []
  } finally {
    isLoading.value = false
  }
})
</script>

<style scoped>
.client-slider {
  animation: slide 30s linear infinite;
  width: calc(200px * var(--client-count) * 2); /* Adjust based on item width */
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
    transform: translateX(-50%);
  }
}

.client-item {
  width: 200px; /* Adjust as needed */
}
</style>
