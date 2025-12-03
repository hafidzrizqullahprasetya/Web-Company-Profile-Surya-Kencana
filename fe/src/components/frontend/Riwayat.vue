<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <section class="relative py-10 md:py-14 lg:py-15 bg-primary scroll-mt-[130px] md:scroll-mt-[155px]" id="riwayat">
        <div class="container mx-auto px-4">
            <SectionTitle :label="siteSettings?.riwayat_label ?? undefined"
                :title="siteSettings?.riwayat_title ?? undefined" :icon="['fas', 'images']" label-variant="inverted"
                title-variant="white" margin-bottom="mb-8 md:mb-10 lg:mb-12" />

            <!-- History Cards with Pagination -->
            <div class="flex flex-col items-center gap-8 md:gap-8 lg:gap-10">
                <!-- Carousel Container -->
                <div class="relative w-full max-w-7xl overflow-hidden">
                    <!-- Sliding Track -->
                    <div class="flex cursor-grab active:cursor-grabbing select-none"
                        :class="{ 'transition-transform duration-700 ease-in-out': !isDragging }"
                        :style="{ transform: `translateX(calc(-${currentPage * 100}% + ${dragOffset}px))` }"
                        @mousedown="handleDragStart" @touchstart="handleTouchStart" @mousemove="handleDragMove"
                        @touchmove="handleTouchMove" @mouseup="handleDragEnd" @touchend="handleTouchEnd"
                        @mouseleave="handleDragEnd">
                        <!-- Each Page is a Slide -->
                        <div v-for="(page, pageIndex) in paginatedItems" :key="`page-${pageIndex}`"
                            class="w-full flex-shrink-0 px-3 md:px-4 lg:px-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-7">
                                <template v-if="isLoading || !historyItems || historyItems.length === 0">
                                    <!-- Skeleton cards -->
                                    <div v-for="n in 3" :key="'skeleton-' + n"
                                        class="bg-white rounded-lg md:rounded-xl shadow-lg overflow-hidden">
                                        <div class="relative h-40 md:h-48 lg:h-56 bg-gray-200 animate-pulse"></div>
                                        <div class="p-4 md:p-5 pb-5 md:pb-6">
                                            <div class="bg-gray-200 h-5 w-3/4 rounded animate-pulse mb-2">
                                            </div>
                                            <div class="bg-gray-200 h-3 w-full rounded animate-pulse mb-1">
                                            </div>
                                            <div class="bg-gray-200 h-3 w-5/6 rounded animate-pulse mb-1">
                                            </div>
                                            <div class="bg-gray-200 h-3 w-4/6 rounded animate-pulse"></div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div v-for="item in page" :key="item.id"
                                        class="bg-white rounded-lg md:rounded-xl shadow-lg overflow-hidden cursor-pointer group hover:shadow-xl transition-all duration-300"
                                        @click="openModal(item)">
                                        <!-- Image Section with Year Badge -->
                                        <div class="relative h-48 md:h-56 overflow-hidden">
                                            <!-- Background Image -->
                                            <div v-if="item.image_url"
                                                class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-110">
                                                <picture class="absolute inset-0 w-full h-full">
                                                    <source :srcset="getImageUrlForFormat(item.image_url, 'webp')"
                                                        type="image/webp" />
                                                    <source :srcset="item.image_url" type="image/jpeg" />
                                                    <img v-lazy="item.image_url"
                                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                                        :alt="`Riwayat ${item.tahun}`" />
                                                </picture>
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/20">
                                                </div>
                                            </div>

                                            <!-- Fallback if no image -->
                                            <div v-else
                                                class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-cream to-cream-light">
                                                <ImagePlaceholder variant="image" size="lg"
                                                    :text="`Riwayat ${item.tahun}`"
                                                    :altText="`Gambar riwayat tahun ${item.tahun} tidak ditemukan`" />
                                            </div>

                                            <!-- Year Badge (Only One) -->
                                            <div class="absolute top-3 left-3 md:top-4 md:left-4 z-10">
                                                <span
                                                    class="bg-primary text-white px-3 py-1.5 md:px-5 md:py-2 text-xs md:text-sm font-bold uppercase tracking-widest rounded-full shadow-xl">
                                                    {{ item.tahun }}
                                                </span>
                                            </div>

                                            <!-- Click to view indicator -->
                                            <div
                                                class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                                                <div
                                                    class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white text-primary px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold flex items-center gap-2">
                                                    <span>Lihat Detail</span>
                                                    <i class="fa-solid fa-arrow-right w-3 h-3 md:w-4 md:h-4"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Content Section (Only One Judul) -->
                                        <div class="p-4 md:p-5 pb-5 md:pb-6">
                                            <h3
                                                class="text-base md:text-xl font-epilogue font-bold uppercase tracking-wide mb-1.5 md:mb-2 text-primary">
                                                {{ item.judul }}
                                            </h3>
                                            <p class="text-gray-700 text-xs md:text-base leading-relaxed line-clamp-3">
                                                {{ item.deskripsi }}
                                            </p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Controls -->
            <Pagination v-if="!isLoading && historyItems && historyItems.length > 0" :current-page="currentPage"
                :total-pages="totalPages" @prev="prevPage" @next="nextPage" @goto="goToPage"
                class="mt-8 md:mt-10 lg:mt-12" />
        </div>

        <!-- Detail Modal -->
        <ImageGalleryModal :show="showModal" :images="selectedHistory ? getModalImages(selectedHistory) : []"
            :title="selectedHistory?.judul || ''" :description="selectedHistory?.deskripsi || ''"
            :badge="selectedHistory?.tahun.toString() || ''" @close="closeModal" />
    </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import type { CompanyHistory } from '@/services/api'
