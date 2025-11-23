<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-cream-light" id="produk">
    <div class="container mx-auto px-4">
      <SectionTitle
        :label="settings?.produk_label"
        :title="formatTitle(settings?.produk_title)"
        :icon="['fas', 'box']"
        label-variant="default"
        title-variant="default"
        margin-bottom="mb-16"
      />

      <div class="mb-12">
        <div class="flex justify-center items-center gap-4">
          <!-- Left Arrow -->
          <button
            v-if="products.length > 3"
            @click="scrollTabsLeft"
            class="flex-shrink-0 w-10 h-10 bg-primary text-white rounded-full hover:bg-secondary transition-all duration-300 flex items-center justify-center hover:scale-110"
            aria-label="Scroll tabs left"
          >
            <font-awesome-icon :icon="['fas', 'chevron-left']" class="w-5 h-5" />
          </button>

          <!-- Tabs Container with Scroll - Fixed Width untuk pas 3 tabs -->
          <div class="relative p-2 border-2 border-primary rounded-full" style="width: 1034px">
            <div class="overflow-hidden">
              <div
                ref="tabsContainer"
                class="inline-flex gap-3 transition-transform duration-300 ease-in-out"
                :style="{ transform: `translateX(-${scrollPosition}px)` }"
              >
                <button
                  v-for="(product, index) in products"
                  :key="product.id"
                  @click="goToPage(index)"
                  class="px-6 py-3 rounded-full font-semibold text-lg transition-all duration-300 flex items-center justify-center text-center flex-shrink-0"
                  style="width: 330px; min-height: 56px"
                  :class="
                    currentPage === index
                      ? 'bg-primary text-white shadow-md'
                      : 'bg-transparent text-primary hover:bg-primary hover:text-white'
                  "
                >
                  <span class="line-clamp-2">{{ product.name }}</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Right Arrow -->
          <button
            v-if="products.length > 3"
            @click="scrollTabsRight"
            class="flex-shrink-0 w-10 h-10 bg-primary text-white rounded-full hover:bg-secondary transition-all duration-300 flex items-center justify-center hover:scale-110"
            aria-label="Scroll tabs right"
          >
            <font-awesome-icon :icon="['fas', 'chevron-right']" class="w-5 h-5" />
          </button>
        </div>

        <!-- Page Dots - Show dots for all products -->
         <div
          v-if="!isLoading && products && products.length > 3"
          class="flex items-center gap-3 justify-center mt-6"
        >
          <button
            v-for="slideIndex in Math.ceil(products.length / 3)"
            :key="`slide-${slideIndex}`"
            @click="goToSlide(slideIndex - 1)"
            class="transition-all duration-500 ease-in-out transform"
            :class="
              currentSlide === slideIndex - 1
                ? 'w-12 h-3 bg-primary rounded-full shadow-lg scale-110'
                : 'w-3 h-3 bg-primary/40 rounded-full hover:bg-primary/60 hover:scale-125'
            "
            :aria-label="`Go to slide ${slideIndex}`"
          />
        </div>
      </div>

      <!-- Products Display (No Animation) -->
      <div class="relative w-full">
        <template v-if="isLoading || !products || products.length === 0">
          <!-- Skeleton -->
          <div class="grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-16 items-start">
            <!-- Skeleton Main Image -->
            <div class="relative bg-gray-200 rounded-xl p-8 shadow-xl animate-pulse h-[564px]">
              <div class="w-full h-full bg-gray-300 rounded-lg"></div>
            </div>
            <!-- Skeleton Info -->
            <div class="bg-gray-200 rounded-xl p-8 shadow-xl animate-pulse h-[564px]">
              <div class="bg-gray-300 h-6 w-3/4 rounded mb-4"></div>
              <div class="bg-gray-300 h-4 w-full rounded mb-2"></div>
              <div class="bg-gray-300 h-4 w-5/6 rounded mb-2"></div>
              <div class="bg-gray-300 h-4 w-4/5 rounded"></div>
            </div>
          </div>
        </template>
        <template v-else>
          <div
            v-for="(product, index) in products"
            :key="product.id"
            v-show="currentPage === index"
            class="grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-16 items-start"
          >
            <!-- Main Image - Fixed Height -->
            <div
              class="relative bg-primary rounded-xl p-8 shadow-xl group cursor-pointer h-[564px]"
              @click="openModal(product)"
            >
              <div class="relative w-full h-full overflow-hidden rounded-lg">
                <picture>
                  <source
                    :srcset="getImageUrlForFormat(getProductMainImage(product), 'webp')"
                    type="image/webp"
                  />
                  <source :srcset="getProductMainImage(product)" type="image/jpeg" />
                  <img
                    v-lazy="getProductMainImage(product)"
                    :alt="product.name"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    @error="handleImageError"
                  />
                </picture>

                <!-- Overlay "Lihat Detail" -->
                <div
                  class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center rounded-lg"
                >
                  <div
                    class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white text-primary px-6 py-3 rounded-full text-base font-semibold flex items-center gap-2"
                  >
                    <span>Lihat Detail</span>
                    <font-awesome-icon :icon="['fas', 'arrow-right']" class="w-5 h-5" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Product Info Card - Fixed Height -->
            <div class="bg-primary rounded-xl overflow-hidden shadow-xl sticky top-5 h-[564px]">
              <div class="p-8 bg-primary h-full flex flex-col">
                <!-- Product Name - Fixed Height -->
                <div class="mb-2 pb-2 border-b border-white/10 min-h-[60px]">
                  <h3
                    class="text-2xl font-epilogue font-bold text-white uppercase tracking-wide line-clamp-2"
                  >
                    {{ product.name }}
                  </h3>
                </div>

                <!-- Description - Fixed Height with Scroll -->
                <div class="mb-6 flex-1 min-h-0">
                  <div
                    class="h-full overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent"
                  >
                    <p class="text-white/90 text-base leading-relaxed">
                      {{ product.description }}
                    </p>
                  </div>
                </div>

                <!-- Price - Fixed Height -->
                <div class="mb-6 p-4 bg-white/10 rounded-lg">
                  <div
                    class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-white/70 mb-2"
                  >
                    <font-awesome-icon :icon="['fas', 'tag']" class="w-4 h-4" />
                    <span>HARGA</span>
                  </div>
                  <div class="text-3xl font-epilogue font-bold text-white">
                    {{ formatPrice(product.price) }}
                  </div>
                </div>

                <!-- Button - Fixed at Bottom -->
                <div class="pt-6 border-t border-white/10">
                  <BadgeButton
                    :href="getWhatsappUrl(product.name)"
                    target="_blank"
                    variant="inverted"
                    class="w-full"
                  >
                    <span>Hubungi Kami</span>
                    <font-awesome-icon :icon="['fas', 'arrow-right']" class="w-5 h-5" />
                  </BadgeButton>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>

      <!-- Pagination Controls Below Product Cards -->
      <div v-if="!isLoading && products && products.length > 1" class="mt-12">
        <div class="flex flex-col items-center gap-6">
          <!-- Page Dots -->
          <div class="flex items-center gap-3 flex-wrap justify-center max-w-2xl">
            <button
              v-for="pageIndex in products.length"
              :key="`page-bottom-${pageIndex}`"
              @click="goToPage(pageIndex - 1)"
              class="transition-all duration-500 ease-in-out transform"
              :class="
                currentPage === pageIndex - 1
                  ? 'w-12 h-3 bg-primary rounded-full shadow-lg scale-110'
                  : 'w-3 h-3 bg-primary/40 rounded-full hover:bg-primary/60 hover:scale-125'
              "
              :aria-label="`Go to page ${pageIndex}`"
            />
          </div>

          <!-- Navigation Buttons -->
          <div class="flex items-center gap-6">
            <button
              @click="prevPage"
              :disabled="currentPage === 0"
              class="w-12 h-12 bg-primary text-white rounded-full hover:bg-secondary transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed hover:shadow-xl disabled:hover:shadow-none flex items-center justify-center group transform"
              :class="currentPage === 0 ? '' : 'hover:-translate-x-1 hover:scale-110'"
              aria-label="Previous page"
            >
              <font-awesome-icon :icon="['fas', 'chevron-left']" class="w-6 h-6" />
            </button>

            <div
              class="text-primary text-sm font-semibold bg-primary/10 px-6 py-2 rounded-full backdrop-blur-sm"
            >
              Page {{ currentPage + 1 }} of {{ products.length }}
            </div>

            <button
              @click="nextPage"
              :disabled="currentPage === products.length - 1"
              class="w-12 h-12 bg-primary text-white rounded-full hover:bg-secondary transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed hover:shadow-xl disabled:hover:shadow-none flex items-center justify-center group transform"
              :class="
                currentPage === products.length - 1 ? '' : 'hover:translate-x-1 hover:scale-110'
              "
              aria-label="Next page"
            >
              <font-awesome-icon :icon="['fas', 'chevron-right']" class="w-6 h-6" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <ImageGalleryModal
      :show="showModal"
      :images="selectedProduct ? getProductImageUrls(selectedProduct) : []"
      :title="selectedProduct?.name || ''"
      :description="selectedProduct?.description || ''"
      :badge="selectedProduct?.price !== undefined ? formatPrice(selectedProduct.price) : ''"
      @close="closeModal"
    />
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import type { Product } from '@/services/api'
import SectionTitle from './SectionTitle.vue'
import BadgeButton from './BadgeButton.vue'
import ImageGalleryModal from './ImageGalleryModal.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const products = computed(() => landingPageData.value?.products || [])
const settings = computed(() => landingPageData.value?.siteSettings || null)
const contactInfo = computed(() => landingPageData.value?.contact || null)

