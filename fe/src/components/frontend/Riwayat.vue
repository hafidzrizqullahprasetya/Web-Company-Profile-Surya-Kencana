<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-primary" id="riwayat">
    <div class="container mx-auto px-4">
      <SectionTitle
        :label="siteSettings?.riwayat_label"
        :title="siteSettings?.riwayat_title"
        :icon="['fas', 'images']"
        label-variant="inverted"
        title-variant="white"
      />

      <!-- History Cards with Pagination -->
      <div class="flex flex-col items-center gap-12">
        <!-- Carousel Container -->
        <div class="relative w-full max-w-7xl overflow-hidden">
          <!-- Sliding Track -->
          <div
            class="flex transition-transform duration-700 ease-in-out"
            :style="{ transform: `translateX(-${currentPage * 100}%)` }"
          >
            <!-- Each Page is a Slide -->
            <div
              v-for="(page, pageIndex) in paginatedItems"
              :key="`page-${pageIndex}`"
              class="w-full flex-shrink-0"
            >
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
                <template v-if="isLoading || !historyItems || historyItems.length === 0">
                  <!-- Skeleton cards -->
                  <div
                    v-for="n in 3"
                    :key="'skeleton-' + n"
                    class="bg-white rounded-2xl shadow-2xl overflow-hidden"
                  >
                    <div class="relative h-64 bg-gray-200 animate-pulse"></div>
                    <div class="p-6 pb-8">
                      <div class="bg-gray-200 h-6 w-3/4 rounded animate-pulse mb-3"></div>
                      <div class="bg-gray-200 h-4 w-full rounded animate-pulse mb-2"></div>
                      <div class="bg-gray-200 h-4 w-5/6 rounded animate-pulse mb-2"></div>
                      <div class="bg-gray-200 h-4 w-4/6 rounded animate-pulse"></div>
                    </div>
                  </div>
                </template>
                <template v-else>
                  <div
                    v-for="item in page"
                    :key="item.id"
                    class="bg-white rounded-2xl shadow-2xl overflow-hidden cursor-pointer group hover:shadow-[0_20px_60px_rgba(0,0,0,0.3)] transition-all duration-300"
                    @click="openModal(item)"
                  >
                    <!-- Image Section with Year Badge -->
                    <div class="relative h-64 overflow-hidden">
                      <!-- Background Image -->
                      <div
                        v-if="item.image_url"
                        class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-110"
                      >
                        <picture class="absolute inset-0 w-full h-full">
                          <source
                            :srcset="getImageUrlForFormat(item.image_url, 'webp')"
                            type="image/webp"
                          />
                          <source :srcset="item.image_url" type="image/jpeg" />
                          <img
                            v-lazy="item.image_url"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                            :alt="`Riwayat ${item.tahun}`"
                          />
                        </picture>
                        <div
                          class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/20"
                        ></div>
                      </div>

                      <!-- Fallback if no image -->
                      <div
                        v-else
                        class="absolute inset-0 bg-gradient-to-br from-cream to-cream-light"
                      >
                        <div
                          class="absolute inset-0 flex items-center justify-center text-primary/10 font-bold text-8xl"
                        >
                          {{ item.tahun }}
                        </div>
                      </div>

                      <!-- Year Badge (Only One) -->
                      <div class="absolute top-4 left-4 z-10">
                        <span
                          class="bg-primary text-white px-5 py-2 text-sm font-bold uppercase tracking-widest rounded-full shadow-xl"
                        >
                          {{ item.tahun }}
                        </span>
                      </div>

                      <!-- Click to view indicator -->
                      <div
                        class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center"
                      >
                        <div
                          class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white text-primary px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2"
                        >
                          <span>Lihat Detail</span>
                          <i class="fa-solid fa-arrow-right w-4 h-4"></i>
                        </div>
                      </div>
                    </div>

                    <!-- Content Section (Only One Judul) -->
                    <div class="p-6 pb-8">
                      <h3
                        class="text-xl font-epilogue font-bold uppercase tracking-wide mb-2 text-primary"
                      >
                        {{ item.judul }}
                      </h3>
                      <p class="text-gray-700 text-base leading-relaxed line-clamp-3">
                        {{ item.deskripsi }}
                      </p>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>

        <!-- Navigation Controls -->
        <Pagination
          v-if="!isLoading && historyItems && historyItems.length > 0"
          :current-page="currentPage"
          :total-pages="totalPages"
          @prev="prevPage"
          @next="nextPage"
          @goto="goToPage"
        />
      </div>
    </div>

    <!-- Detail Modal -->
    <ImageGalleryModal
      :show="showModal"
      :images="selectedHistory ? getModalImages(selectedHistory) : []"
      :title="selectedHistory?.judul || ''"
      :description="selectedHistory?.deskripsi || ''"
      :badge="selectedHistory?.tahun.toString() || ''"
      @close="closeModal"
    />
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import type { CompanyHistory } from '@/services/api'
import SectionTitle from './SectionTitle.vue'
import Pagination from './Pagination.vue'
import ImageGalleryModal from './ImageGalleryModal.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const historyItems = computed(() => landingPageData.value?.companyHistory || [])
const siteSettings = computed(() => landingPageData.value?.siteSettings || null)

const currentPage = ref(0)
const cardsPerPage = 3

// Modal state
const showModal = ref(false)
const selectedHistory = ref<CompanyHistory | null>(null)

// Paginate items into pages (each page has 3 items)
const paginatedItems = computed(() => {
  const pages: CompanyHistory[][] = []
  for (let i = 0; i < historyItems.value.length; i += cardsPerPage) {
    pages.push(historyItems.value.slice(i, i + cardsPerPage))
  }
  return pages
})

// Calculate total pages
const totalPages = computed(() => {
  return Math.ceil(historyItems.value.length / cardsPerPage)
})

// Page Navigation - NO SCROLL
const prevPage = () => {
  if (currentPage.value > 0) {
    currentPage.value--
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value - 1) {
    currentPage.value++
  }
}

const goToPage = (page: number) => {
  if (page >= 0 && page < totalPages.value) {
    currentPage.value = page
  }
}

const getModalImages = (history: CompanyHistory | null): string[] => {
  if (!history) return []

  if (history.image_urls && history.image_urls.length > 0) {
    return history.image_urls
  }

  if (history.image_url) {
    return [history.image_url]
  }

  return []
}

// Modal functions
const openModal = (item: CompanyHistory) => {
  selectedHistory.value = item
  showModal.value = true
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  showModal.value = false
  selectedHistory.value = null
  document.body.style.overflow = ''
}

const getImageUrlForFormat = (url: string | undefined, format: string = 'webp'): string => {
  if (!url) {
    return 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'
  }

  if (
    url.includes('placehold.co') ||
    url.includes('ui-avatars.com') ||
    !url.match(/\.(jpg|jpeg|png)$/i)
  ) {
    return url
  }
  return url.replace(/\.(jpg|jpeg|png)$/i, `.${format}`)
}
</script>
