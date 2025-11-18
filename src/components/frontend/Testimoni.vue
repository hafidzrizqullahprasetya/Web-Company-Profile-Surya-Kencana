<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-primary overflow-hidden" id="testimoni">
    <div class="container mx-auto px-4">
      <SectionTitle
        :label="siteSettings?.testimoni_label"
        :title="siteSettings?.testimoni_title"
        :icon="['fas', 'comment-dots']"
        label-variant="inverted"
        title-variant="white"
      />

      <template v-if="isLoading || testimonials.length === 0">
        <!-- Skeleton cards -->
        <div class="flex flex-col items-center gap-12">
          <!-- Testimonial Cards Grid (3 per page) -->
          <div class="relative w-full max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <div
                v-for="n in 3"
                :key="'skeleton-' + n"
                class="bg-white rounded-2xl shadow-2xl overflow-hidden"
              >
                <!-- Card Header -->
                <div class="bg-gradient-to-br from-cream to-cream-light p-6 relative">
                  <div
                    class="absolute top-4 right-4 text-6xl text-primary/20 font-serif leading-none animate-pulse"
                  >
                    "
                  </div>
                  <div class="flex gap-1 mb-3">
                    <div class="w-5 h-5 bg-gray-200 rounded-full animate-pulse"></div>
                    <div class="w-5 h-5 bg-gray-200 rounded-full animate-pulse"></div>
                    <div class="w-5 h-5 bg-gray-200 rounded-full animate-pulse"></div>
                    <div class="w-5 h-5 bg-gray-200 rounded-full animate-pulse"></div>
                    <div class="w-5 h-5 bg-gray-200 rounded-full animate-pulse"></div>
                  </div>
                </div>

                <!-- Card Body -->
                <div class="p-6 pb-8">
                  <div class="text-secondary/90 text-base leading-relaxed mb-6 min-h-[96px]">
                    <div class="bg-gray-200 h-4 rounded animate-pulse mb-2"></div>
                    <div class="bg-gray-200 h-4 rounded animate-pulse mb-2 w-5/6"></div>
                    <div class="bg-gray-200 h-4 rounded animate-pulse mb-2 w-4/6"></div>
                    <div class="bg-gray-200 h-4 rounded animate-pulse w-3/6"></div>
                  </div>

                  <!-- Client Info -->
                  <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                    <div class="flex-shrink-0">
                      <div
                        class="w-16 h-16 rounded-full bg-gray-200 border-3 border-primary shadow-lg animate-pulse"
                      ></div>
                    </div>
                    <div class="flex flex-col gap-2">
                      <div class="bg-gray-200 h-4 w-32 rounded animate-pulse"></div>
                      <div class="bg-gray-200 h-3 w-24 rounded animate-pulse"></div>
                      <div class="bg-gray-200 h-3 w-16 rounded animate-pulse"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Skeleton Navigation Controls -->
          <div class="flex flex-col items-center gap-6">
            <!-- Page Dots -->
            <div class="flex items-center gap-3">
              <div
                v-for="n in 4"
                :key="'dot-skeleton-' + n"
                class="w-3 h-3 bg-white/40 rounded-full animate-pulse"
              ></div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex items-center gap-6">
              <div class="w-12 h-12 bg-white/40 rounded-full animate-pulse"></div>
              <div
                class="text-white text-sm font-semibold bg-white/10 px-6 py-2 rounded-full backdrop-blur-sm"
              >
                Page 1 of 1
              </div>
              <div class="w-12 h-12 bg-white/40 rounded-full animate-pulse"></div>
            </div>
          </div>
        </div>
      </template>
      <template v-else>
        <div class="flex flex-col items-center gap-12">
          <!-- Testimonial Cards with Sliding Animation -->
          <div class="relative w-full max-w-7xl overflow-hidden">
            <!-- Sliding Track -->
            <div
              class="flex transition-transform duration-700 ease-in-out"
              :style="{ transform: `translateX(-${currentPage * 100}%)` }"
            >
              <!-- Each Page is a Slide -->
              <div
                v-for="(page, pageIndex) in paginatedTestimonials"
                :key="`page-${pageIndex}`"
                class="w-full flex-shrink-0"
              >
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
                  <div
                    v-for="testimonial in page"
                    :key="testimonial.id"
                    class="bg-white rounded-2xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-[0_20px_60px_rgba(0,0,0,0.3)] group"
                  >
                    <!-- Card Header with Quote Icon -->
                    <div class="bg-gradient-to-br from-cream to-cream-light p-6 relative">
                      <div
                        class="absolute top-4 right-4 text-6xl text-primary font-serif leading-none"
                      >
                        "
                      </div>
                      <div class="flex gap-1 mb-3">
                        <font-awesome-icon
                          v-for="star in 5"
                          :key="star"
                          :icon="['fas', 'star']"
                          class="w-5 h-5 text-yellow-500 drop-shadow-sm"
                        />
                      </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 pb-8">
                      <p
                        class="text-secondary/90 text-xl leading-relaxed mb-6 line-clamp-4 min-h-[96px]"
                      >
                        "{{ testimonial.feedback }}"
                      </p>

                      <div
                        class="flex items-center gap-4 pt-4 border-t border-gray-100 bg-gradient-to-br from-cream to-cream-light p-4 rounded-lg -mx-2"
                      >
                        <div class="flex-shrink-0">
                          <img
                            :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(testimonial.client_name)}&background=5C4033&color=FFFFFF&size=80&bold=true`"
                            :alt="testimonial.client_name"
                            class="w-16 h-16 rounded-full object-cover border-3 border-primary shadow-lg transition-transform duration-300 group-hover:scale-110"
                            @error="onImageError"
                          />
                        </div>
                        <div class="flex flex-col gap-1">
                          <h4 class="text-primary font-bold text-xl">
                            {{ testimonial.client_name }}
                          </h4>
                          <p class="text-secondary font-semibold text-base">
                            {{ testimonial.institution }}
                          </p>
                          <p class="text-primary/60 text-sm">
                            {{ formatDate(testimonial.date) }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Navigation Controls -->
          <Pagination
            :current-page="currentPage"
            :total-pages="totalPages"
            @prev="prevPage"
            @next="nextPage"
            @goto="goToPage"
          />
        </div>
      </template>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import SectionTitle from './SectionTitle.vue'
import Pagination from './Pagination.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const testimonials = computed(() => landingPageData.value?.testimonials || [])
const siteSettings = computed(() => landingPageData.value?.siteSettings || null)

const currentPage = ref(0)
const cardsPerPage = 3

// Calculate total pages
const totalPages = computed(() => {
  return Math.ceil(testimonials.value.length / cardsPerPage)
})

// Paginate testimonials into pages (for sliding animation)
const paginatedTestimonials = computed(() => {
  const pages = []
  for (let i = 0; i < totalPages.value; i++) {
    const start = i * cardsPerPage
    const end = start + cardsPerPage
    pages.push(testimonials.value.slice(start, end))
  }
  return pages
})

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

const formatDate = (dateString: string): string => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

const onImageError = (e: Event) => {
  const target = e.target as HTMLImageElement
  target.src =
    'https://ui-avatars.com/api/?name=Testimoni+Guest&background=5C4033&color=FFFFFF&size=80&bold=true'
}
</script>