const currentPage = ref(0)
const tabsContainer = ref<HTMLElement | null>(null)
const scrollPosition = ref(0)

// Modal state
const showModal = ref(false)
const selectedProduct = ref<Product | null>(null)

// Computed untuk track slide tab saat ini (bukan produk page)
const currentSlide = computed(() => {
  return Math.floor(scrollPosition.value / 342)
})

// Function untuk jump ke slide tertentu
const goToSlide = (slideIndex: number) => {
  const tabWidth = 342 // 330px width + 12px gap
  const maxScroll = Math.max(0, (products.value.length - 3) * tabWidth)
  const targetScroll = slideIndex * tabWidth
  scrollPosition.value = Math.min(maxScroll, targetScroll)
}

// Scroll tabs navigation (untuk geser tab horizontal dengan transform)
const scrollTabsLeft = () => {
  // Geser 1 tab ke kiri (330px width + 12px gap)
  scrollPosition.value = Math.max(0, scrollPosition.value - 342)
}

const scrollTabsRight = () => {
  // Geser 1 tab ke kanan (330px width + 12px gap)
  const tabWidth = 342 // 330px width + 12px gap
  const maxScroll = Math.max(0, (products.value.length - 3) * tabWidth)
  scrollPosition.value = Math.min(maxScroll, scrollPosition.value + 342)
}
// Page Navigation
const prevPage = () => {
  if (currentPage.value > 0) {
    currentPage.value--
  }
}

