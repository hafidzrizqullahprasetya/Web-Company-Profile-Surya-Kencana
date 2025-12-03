<template>
    <section class="py-10 md:py-14 lg:py-15 bg-white scroll-mt-[210px] md:scroll-mt-[210px]" id="clients">
        <div class="container mx-auto px-4">
            <SectionTitle :label="siteSettings?.clients_label ?? undefined"
                :title="siteSettings?.clients_title ?? undefined" :icon="['fas', 'handshake']" label-variant="default"
                title-variant="default" margin-bottom="mb-8 md:mb-10 lg:mb-12" />

            <!-- Grid Layout with Pagination -->
            <div class="flex flex-col items-center">
                <div class="max-w-7xl mx-auto w-full">
                    <template v-if="isLoading || !clients || clients.length === 0">
                        <!-- Skeleton placeholders -->
                        <div class="flex flex-wrap justify-center gap-6">
                            <div v-for="n in 4" :key="'skeleton-' + n"
                                class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border-2 border-gray-200 shadow-sm w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(25%-1.5rem)] max-w-sm">
                                <div class="bg-gray-200 rounded-lg h-32 w-full mb-4 animate-pulse"></div>
                                <div class="bg-gray-200 h-5 w-3/4 rounded animate-pulse"></div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <!-- Sliding Container -->
                        <div class="relative w-full overflow-hidden">
                            <div class="flex cursor-grab active:cursor-grabbing select-none"
                                :class="{ 'transition-transform duration-700 ease-in-out': !isDragging }"
                                :style="{ transform: `translateX(calc(-${currentPage * 100}% + ${dragOffset}px))` }"
                                @mousedown="handleDragStart" @touchstart="handleTouchStart" @mousemove="handleDragMove"
                                @touchmove="handleTouchMove" @mouseup="handleDragEnd" @touchend="handleTouchEnd"
                                @mouseleave="handleDragEnd">
                                <!-- Each Page -->
                                <div v-for="(page, pageIndex) in paginatedClients" :key="`page-${pageIndex}`"
                                    class="w-full flex-shrink-0 px-3 md:px-4 lg:px-6">
                                    <div class="flex flex-wrap justify-center gap-4 md:gap-6">
                                        <div v-for="client in page" :key="client.id"
                                            class="flex flex-col items-center justify-center p-5 md:p-6 bg-white rounded-lg border-2 border-gray-200 shadow-sm hover:shadow-lg hover:border-primary transition-all duration-300 w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(25%-1.5rem)] max-w-sm">
                                            <template v-if="getLogoUrl(client)">
                                                <picture
                                                    class="w-full h-24 md:h-32 flex items-center justify-center mb-3 md:mb-4">
                                                    <source :srcset="getClientImageUrl(client, 'webp')"
                                                        type="image/webp" />
                                                    <source :srcset="getLogoUrl(client)" type="image/png" />
                                                    <img v-lazy="getLogoUrl(client)" :alt="client.client_name"
                                                        class="max-h-24 md:max-h-32 max-w-full object-contain transition-transform duration-300 hover:scale-110"
                                                        @error="handleImageError" />
                                                </picture>
                                            </template>
                                            <template v-else>
                                                <div
                                                    class="w-full h-24 md:h-32 flex items-center justify-center mb-3 md:mb-4">
                                                    <ImagePlaceholder variant="logo" size="md" text="No Logo"
                                                        :altText="`Logo ${client.client_name} tidak ditemukan`" />
                                                </div>
                                            </template>
                                            <span
                                                class="text-sm md:text-lg font-bold text-primary text-center leading-tight">
                                                {{ client.client_name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Pagination Controls -->
                <div v-if="!isLoading && clients && clients.length > 0" class="mt-8 md:mt-10 lg:mt-12">
                    <Pagination :current-page="currentPage" :total-pages="totalPages" variant="inverted"
                        @prev="prevPage" @next="nextPage" @goto="goToPage" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import type { OurClient } from '@/services/api'
import SectionTitle from './SectionTitle.vue'
import Pagination from './Pagination.vue'
import ImagePlaceholder from '@/components/common/ImagePlaceholder.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const clients = computed(() => landingPageData.value?.clients || [])
const siteSettings = computed(() => landingPageData.value?.siteSettings || null)

const currentPage = ref(0)
const isMobile = ref(false)

// Touch/Drag state
const isDragging = ref(false)
const startX = ref(0)
const currentX = ref(0)
const dragOffset = ref(0)
const dragThreshold = 50

// Responsive items per page
const itemsPerPage = computed(() => (isMobile.value ? 1 : 4))

// Calculate total pages
const totalPages = computed(() => {
    return Math.ceil(clients.value.length / itemsPerPage.value)
})

// Paginate clients into pages (for sliding animation)
const paginatedClients = computed(() => {
    const pages = []
    const perPage = itemsPerPage.value
    for (let i = 0; i < totalPages.value; i++) {
        const start = i * perPage
        const end = start + perPage
        pages.push(clients.value.slice(start, end))
    }
    return pages
})

// Navigation functions
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

const getClientImageUrl = (client: OurClient, format: string = 'webp'): string => {
    const url = getLogoUrl(client)
    if (
        url.includes('placehold.co') ||
        url.includes('ui-avatars.com') ||
        !url.match(/\.(jpg|jpeg|png)$/i)
    ) {
        return url
    }
    return url.replace(/\.(jpg|jpeg|png)$/i, `.${format}`)
}

const getLogoUrl = (client: OurClient): string => {
    if (client.logo_url) return client.logo_url
    if (client.logo_path) {
        if (client.logo_path.startsWith('http://') || client.logo_path.startsWith('https://')) {
            return client.logo_path
        }
        const cdnUrl = import.meta.env.VITE_CDN_URL || 'https://pub-2fb44babc7a4420e8fa728891ac101ef.r2.dev'
        return `${cdnUrl}/${client.logo_path}`
    }
    return 'https://placehold.co/300x200/e5e7eb/6b7280?text=No+Logo'
}

const handleImageError = (event: Event) => {
    const target = event.target as HTMLImageElement
    target.src = 'https://placehold.co/300x200/e5e7eb/6b7280?text=No+Logo'
}
</script>
