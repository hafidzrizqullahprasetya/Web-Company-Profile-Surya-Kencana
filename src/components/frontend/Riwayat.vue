<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-primary overflow-hidden" id="riwayat">
    <div class="container mx-auto px-4">
      <div class="text-center mb-20">
        <div class="inline-block mb-6">
          <span
            class="bg-white text-primary px-6 py-3 text-xs font-semibold uppercase tracking-widest"
          >
            {{ siteSettings?.riwayat_label || 'RIWAYAT PERUSAHAAN' }}
          </span>
        </div>
        <h2
          class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-epilogue font-bold text-white leading-tight uppercase tracking-wide mb-10"
          v-html="siteSettings?.riwayat_title || 'PERJALANAN <span class=\'text-white relative\'>KAMI<div class=\'absolute -bottom-1 left-0 w-full h-3 bg-primary -z-10\'></div></span><br />SELAMA INI.'"
        >
        </h2>
      </div>

      <div v-if="isLoading" class="flex flex-col items-center justify-center py-16 text-center">
        <div
          class="w-10 h-10 border-4 border-white/30 border-t-white rounded-full animate-spin mb-4"
        ></div>
        <p class="text-white text-base">Loading company history...</p>
      </div>

      <div v-else-if="error" class="flex flex-col items-center justify-center py-16 text-center">
        <p class="text-red-500 text-base mb-4 font-medium">{{ error }}</p>
        <button
          @click="retryFetch"
          class="bg-white text-primary px-6 py-3 text-sm font-semibold rounded-md transition-all duration-300 hover:bg-white/90"
        >
          Coba Lagi
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="!historyItems || historyItems.length === 0" class="flex flex-col items-center justify-center py-20 text-center">
        <div class="mb-4">
          <svg class="w-16 h-16 text-white/40 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <p class="text-white text-base">No company history available yet</p>
      </div>

      <!-- Photo Album Slider -->
      <div v-else class="relative max-w-7xl mx-auto">
        <!-- Slider Container -->
        <div class="relative">
          <!-- Slides -->
          <div class="overflow-hidden">
            <div
              class="flex transition-transform duration-500 ease-out"
              :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
            >
              <div
                v-for="(page, pageIndex) in pagedItems"
                :key="pageIndex"
                class="w-full flex-shrink-0 px-4"
              >
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                  <div
                    v-for="item in page"
                    :key="item.id"
                    class="bg-white rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer transform hover:scale-105"
                    @click="openModal(item)"
                  >
                    <!-- Image Section -->
                    <div class="relative h-48 overflow-hidden">
                      <!-- Background Image or Gradient -->
                      <div
                        v-if="item.image_url"
                        class="absolute inset-0 bg-cover bg-center"
                        :style="{ backgroundImage: `url(${item.image_url})` }"
                      >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-black/20"></div>
                      </div>
                      <div
                        v-else
                        class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/40"
                      >
                        <div
                          class="absolute inset-0 flex items-center justify-center text-white/15 font-bold text-7xl"
                        >
                          {{ item.tahun }}
                        </div>
                      </div>

                      <!-- Year Badge -->
                      <div class="absolute top-4 left-4 z-10">
                        <span
                          class="bg-primary text-white px-4 py-2 text-sm font-bold uppercase tracking-wide rounded-full shadow-lg"
                        >
                          {{ item.tahun }}
                        </span>
                      </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-6">
                      <h3
                        class="text-xl font-epilogue font-bold uppercase tracking-wide mb-3 text-primary"
                      >
                        {{ item.judul }}
                      </h3>
                      <p class="text-gray-700 text-sm leading-relaxed line-clamp-3">
                        {{ item.deskripsi }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <button
            @click="prevSlide"
            class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 md:-translate-x-6 bg-white text-primary p-3 md:p-4 rounded-full shadow-lg hover:bg-white/90 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="currentSlide === 0"
          >
            <svg
              class="w-5 h-5 md:w-6 md:h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7"
              />
            </svg>
          </button>

          <button
            @click="nextSlide"
            class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 md:translate-x-6 bg-white text-primary p-3 md:p-4 rounded-full shadow-lg hover:bg-white/90 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="currentSlide === totalPages - 1"
          >
            <svg
              class="w-5 h-5 md:w-6 md:h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              />
            </svg>
          </button>
        </div>

        <!-- Indicators -->
        <div class="flex justify-center mt-8 gap-2">
          <button
            v-for="pageNum in totalPages"
            :key="pageNum"
            @click="goToSlide(pageNum - 1)"
            class="transition-all duration-300 rounded-full focus:outline-none"
            :class="
              currentSlide === pageNum - 1
                ? 'w-8 h-3 bg-white'
                : 'w-3 h-3 bg-white/40 hover:bg-white/60'
            "
          ></button>
        </div>

        <!-- Counter -->
        <div class="text-center mt-4 text-white/80 text-sm">
          {{ currentSlide + 1 }} / {{ totalPages }}
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div
      v-if="showModal && selectedHistory"
      class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80"
      @click.self="closeModal"
    >
      <div class="bg-white rounded-2xl max-w-5xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center rounded-t-2xl z-10">
          <div>
            <span class="bg-primary text-white px-4 py-1.5 text-sm font-bold uppercase rounded-full">
              {{ selectedHistory.tahun }}
            </span>
          </div>
          <button
            @click="closeModal"
            class="text-gray-500 hover:text-gray-700 transition p-2 rounded-full hover:bg-gray-100"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
          <!-- Image Slider -->
          <div v-if="selectedHistory.image_urls && selectedHistory.image_urls.length > 0" class="mb-6">
            <div class="relative rounded-xl overflow-hidden bg-gray-100">
              <!-- Main Image -->
              <div class="relative h-96">
                <img
                  :src="selectedHistory.image_urls[currentImageIndex]"
                  :alt="`${selectedHistory.judul} - Image ${currentImageIndex + 1}`"
                  class="w-full h-full object-cover"
                />

                <!-- Navigation Arrows (only show if multiple images) -->
                <template v-if="selectedHistory.image_urls.length > 1">
                  <button
                    @click="prevImage"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-primary p-3 rounded-full shadow-lg transition"
                  >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                  </button>
                  <button
                    @click="nextImage"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-primary p-3 rounded-full shadow-lg transition"
                  >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </button>
                </template>

                <!-- Image Counter -->
                <div v-if="selectedHistory.image_urls.length > 1" class="absolute bottom-4 right-4 bg-black/60 text-white px-3 py-1.5 rounded-full text-sm font-medium">
                  {{ currentImageIndex + 1 }} / {{ selectedHistory.image_urls.length }}
                </div>
              </div>

              <!-- Thumbnail Navigation (only show if multiple images) -->
              <div v-if="selectedHistory.image_urls.length > 1" class="flex gap-2 p-4 overflow-x-auto">
                <button
                  v-for="(img, index) in selectedHistory.image_urls"
                  :key="index"
                  @click="goToImage(index)"
                  class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 transition"
                  :class="currentImageIndex === index ? 'border-primary ring-2 ring-primary' : 'border-gray-300 hover:border-gray-400'"
                >
                  <img :src="img" :alt="`Thumbnail ${index + 1}`" class="w-full h-full object-cover" />
                </button>
              </div>
            </div>
          </div>

          <!-- Fallback if no images -->
          <div v-else class="mb-6 h-96 bg-gradient-to-br from-primary/20 to-primary/40 rounded-xl flex items-center justify-center">
            <div class="text-white/20 font-bold text-9xl">
              {{ selectedHistory.tahun }}
            </div>
          </div>

          <!-- Content -->
          <div class="space-y-4">
            <h2 class="text-3xl font-epilogue font-bold text-primary uppercase">
              {{ selectedHistory.judul }}
            </h2>
            <div class="prose prose-lg max-w-none">
              <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                {{ selectedHistory.deskripsi }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import api, { type SiteSetting } from '@/services/api'

interface HistoryItem {
  id: number
  tahun: number
  judul: string
  deskripsi: string
  image_path: string | null
  image_url: string | null
  images: string[]
  image_urls: string[]
}

const historyItems = ref<HistoryItem[]>([])
const siteSettings = ref<SiteSetting | null>(null)
const isLoading = ref(true)
const error = ref<string | null>(null)
const currentSlide = ref(0)
const itemsPerPage = 3

// Modal state
const showModal = ref(false)
const selectedHistory = ref<HistoryItem | null>(null)
const currentImageIndex = ref(0)

// Touch/Swipe support
let touchStartX = 0
let touchEndX = 0

// Computed: Group items into pages
const pagedItems = computed(() => {
  const pages: HistoryItem[][] = []
  for (let i = 0; i < historyItems.value.length; i += itemsPerPage) {
    pages.push(historyItems.value.slice(i, i + itemsPerPage))
  }
  return pages
})

// Computed: Total number of pages
const totalPages = computed(() => pagedItems.value.length)

const fetchHistory = async () => {
  try {
    isLoading.value = true
    error.value = null

    // Fetch from API
    const [historyData, settingsData] = await Promise.all([
      api.getCompanyHistories(),
      api.getSiteSettings()
    ])

    historyItems.value = historyData
    siteSettings.value = settingsData

    console.log('History data:', historyItems.value)
  } catch (err) {
    console.error('Error fetching company history:', err)
    const message =
      (err as { response?: { data?: { message?: string } } })?.response?.data?.message ||
      'Gagal memuat riwayat perusahaan'
    error.value = message
    historyItems.value = []
  } finally {
    isLoading.value = false
  }
}

const retryFetch = () => {
  fetchHistory()
}

// Slider Navigation
const nextSlide = () => {
  if (currentSlide.value < totalPages.value - 1) {
    currentSlide.value++
  }
}

const prevSlide = () => {
  if (currentSlide.value > 0) {
    currentSlide.value--
  }
}

const goToSlide = (index: number) => {
  if (index >= 0 && index < totalPages.value) {
    currentSlide.value = index
  }
}

// Modal functions
const openModal = (item: HistoryItem) => {
  selectedHistory.value = item
  currentImageIndex.value = 0
  showModal.value = true
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  showModal.value = false
  selectedHistory.value = null
  currentImageIndex.value = 0
  document.body.style.overflow = ''
}

const nextImage = () => {
  if (selectedHistory.value && selectedHistory.value.image_urls.length > 0) {
    currentImageIndex.value = (currentImageIndex.value + 1) % selectedHistory.value.image_urls.length
  }
}

const prevImage = () => {
  if (selectedHistory.value && selectedHistory.value.image_urls.length > 0) {
    currentImageIndex.value = currentImageIndex.value === 0
      ? selectedHistory.value.image_urls.length - 1
      : currentImageIndex.value - 1
  }
}

const goToImage = (index: number) => {
  currentImageIndex.value = index
}

// Keyboard navigation
const handleKeydown = (event: KeyboardEvent) => {
  if (event.key === 'ArrowLeft') {
    prevSlide()
  } else if (event.key === 'ArrowRight') {
    nextSlide()
  }
}

// Touch swipe handlers
const handleTouchStart = (event: TouchEvent) => {
  if (event.touches[0]) {
    touchStartX = event.touches[0].clientX
  }
}

const handleTouchMove = (event: TouchEvent) => {
  if (event.touches[0]) {
    touchEndX = event.touches[0].clientX
  }
}

const handleTouchEnd = () => {
  const swipeThreshold = 50
  const swipeDistance = touchStartX - touchEndX

  if (Math.abs(swipeDistance) > swipeThreshold) {
    if (swipeDistance > 0) {
      nextSlide()
    } else {
      prevSlide()
    }
  }

  touchStartX = 0
  touchEndX = 0
}

onMounted(() => {
  fetchHistory()

  // Add keyboard navigation
  window.addEventListener('keydown', handleKeydown)

  // Add touch swipe support
  const slider = document.querySelector('.overflow-hidden')
  if (slider) {
    slider.addEventListener('touchstart', handleTouchStart as EventListener)
    slider.addEventListener('touchmove', handleTouchMove as EventListener)
    slider.addEventListener('touchend', handleTouchEnd)
  }
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown)

  const slider = document.querySelector('.overflow-hidden')
  if (slider) {
    slider.removeEventListener('touchstart', handleTouchStart as EventListener)
    slider.removeEventListener('touchmove', handleTouchMove as EventListener)
    slider.removeEventListener('touchend', handleTouchEnd)
  }
})
</script>
