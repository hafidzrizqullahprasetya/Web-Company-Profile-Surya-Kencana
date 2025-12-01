<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <section class="relative py-10 md:py-14 lg:py-15 bg-cream-light scroll-mt-[100px] md:scroll-mt-[100px]" id="produk">
        <div class="container mx-auto px-4">
            <SectionTitle :label="settings?.produk_label" :title="formatTitle(settings?.produk_title)"
                :icon="['fas', 'box']" label-variant="default" title-variant="default"
                margin-bottom="mb-8 md:mb-10 lg:mb-12" />

            <!-- Products Display - Carousel with Pagination -->
            <div class="flex flex-col items-center gap-6 md:gap-8 lg:gap-10">
                <!-- Carousel Container -->
                <div class="relative w-full max-w-7xl overflow-hidden">
                    <!-- Sliding Track -->
                    <div class="flex transition-transform duration-700 ease-in-out"
                        :style="{ transform: `translateX(-${currentPage * 100}%)` }">
                        <!-- Each Product -->
                        <div v-for="(product, index) in products" :key="product.id" class="w-full flex-shrink-0">
                            <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-12 lg:gap-14 items-start">
                                <template v-if="isLoading">
                                    <!-- Skeleton Main Image -->
                                    <div
                                        class="relative bg-gray-200 rounded-xl p-8 shadow-xl animate-pulse h-[400px] md:h-[500px] lg:h-[500px]">
                                        <div class="w-full h-full bg-gray-300 rounded-lg"></div>
                                    </div>
                                    <!-- Skeleton Info -->
                                    <div
                                        class="bg-gray-200 rounded-xl p-8 shadow-xl animate-pulse h-[400px] md:h-[500px] lg:h-[500px]">
                                        <div class="bg-gray-300 h-6 w-3/4 rounded mb-4"></div>
                                        <div class="bg-gray-300 h-4 w-full rounded mb-2"></div>
                                        <div class="bg-gray-300 h-4 w-5/6 rounded mb-2"></div>
                                        <div class="bg-gray-300 h-4 w-4/5 rounded"></div>
                                    </div>
                                </template>
                                <template v-else>
                                    <!-- Main Image - Fixed Height -->
                                    <div class="relative bg-primary rounded-xl p-6 md:p-8 shadow-xl group cursor-pointer h-[400px] md:h-[500px] lg:h-[500px]"
                                        @click="openModal(product)">
                                        <div class="relative w-full h-full overflow-hidden rounded-lg">
                                            <picture>
                                                <source
                                                    :srcset="getImageUrlForFormat(getProductMainImage(product), 'webp')"
                                                    type="image/webp" />
                                                <source :srcset="getProductMainImage(product)" type="image/jpeg" />
                                                <img v-lazy="getProductMainImage(product)" :alt="product.name"
                                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                    @error="handleImageError" />
                                            </picture>

                                            <!-- Overlay "Lihat Detail" -->
                                            <div
                                                class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center rounded-lg">
                                                <div
                                                    class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white text-primary px-6 py-3 rounded-full text-base font-semibold flex items-center gap-2">
                                                    <span>Lihat Detail</span>
                                                    <i class="fa-solid fa-arrow-right w-5 h-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Info Card - Fixed Height -->
                                    <div
                                        class="bg-primary rounded-xl overflow-hidden shadow-xl sticky top-5 h-[400px] md:h-[500px] lg:h-[500px]">
                                        <div class="p-6 md:p-7 bg-primary h-full flex flex-col">
                                            <!-- Product Name - Fixed Height -->
                                            <div class="mb-2 pb-2 border-b border-white/10 min-h-[60px]">
                                                <h3
                                                    class="text-xl md:text-2xl font-epilogue font-bold text-white uppercase tracking-wide line-clamp-2">
                                                    {{ product.name }}
                                                </h3>
                                            </div>

                                            <!-- Description - Responsive with Scroll -->
                                            <div class="mb-6 flex-1 min-h-0">
                                                <div
                                                    class="h-full overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent">
                                                    <p class="text-white/90 text-base leading-relaxed">
                                                        {{ product.description }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Price - Responsive -->
                                            <div class="mb-6 p-4 bg-white/10 rounded-lg">
                                                <div
                                                    class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-white/70 mb-2">
                                                    <i class="fa-solid fa-tag w-4 h-4"></i>
                                                    <span>HARGA</span>
                                                </div>
                                                <div class="text-2xl md:text-3xl font-epilogue font-bold text-white">
                                                    {{ formatPrice(product.price) }}
                                                </div>
                                            </div>

                                            <!-- Button - Fixed at Bottom -->
                                            <div class="pt-6 border-t border-white/10">
                                                <BadgeButton :href="getWhatsappUrl(product.name)" target="_blank"
                                                    variant="inverted" class="w-full">
                                                    <span>Hubungi Kami</span>
                                                    <i class="fa-solid fa-arrow-right w-5 h-5"></i>
                                                </BadgeButton>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Controls -->
                <Pagination v-if="!isLoading && products && products.length > 0" :current-page="currentPage"
                    :total-pages="products.length" variant="inverted" @prev="prevPage" @next="nextPage" @goto="goToPage" />
            </div>
        </div>

        <!-- Detail Modal -->
        <ImageGalleryModal :show="showModal" :images="selectedProduct ? getProductImageUrls(selectedProduct) : []"
            :title="selectedProduct?.name || ''" :description="selectedProduct?.description || ''"
            :badge="selectedProduct?.price !== undefined ? formatPrice(selectedProduct.price) : ''"
            @close="closeModal" />
    </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useLandingPageData, useImageUrl, useFormatting, useWhatsApp, useImageHandling } from '@/composables'
