<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section
    class="relative w-full min-h-screen flex flex-col justify-between overflow-hidden pt-24"
    id="home"
  >
    <!-- Skeleton Loading State -->
    <template v-if="isLoading || !heroData">
      <div class="flex-1 flex items-center justify-start relative z-10">
        <!-- Background Skeleton -->
        <div class="absolute inset-0 w-full h-full bg-gray-300 animate-pulse"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-secondary/35 to-secondary/50 z-10"></div>

        <div class="container mx-auto px-4 relative z-20">
          <div class="flex items-center justify-start min-h-[60vh]">
            <div class="max-w-[700px] text-white text-left space-y-6">
              <!-- Location Badge Skeleton -->
              <div class="mb-6">
                <div
                  class="h-10 w-48 bg-white/20 backdrop-blur-md rounded-full animate-pulse"
                ></div>
              </div>

              <!-- Title Skeleton -->
              <div class="my-6 space-y-4">
                <div class="h-16 w-full bg-white/20 rounded-lg animate-pulse"></div>
                <div class="h-16 w-5/6 bg-white/20 rounded-lg animate-pulse"></div>
              </div>

              <!-- Button Skeleton -->
              <div class="h-14 w-56 bg-white/20 rounded-full animate-pulse"></div>
            </div>
          </div>
        </div>

        <!-- Watermark Text Skeleton -->
        <div
          class="absolute right-[5%] top-[30%] z-5 font-epilogue font-black opacity-[0.05] pointer-events-none flex flex-col items-end leading-none"
        >
          <div class="h-24 w-32 bg-white/20 rounded animate-pulse mb-2"></div>
          <div class="h-20 w-40 bg-white/20 rounded animate-pulse mb-2"></div>
          <div class="h-24 w-36 bg-white/20 rounded animate-pulse mb-2"></div>
          <div class="h-20 w-44 bg-white/20 rounded animate-pulse"></div>
        </div>
      </div>

      <!-- Stats Skeleton -->
      <div class="relative z-20 bg-primary/95 backdrop-blur-md border-t border-cream/20">
        <div
          class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 max-w-[1400px] mx-auto px-5 py-8"
        >
          <div v-for="n in 5" :key="'stat-skeleton-' + n" class="text-center flex-1 relative">
            <!-- Icon Skeleton -->
            <div
              class="flex items-center justify-center w-20 h-20 bg-cream/10 rounded-full mx-auto mb-4 border-2 border-cream/20 animate-pulse"
            ></div>
            <!-- Value Skeleton -->
            <div class="h-8 w-16 bg-white/20 rounded mx-auto mb-2 animate-pulse"></div>
            <!-- Label Skeleton -->
            <div class="h-4 w-24 bg-white/20 rounded mx-auto animate-pulse"></div>
          </div>
        </div>
      </div>
    </template>

    <!-- Hero Content -->
    <div v-else-if="heroData" class="flex-1 flex items-center justify-start relative z-10">
      <!-- Background Slider -->
      <div class="absolute inset-0 w-full h-full overflow-hidden">
        <div
          v-for="(bg, index) in heroData.backgrounds"
          :key="index"
          class="absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-1000"
          :class="{
            'opacity-100': currentBackgroundIndex === index,
            'opacity-0': currentBackgroundIndex !== index,
          }"
        >
          <picture class="absolute inset-0 w-full h-full">
            <source :srcset="getImageUrlForFormat(bg, 'webp')" type="image/webp" />
            <source :srcset="bg" type="image/jpeg" />
            <img
              v-lazy="bg"
              class="w-full h-full object-cover"
              :alt="heroData.title || 'Hero Background'"
            />
          </picture>
        </div>
      </div>
      <div class="absolute inset-0 bg-gradient-to-b from-secondary/35 to-secondary/50 z-10"></div>

      <div class="container mx-auto px-4 relative z-20">
        <div class="flex items-center justify-start min-h-[60vh]">
          <div class="max-w-[700px] text-white text-left">
            <div class="mb-6 animate-fade-in">
              <span
                class="text-white font-semibold text-sm py-2.5 px-6 bg-cream/20 backdrop-blur-md rounded-full inline-flex items-center gap-2 border border-cream/30 animate-slide-in-left"
              >
                <i class="fa-solid fa-map-marker-alt flex-shrink-0 text-white w-3.5 h-3.5"></i>
                {{ heroData.location }}
              </span>
            </div>

            <div class="my-6 animate-fade-in animation-delay-200">
              <h1
                class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-epilogue font-extrabold uppercase text-white leading-tight mb-6 tracking-wider drop-shadow-lg text-left"
              >
                {{ heroData.title }}
              </h1>
            </div>

            <div class="animate-fade-in animation-delay-400">
              <BadgeButton :href="whatsappUrl" target="_blank">
                <span>Hubungi Kami</span>
                <i class="fa-solid fa-external-link-alt w-5 h-5"></i>
              </BadgeButton>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative z-20 bg-primary backdrop-blur-md border-t border-cream/20">
      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 max-w-[1400px] mx-auto px-5 py-8"
      >
        <div
          v-for="(stat, idx) in stats"
          :key="idx"
          class="text-center flex-1 relative transition-transform duration-300 hover:-translate-y-1.25"
        >
          <div
            class="flex items-center justify-center w-20 h-20 bg-cream/10 rounded-full mx-auto mb-4 text-white transition-all duration-300 border-2 border-cream/20 hover:bg-cream/20 hover:scale-110 hover:text-cream"
          >
            <i :class="['fa-solid', 'fa-' + stat.icon, 'w-8 h-8 text-3xl']"></i>
          </div>
          <div
            class="text-4xl font-epilogue font-extrabold text-white mb-2 transition-all duration-300 hover:scale-110 hover:text-cream leading-tight"
          >
            {{ stat.value }}
          </div>
          <div class="text-sm md:text-base font-bold uppercase text-white tracking-wider">
            {{ stat.label }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import BadgeButton from './BadgeButton.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const currentBackgroundIndex = ref(0)
let sliderInterval: ReturnType<typeof setInterval> | null = null

const heroData = computed(() => {
  if (!landingPageData.value?.hero) return null

  const hero = landingPageData.value.hero
  return {
    background: hero.background_url || '',
    backgrounds:
      hero.background_urls && hero.background_urls.length > 0
        ? hero.background_urls
        : hero.background_url
          ? [hero.background_url]
          : [],
    location: hero.location,
    title: hero.title,
    machines: hero.machines,
    clients: hero.clients,
    customers: hero.customers,
    experienceYears: hero.experience_years,
    trustYears: hero.trust_years,
  }
})

const contactInfo = computed(() => {
  return landingPageData.value?.contact || null
})

const whatsappUrl = computed(() => {
  if (contactInfo.value?.phone) {
    const phoneNumber = contactInfo.value.phone.replace(/[^\d+]/g, '')
    let formattedNumber = phoneNumber
    if (phoneNumber.startsWith('0')) {
      formattedNumber = '62' + phoneNumber.substring(1)
    } else if (phoneNumber.startsWith('8')) {
      formattedNumber = '62' + phoneNumber
    }

    const message = encodeURIComponent(
      'Halo, saya ingin bertanya tentang produk/mesin yang tersedia.',
    )
    return `https://wa.me/${formattedNumber}?text=${message}`
  }
  return '#'
})

const startBackgroundSlider = () => {
  if (sliderInterval) {
    clearInterval(sliderInterval)
  }

  sliderInterval = setInterval(() => {
    if (heroData.value && heroData.value.backgrounds.length > 1) {
      currentBackgroundIndex.value =
        (currentBackgroundIndex.value + 1) % heroData.value.backgrounds.length
    }
  }, 5000)
}

const stats = computed(() => {
  if (!heroData.value) return []
  return [
    {
      icon: 'cog',
      value: heroData.value.machines,
      label: 'MESIN DIPRODUKSI',
    },
    {
      icon: 'building',
      value: heroData.value.clients,
      label: 'KLIEN',
    },
    {
      icon: 'users',
      value: heroData.value.customers,
      label: 'PELANGGAN',
    },
    {
      icon: 'clock',
      value: heroData.value.experienceYears,
      label: 'TAHUN PENGALAMAN',
    },
    {
      icon: 'shield-alt',
      value: heroData.value.trustYears,
      label: 'TERPERCAYA',
    },
  ]
})

onMounted(() => {
  if (heroData.value && heroData.value.backgrounds.length > 1) {
    startBackgroundSlider()
  }
})

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

onUnmounted(() => {
  if (sliderInterval) {
    clearInterval(sliderInterval)
  }
})
</script>