const nextPage = () => {
  if (currentPage.value < products.value.length - 1) {
    currentPage.value++
  }
}

const goToPage = (page: number) => {
  if (page >= 0 && page < products.value.length) {
    currentPage.value = page

    // Auto-scroll tabs to show the selected tab (always keep it visible)
    if (products.value.length > 3) {
      const tabWidth = 342 // 330px width + 12px gap
      const maxScroll = Math.max(0, (products.value.length - 3) * tabWidth)

      // Calculate which tabs are currently visible
      const currentScrollTab = Math.floor(scrollPosition.value / tabWidth)
      const visibleTabsStart = currentScrollTab
      const visibleTabsEnd = currentScrollTab + 2 // 3 tabs visible (0,1,2)

      // If selected page is outside visible range, scroll to make it visible
      if (page < visibleTabsStart) {
        // Scroll left to show selected tab
        scrollPosition.value = page * tabWidth
      } else if (page > visibleTabsEnd) {
        // Scroll right to show selected tab as the last visible tab
        scrollPosition.value = Math.min(maxScroll, (page - 2) * tabWidth)
      }
      // If page is already visible, don't scroll
    }
  }
}

// Get all product images (for modal)
const getProductImageUrls = (product: Product | null): string[] => {
  if (!product) return []

  const urls: string[] = []

  if (product.image_urls && product.image_urls.length > 0) {
    urls.push(...product.image_urls)
  }

  if (product.image_url && !urls.includes(product.image_url)) {
    urls.unshift(product.image_url)
  }

  if (urls.length === 0) {
    return [getImageUrl(undefined)]
  }

  return urls
}

// Get main image for product card
const getProductMainImage = (product: Product): string => {
  if (product.image_url) {
    return getImageUrl(product.image_url)
  }
  if (product.image_urls && product.image_urls.length > 0) {
    return getImageUrl(product.image_urls[0])
  }
  return getImageUrl(undefined)
}

// Modal functions
const openModal = (product: Product) => {
  selectedProduct.value = product
  showModal.value = true
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  showModal.value = false
  selectedProduct.value = null
  document.body.style.overflow = ''
}

// WhatsApp URL with product name
const getWhatsappUrl = (productName: string) => {
  if (contactInfo.value?.phone) {
    const phoneNumber = contactInfo.value.phone.replace(/[^\d+]/g, '')
    let formattedNumber = phoneNumber
    if (phoneNumber.startsWith('0')) {
      formattedNumber = '62' + phoneNumber.substring(1)
    } else if (phoneNumber.startsWith('8')) {
      formattedNumber = '62' + phoneNumber
    }

    const message = encodeURIComponent(`Halo, saya ingin bertanya tentang produk: ${productName}`)
    return `https://wa.me/${formattedNumber}?text=${message}`
  }
  return '#'
}

const formatTitle = (title?: string) => {
  if (!title) return ''
  return title.replace(/\n/g, '<br />')
}

const getImageUrl = (imagePath: string | undefined): string => {
  if (!imagePath) {
    return 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'
  }
  if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
    return imagePath
  }
  const cdnUrl = import.meta.env.VITE_CDN_URL || 'https://pub-2fb44babc7a4420e8fa728891ac101ef.r2.dev'
  return `${cdnUrl}/${imagePath}`
}

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement
  target.src = 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'
}

const formatPrice = (price: number | undefined): string => {
  if (!price) return 'Rp 0'
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(price)
}

const getImageUrlForFormat = (url: string, format: string = 'webp'): string => {
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

<style scoped>
/* Hide scrollbar but keep functionality */
.scrollbar-hide {
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}

.scrollbar-hide::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Opera */
}

/* Custom Scrollbar for Description */
.scrollbar-thin {
  scrollbar-width: thin;
  scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
}

.scrollbar-thin::-webkit-scrollbar {
  width: 6px;
}

.scrollbar-thin::-webkit-scrollbar-track {
  background: transparent;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 3px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.3);
}
</style>
