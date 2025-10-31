<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-cream-light overflow-hidden" id="produk">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <div class="inline-block mb-6">
          <span
            class="bg-primary text-white px-6 py-3 text-xs font-semibold uppercase tracking-widest rounded-md"
          >
            {{ settings?.produk_label || 'PRODUK KAMI' }}
          </span>
        </div>
        <h2
          class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-epilogue font-bold text-secondary leading-tight uppercase tracking-wide mb-10"
          v-html="formatTitle(settings?.produk_title || 'OUR MACHINE PRODUCTS SPECIFICATIONS.')"
        >
        </h2>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="flex flex-col items-center justify-center py-20 text-center">
        <div
          class="w-12 h-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin mb-4"
        ></div>
        <p class="text-secondary text-base">Loading products...</p>
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
      <div v-else-if="!products || products.length === 0" class="flex flex-col items-center justify-center py-20 text-center">
        <div class="mb-4">
          <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
        </div>
        <p class="text-gray-600 text-base">No products available yet</p>
      </div>

      <!-- Products Slider -->
      <div v-else>
        <!-- Product Tabs -->
        <div class="flex justify-center gap-0 mb-16 flex-wrap">
          <button
            v-for="(product, index) in products"
            :key="product.id"
            @click="setActiveProduct(index)"
            class="bg-white text-secondary border border-secondary/20 px-6 py-4 text-sm font-semibold uppercase tracking-wide cursor-pointer transition-all duration-300 rounded-none first:rounded-l-md last:rounded-r-md not-last:border-r-0"
            :class="{ 'bg-primary text-primary border-primary': activeProduct === index }"
          >
            {{ product.name }}
          </button>
        </div>

        <!-- Product Display -->
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_350px] gap-16 items-start">
          <!-- Main Image -->
          <div class="relative bg-white rounded-xl p-8 shadow-xl">
            <div class="relative w-full h-[500px] overflow-hidden rounded-lg">
              <img
                :src="getProductImageUrls(products[activeProduct])[activeProductImage]"
                :alt="products[activeProduct]?.name"
                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                @error="handleImageError"
              />
            </div>

            <!-- Product Image Slider -->
            <div v-if="getProductImageUrls(products[activeProduct]).length > 1" class="mt-4 flex flex-wrap gap-2 justify-center">
              <button
                v-for="(img, index) in getProductImageUrls(products[activeProduct])"
                :key="index"
                @click="setActiveProductImage(index)"
                class="w-16 h-16 rounded-lg overflow-hidden border-2 transition-all duration-300 hover:scale-110"
                :class="activeProductImage === index ? 'border-primary ring-2 ring-primary' : 'border-gray-300 hover:border-gray-400'"
              >
                <img :src="img" :alt="`Thumbnail ${index + 1}`" class="w-full h-full object-cover" />
              </button>
            </div>
          </div>

          <!-- Product Info Card -->
          <div class="bg-primary rounded-xl overflow-hidden shadow-xl sticky top-5">
            <div class="h-48 overflow-hidden">
              <img
                :src="getProductImageUrls(products[activeProduct])[activeProductImage]"
                :alt="products[activeProduct]?.name"
                class="w-full h-full object-cover"
                @error="handleImageError"
              />
            </div>

            <div class="p-8 bg-primary">
              <div class="mb-6 pb-4 border-b border-white/10">
                <h3 class="text-xl font-epilogue font-bold text-white uppercase tracking-wide">
                  {{ products[activeProduct]?.name }}
                </h3>
              </div>

              <div class="mb-6">
                <p class="text-white/90 text-sm leading-relaxed">
                  {{ products[activeProduct]?.description }}
                </p>
              </div>

              <div class="mb-8 p-4 bg-white/10 rounded-lg">
                <div class="text-xs font-semibold uppercase tracking-wide text-white/70 mb-2">
                  HARGA
                </div>
                <div class="text-3xl font-epilogue font-bold text-white">
                  {{ formatPrice(products[activeProduct]?.price) }}
                </div>
              </div>

              <div class="pt-6 border-t border-white/10">
                <button
                  class="w-full bg-white text-primary px-6 py-4 text-sm font-semibold uppercase tracking-wide rounded-lg flex items-center justify-center gap-2"
                >
                  <span>Hubungi Kami</span>
                  <i-lucide:arrow-right class="w-4 h-4" />
                </button>
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
import api, { type Product } from '@/services/api'
import { useSiteSettings } from '@/composables/useSiteSettings'

const { settings, fetchSettings } = useSiteSettings()
const products = ref<Product[]>([])
const isLoading = ref(true)
const error = ref<string | null>(null)
const activeProduct = ref(0)

// New reactive variables for product image slider
const activeProductImage = ref(0)

// Computed property to get all image URLs for the active product
const getProductImageUrls = (product: Product | undefined) => {
  if (!product) return [getImageUrl(undefined)]

  // Start with the main image
  const urls: string[] = []

  // Add the main image if it exists
  if (product.image_path) {
    urls.push(getImageUrl(product.image_path))
  }

  // Add additional images if they exist
  if (product.image_urls && product.image_urls.length > 0) {
    urls.push(...product.image_urls)
  }

  // If no images exist, return a placeholder
  if (urls.length === 0) {
    return [getImageUrl(undefined)]
  }

  return urls
}

const setActiveProductImage = (index: number) => {
  activeProductImage.value = index
}

const formatTitle = (title: string) => {
  // Simple formatting: wrap words in <span> for styling
  // This is a basic implementation - adjust as needed
  return title.replace(/\n/g, '<br />')
}

const fetchProducts = async () => {
  try {
    isLoading.value = true
    error.value = null
    const data = await api.getProducts()
    products.value = data
  } catch (err) {
    console.error('Error fetching products:', err)
    error.value = 'Failed to load products'
    products.value = []
  } finally {
    isLoading.value = false
  }
}

const retryFetch = () => {
  fetchProducts()
}

const setActiveProduct = (index: number) => {
  activeProduct.value = index
  // Reset the active image when changing products
  activeProductImage.value = 0
}

const getImageUrl = (imagePath: string | undefined): string => {
  if (!imagePath) {
    return 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'
  }
  // If it's already a full URL, return it
  if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
    return imagePath
  }
  // Otherwise, construct URL from storage path
  return `${import.meta.env.VITE_API_BASE_URL?.replace('/api', '') || 'http://127.0.0.1:8000'}/storage/${imagePath}`
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

onMounted(async () => {
  await fetchSettings()
  fetchProducts()
})
</script>