import SectionTitle from './SectionTitle.vue'
import Pagination from './Pagination.vue'
import ImageGalleryModal from './ImageGalleryModal.vue'
import ImagePlaceholder from '@/components/common/ImagePlaceholder.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const historyItems = computed(() => landingPageData.value?.companyHistory || [])
const siteSettings = computed(() => landingPageData.value?.siteSettings || null)

const currentPage = ref(0)
const isMobile = ref(false)

// Touch/Drag state
const isDragging = ref(false)
const startX = ref(0)
const currentX = ref(0)
const dragOffset = ref(0)
const dragThreshold = 50

// Modal state
const showModal = ref(false)
const selectedHistory = ref<CompanyHistory | null>(null)

// Responsive cards per page
const cardsPerPage = computed(() => (isMobile.value ? 1 : 3))

// Paginate items into pages (responsive: 1 card mobile, 3 cards desktop)
const paginatedItems = computed(() => {
    const pages: CompanyHistory[][] = []
    const itemsPerPage = cardsPerPage.value
    for (let i = 0; i < historyItems.value.length; i += itemsPerPage) {
        pages.push(historyItems.value.slice(i, i + itemsPerPage))
    }
    return pages
})

// Calculate total pages
const totalPages = computed(() => {
    return Math.ceil(historyItems.value.length / cardsPerPage.value)
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

// Touch/Drag handlers
const handleTouchStart = (e: TouchEvent) => {
    if (totalPages.value <= 1) return
    isDragging.value = true
    if (e.touches && e.touches[0]) {
        startX.value = e.touches[0].clientX
        currentX.value = e.touches[0].clientX
    }
    dragOffset.value = 0
}

const handleDragStart = (e: MouseEvent) => {
    if (totalPages.value <= 1) return
    isDragging.value = true
    startX.value = e.clientX
    currentX.value = e.clientX
    dragOffset.value = 0
    e.preventDefault()
}

const handleTouchMove = (e: TouchEvent) => {
    if (!isDragging.value) return
    if (e.touches && e.touches[0]) {
        currentX.value = e.touches[0].clientX
    }
    dragOffset.value = currentX.value - startX.value
}

const handleDragMove = (e: MouseEvent) => {
    if (!isDragging.value) return
    currentX.value = e.clientX
    dragOffset.value = currentX.value - startX.value
}

const handleTouchEnd = () => {
    if (!isDragging.value) return
    handleSwipe()
}

const handleDragEnd = () => {
    if (!isDragging.value) return
    handleSwipe()
}

const handleSwipe = () => {
    const diff = dragOffset.value

    // Check if drag distance exceeds threshold
    if (Math.abs(diff) > dragThreshold) {
        if (diff < 0) {
            // Dragged left - next page
            nextPage()
        } else {
            // Dragged right - prev page
            prevPage()
        }
    }

    // Reset drag state
    isDragging.value = false
    startX.value = 0
    currentX.value = 0
    dragOffset.value = 0
}

// Check if mobile and reset page if needed
const checkMobile = () => {
    const wasMobile = isMobile.value
    isMobile.value = window.innerWidth < 768

    // Reset to first page when switching between mobile/desktop if current page is out of bounds
    if (wasMobile !== isMobile.value) {
        if (currentPage.value >= totalPages.value) {
            currentPage.value = 0
        }
    }
}

onMounted(() => {
    checkMobile()
    window.addEventListener('resize', checkMobile)
})

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile)
})

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
