<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="py-24 bg-white" id="clients">
    <div class="container mx-auto px-4">
      <div class="row mb-16">
        <div class="col-lg-12">
          <div class="text-center mb-16">
            <small
              class="inline-block px-8 py-1.5 bg-gray-100 text-gray-800 text-xs font-medium uppercase mb-8"
            >
              Our Partners
            </small>
            <h2 class="text-5xl md:text-6xl lg:text-7xl font-medium uppercase text-gray-900 mb-5">
              Trusted
              <span class="relative inline-block z-10">
                Clients
                <span class="absolute left-1 bottom-5 w-[96%] h-5 bg-yellow-400 -z-10"></span>
              </span>
            </h2>
          </div>
        </div>
      </div>

      <!-- Carousel Version -->
      <div v-if="clients.length > 0" ref="clientCarousel" class="owl-carousel client-carousel">
        <div v-for="client in clients" :key="client.id" class="client-item text-center p-4">
          <img
            :src="
              client.logo || `https://placehold.co/150x80/F5F6E4/1C1817?text=${client.nama_client}`
            "
            :alt="client.nama_client"
            class="mx-auto max-h-20 object-contain"
          />
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
          <i class="fi flaticon-user text-6xl text-gray-300"></i>
        </div>
        <p class="text-gray-600 text-lg">No clients available at the moment.</p>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick, inject } from 'vue'
import api, { type OurClient } from '@/services/api'
import $ from 'jquery'
import 'owl.carousel'

const clients = ref<OurClient[]>([])
const isLoading = ref(true)
const clientCarousel = ref<HTMLElement | null>(null)

// Inject dummy data
const dummyClients = inject<OurClient[]>('dummyClients', [])

const initCarousel = () => {
  const carousel = clientCarousel.value
  if (carousel && clients.value.length > 0) {
    nextTick(() => {
      $(carousel).owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
          0: { items: 2 },
          576: { items: 3 },
          768: { items: 4 },
          992: { items: 5 },
          1200: { items: 6 },
        },
      })
    })
  }
}

onMounted(async () => {
  try {
    isLoading.value = true

    // Use dummy data for testing
    if (dummyClients && dummyClients.length > 0) {
      clients.value = dummyClients
    } else {
      clients.value = await api.getOurClient()
    }

    initCarousel()
  } catch (error) {
    console.error('Error loading clients:', error)
    if (dummyClients && dummyClients.length > 0) {
      clients.value = dummyClients
      initCarousel()
    }
  } finally {
    isLoading.value = false
  }
})
</script>

<style scoped>
.client-item {
  transition: all 0.3s ease;
}

.client-item:hover {
  transform: translateY(-5px);
}

/* Owl Carousel Custom Dots */
:deep(.owl-dots) {
  text-align: center;
  margin-top: 40px;
}

:deep(.owl-dot) {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  display: inline-block;
  background: #e5f346;
  margin: 0 9px;
  position: relative;
  border: transparent;
  padding: 0;
}

:deep(.owl-dot.active) {
  background-color: #adb927;
}

:deep(.owl-dot.active::before) {
  position: absolute;
  top: 4px;
  left: 4px;
  width: 20px;
  height: 20px;
  content: '';
  border: 1px solid #adb927;
  border-radius: 50%;
  transform: translate(-50%, -50%);
}

/* Responsive adjustments */
@media (max-width: 640px) {
  .client-item {
    font-size: 0.875rem;
  }
}
</style>
