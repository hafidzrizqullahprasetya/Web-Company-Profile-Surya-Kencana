<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-primary overflow-hidden" id="testimoni">
    <div class="container mx-auto px-4">
      <div class="text-center mb-20">
        <div class="inline-block mb-6">
          <span
            class="bg-white text-secondary px-6 py-3 text-xs font-semibold uppercase tracking-widest"
          >
            TESTIMONIAL
          </span>
        </div>
        <h2
          class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-epilogue font-bold text-white leading-tight uppercase tracking-wide mb-10"
        >
          PENGALAMAN
          <span class="text-white relative"
            >PELANGGAN
            <div class="absolute -bottom-1 left-0 w-full h-3 bg-primary -z-10"></div></span
          ><br />
          KAMI.
        </h2>
      </div>

      <div v-if="isLoading" class="flex flex-col items-center justify-center py-16 text-center">
        <div
          class="w-10 h-10 border-4 border-primary/30 border-t-primary rounded-full animate-spin mb-4"
        ></div>
        <p class="text-white text-base">Loading testimonials...</p>
      </div>

      <div v-else-if="error" class="flex flex-col items-center justify-center py-16 text-center">
        <p class="text-red-500 text-base mb-4 font-medium">{{ error }}</p>
        <button
          @click="retryFetch"
          class="bg-primary text-secondary px-6 py-3 text-sm font-semibold rounded-md transition-all duration-300 hover:bg-primary-dark hover:-translate-y-0.5"
        >
          Coba Lagi
        </button>
      </div>

      <div v-else-if="testimonials.length > 0" class="flex flex-col items-center gap-8">
        <!-- Testimonial Cards Container (Horizontal Slider) -->
        <div class="relative w-full max-w-6xl overflow-hidden">
          <div
            class="flex gap-8 transition-transform duration-500 ease-in-out"
            :style="{
              transform: `translateX(-${startIndex * (100 / visibleCount)}%)`,
              width: `${(testimonials.length / visibleCount) * 100}%`,
            }"
          >
            <div
              v-for="testimonial in testimonials"
              :key="testimonial.id"
              class="bg-white text-secondary p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl flex-shrink-0"
              :style="{ width: `${100 / testimonials.length}%` }"
            >
              <div class="flex flex-col gap-4">
                <div class="relative">
                  <p class="text-secondary/90 text-base leading-relaxed italic pl-5">
                    "{{ testimonial.feedback }}"
                  </p>
                  <div
                    class="absolute top-0 left-0 text-4xl text-primary/30 font-serif leading-none"
                  >
                    "
                  </div>
                </div>

                <div class="flex gap-1">
                  <i-lucide:star
                    v-for="star in 5"
                    :key="star"
                    class="w-4 h-4 text-yellow-400 fill-current"
                  />
                </div>
              </div>

              <div class="flex items-center gap-4 mt-6">
                <div class="flex-shrink-0">
                  <img
                    :src="`https://ui-avatars.com/api/?name=${testimonial.client_name}&background=F5F6E4&color=1C1817&size=70`"
                    :alt="testimonial.client_name"
                    class="w-14 h-14 rounded-full object-cover border-2 border-primary/50"
                    @error="onImageError"
                  />
                </div>
                <div class="flex flex-col gap-1">
                  <h4 class="text-secondary font-bold text-base">{{ testimonial.client_name }}</h4>
                  <p class="text-secondary/70 text-sm">{{ testimonial.institution }}</p>
                  <p class="text-secondary/50 text-xs">{{ formatDate(testimonial.date) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Navigation Buttons (< >) -->
        <div class="flex items-center gap-4">
          <button
            @click="prevTestimonials"
            :disabled="startIndex === 0"
            class="px-4 py-2 bg-white text-secondary rounded-lg hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            <i-lucide:chevron-left class="w-5 h-5" />
          </button>
          <span class="text-white text-sm">
            {{ startIndex + 1 }} - {{ Math.min(startIndex + visibleCount, testimonials.length) }} of
            {{ testimonials.length }}
          </span>
          <button
            @click="nextTestimonials"
            :disabled="startIndex + visibleCount >= testimonials.length"
            class="px-4 py-2 bg-white text-secondary rounded-lg hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            <i-lucide:chevron-right class="w-5 h-5" />
          </button>
        </div>
      </div>

      <div v-else class="text-center py-20">
        <p class="text-white text-lg">Belum ada testimonial terdaftar.</p>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api, { type Testimonial } from '@/services/api'

const testimonials = ref<Testimonial[]>([])
const isLoading = ref(true)
const error = ref<string | null>(null)
const startIndex = ref(0)
const visibleCount = 3 // Show 3 cards

const prevTestimonials = () => {
  if (startIndex.value > 0) {
    startIndex.value -= 1 // Geser 1 card ke kiri
  }
}

const nextTestimonials = () => {
  if (startIndex.value + visibleCount < testimonials.value.length) {
    startIndex.value += 1 // Geser 1 card ke kanan
  }
}

const fetchTestimonials = async () => {
  try {
    isLoading.value = true
    error.value = null
    const response = await api.getTestimonials()
    testimonials.value = response
    console.log('Testimonials data:', testimonials.value)
  } catch (err) {
    console.error('Error fetching testimonials:', err)
    const message =
      (err as { response?: { data?: { message?: string } } })?.response?.data?.message ||
      'Gagal memuat data testimonial'
    error.value = message
  } finally {
    isLoading.value = false
  }
}

const retryFetch = () => {
  fetchTestimonials()
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
    'https://ui-avatars.com/api/?name=Testimoni+Guest&background=F5F6E4&color=1C1817&size=70'
}

onMounted(() => {
  fetchTestimonials()
})
</script>
