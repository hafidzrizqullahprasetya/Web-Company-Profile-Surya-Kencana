<template>
  <section class="pt-24 pb-32 bg-white" id="clients">
    <div class="container mx-auto px-4">
      <SectionTitle
        :label="siteSettings?.clients_label"
        :title="siteSettings?.clients_title"
        :icon="['fas', 'handshake']"
        label-variant="default"
        title-variant="default"
        margin-bottom="mb-16"
      />

      <!-- Grid Layout with Pagination -->
      <div class="flex flex-col items-center gap-12">
        <div class="max-w-7xl mx-auto w-full">
          <template v-if="isLoading || !clients || clients.length === 0">
            <!-- Skeleton placeholders -->
            <div class="flex flex-wrap justify-center gap-8">
              <div
                v-for="n in 4"
                :key="'skeleton-' + n"
                class="flex flex-col items-center justify-center p-8 bg-white rounded-xl border-2 border-gray-200 shadow-sm w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(25%-1.5rem)] max-w-sm"
              >
                <div class="bg-gray-200 rounded-xl h-40 w-full mb-6 animate-pulse"></div>
                <div class="bg-gray-200 h-6 w-3/4 rounded animate-pulse"></div>
              </div>
            </div>
          </template>
          <template v-else>
            <!-- Sliding Container -->
            <div class="relative w-full overflow-hidden">
              <div
                class="flex transition-transform duration-700 ease-in-out"
                :style="{ transform: `translateX(-${currentPage * 100}%)` }"
              >
                <!-- Each Page -->
                <div
                  v-for="(page, pageIndex) in paginatedClients"
                  :key="`page-${pageIndex}`"
                  class="w-full flex-shrink-0"
                >
                  <div class="flex flex-wrap justify-center gap-8 px-4">
                    <div
                      v-for="client in page"
                      :key="client.id"
                      class="flex flex-col items-center justify-center p-8 bg-white rounded-xl border-2 border-gray-200 shadow-sm hover:shadow-xl hover:border-primary transition-all duration-300 w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(25%-1.5rem)] max-w-sm"
                    >
                      <picture class="w-full h-40 flex items-center justify-center mb-6">
                        <source :srcset="getClientImageUrl(client, 'webp')" type="image/webp" />
                        <source :srcset="getLogoUrl(client)" type="image/png" />
                        <img
                          v-lazy="getLogoUrl(client)"
                          :alt="client.client_name"
                          class="max-h-40 max-w-full object-contain transition-transform duration-300 hover:scale-110"
                          @error="handleImageError"
                        />
                      </picture>
                      <span class="text-xl font-bold text-primary text-center leading-tight">
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
        <div v-if="!isLoading && clients && clients.length > 0" class="mt-8 mb-4">
          <Pagination
            :current-page="currentPage"
            :total-pages="totalPages"
            variant="inverted"
            @prev="prevPage"
            @next="nextPage"
            @goto="goToPage"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import type { OurClient } from '@/services/api'
import SectionTitle from './SectionTitle.vue'
import Pagination from './Pagination.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const clients = computed(() => landingPageData.value?.clients || [])
const siteSettings = computed(() => landingPageData.value?.siteSettings || null)

const currentPage = ref(0)
const itemsPerPage = 4

// Calculate total pages
const totalPages = computed(() => {
  return Math.ceil(clients.value.length / itemsPerPage)
})

// Paginate clients into pages (for sliding animation)
const paginatedClients = computed(() => {
  const pages = []
  for (let i = 0; i < totalPages.value; i++) {
    const start = i * itemsPerPage
    const end = start + itemsPerPage
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
    return `${import.meta.env.VITE_API_BASE_URL?.replace('/api', '') || 'http://127.0.0.1:8000'}/storage/${client.logo_path}`
  }
  return 'https://placehold.co/300x200/e5e7eb/6b7280?text=No+Logo'
}

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement
  target.src = 'https://placehold.co/300x200/e5e7eb/6b7280?text=No+Logo'
}
</script>