import type { Product } from '@/types/models'
import SectionTitle from './SectionTitle.vue'
import BadgeButton from './BadgeButton.vue'
import Pagination from './Pagination.vue'
import ImageGalleryModal from './ImageGalleryModal.vue'

const { data: landingPageData, isLoading } = useLandingPageData()
const { getImageUrl, getImageUrlForFormat } = useImageUrl()
const { formatPrice, formatTitle } = useFormatting()
const { createWhatsAppUrl } = useWhatsApp()
const { handleImageError } = useImageHandling()

const products = computed(() => landingPageData.value?.products || [])
const settings = computed(() => landingPageData.value?.siteSettings || null)
const contactInfo = computed(() => landingPageData.value?.contact || null)

const currentPage = ref(0)

// Modal state
const showModal = ref(false)
const selectedProduct = ref<Product | null>(null)

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
    }
}

const getProductImageUrls = (product: Product): string[] => {
    const urls: string[] = []
    if (product.image_urls && product.image_urls.length > 0) {
        urls.push(...product.image_urls)
    }
    if (product.image_url) {
        urls.push(product.image_url)
    }
    return urls.length > 0 ? urls : ['https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image']
}

const getProductMainImage = (product: Product): string => {
    if (product.image_url) return product.image_url
    if (product.image_urls && product.image_urls.length > 0) return product.image_urls[0]
    return 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'
}

const openModal = (item: Product) => {
    selectedProduct.value = item
    showModal.value = true
    document.body.style.overflow = 'hidden'
}

const closeModal = () => {
    showModal.value = false
    selectedProduct.value = null
    document.body.style.overflow = ''
}

const getWhatsappUrl = (productName: string): string => {
    if (contactInfo.value?.phone) {
        const phoneNumber = contactInfo.value.phone.replace(/[^\d+]/g, '')
        let formattedNumber = phoneNumber
        if (phoneNumber.startsWith('0')) {
            formattedNumber = '62' + phoneNumber.substring(1)
        } else if (phoneNumber.startsWith('8')) {
            formattedNumber = '62' + phoneNumber
        }
        const message = encodeURIComponent(`Halo, saya ingin bertanya tentang produk ${productName}`)
        return `https://wa.me/${formattedNumber}?text=${message}`
    }
    return '#'
}
</script>

<style scoped>
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-thin {
    scrollbar-width: thin;
}

.scrollbar-thin::-webkit-scrollbar {
    width: 6px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background-color: rgba(255, 255, 255, 0.3);
}
</style>
