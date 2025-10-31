<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section
    class="relative w-full min-h-screen flex flex-col justify-between overflow-hidden"
    id="home"
  >
    <!-- Loading State -->
    <div v-if="isLoading" class="flex-1 flex items-center justify-center bg-secondary">
      <div class="text-center">
        <div
          class="w-16 h-16 border-4 border-primary/30 border-t-primary rounded-full animate-spin mb-4 mx-auto"
        ></div>
        <p class="text-white text-base">Loading...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="flex-1 flex items-center justify-center bg-secondary">
      <div class="text-center px-4">
        <div class="mb-6">
          <svg
            class="w-20 h-20 text-primary mx-auto"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
        </div>
        <h2 class="text-3xl font-bold text-white mb-4">{{ error }}</h2>
        <p class="text-white/70 mb-6">Please configure the hero section in the admin panel</p>
        <button
          @click="retryFetch"
          class="bg-primary text-white px-8 py-4 text-sm font-semibold rounded-lg transition-all duration-300 hover:bg-primary/90"
        >
          Retry
        </button>
      </div>
    </div>

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
          :style="{ backgroundImage: `url(${bg})` }"
        ></div>
      </div>
      <div class="absolute inset-0 bg-gradient-to-b from-secondary/60 to-secondary/80 z-10"></div>

      <div class="container mx-auto px-4 relative z-20">
        <div class="flex items-center justify-start min-h-[60vh]">
          <div class="max-w-[700px] text-white text-left">
            <div class="mb-6 animate-fade-in">
              <span
                class="text-white font-semibold text-sm py-2.5 px-6 bg-cream/20 backdrop-blur-md rounded-full inline-flex items-center gap-2 border border-cream/30 animate-slide-in-left"
              >
                <i-lucide:map-pin class="flex-shrink-0 text-primary w-3.5 h-3.5 !text-white" />
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
              <a
                href="#kontak"
                class="inline-flex items-center bg-primary text-white px-12 py-5 text-base font-semibold uppercase transition-all duration-300 no-underline tracking-wide rounded-lg shadow-soft hover:bg-primary-dark hover:-translate-y-0.5 hover:shadow-lg gap-3"
              >
                <span>Hubungi Kami</span>
                <i-lucide:arrow-up-right class="w-5 h-5 !text-white" />
              </a>
            </div>
          </div>
        </div>
      </div>

      <div
        class="absolute right-[5%] top-[30%] z-5 font-epilogue font-black opacity-[0.08] pointer-events-none flex flex-col items-end leading-none"
      >
        <span
          class="text-6xl md:text-7xl lg:text-8xl xl:text-9xl text-white font-black leading-none"
          >SU</span
        >
        <span
          class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl text-white font-black leading-none"
          >RYA</span
        >
        <span
          class="text-6xl md:text-7xl lg:text-8xl xl:text-9xl text-white font-black leading-none"
          >KEN</span
        >
        <span
          class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl text-white font-black leading-none"
          >CANA</span
        >
      </div>
    </div>

    <div class="relative z-20 bg-primary/95 backdrop-blur-md border-t border-cream/20">
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
            <!-- Replaced component with inline SVG for white color -->
            <svg
              v-if="stat.icon === 'settings'"
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <svg
              v-else-if="stat.icon === 'building'"
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
              />
            </svg>
            <svg
              v-else-if="stat.icon === 'users'"
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
              />
            </svg>
            <svg
              v-else-if="stat.icon === 'calendar'"
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            <svg
              v-else-if="stat.icon === 'shield-check'"
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
              />
            </svg>
          </div>
          <div
            class="text-4xl font-epilogue font-extrabold text-white mb-2 transition-all duration-300 hover:scale-110 hover:text-cream leading-tight"
          >
            {{ stat.value }}
          </div>
          <div class="text-xs font-semibold uppercase text-white tracking-wider">
            {{ stat.label }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import api from '@/services/api'

// Removed icon imports as we are using inline SVGs now

interface HeroData {
  background: string
  backgrounds: string[]
  location: string
  title: string
  machines: number
  clients: number
  customers: number
  experienceYears: number
  trustYears: number
}

const heroData = ref<HeroData | null>(null)
const isLoading = ref(true)
const error = ref<string | null>(null)
const currentBackgroundIndex = ref(0)
let sliderInterval: ReturnType<typeof setInterval> | null = null

const loadHeroData = async () => {
  try {
    isLoading.value = true
    error.value = null
    const data = await api.getHero()
    if (data && data.length > 0) {
      const hero = data[0]!
      heroData.value = {
        background: hero.background_url || '',
        backgrounds:
          hero.background_urls && hero.background_urls.length > 0
            ? hero.background_urls
            : hero.background_url
              ? [hero.background_url]
              : [],
        location: hero.location || '',
        title: hero.title || '',
        machines: hero.machines || 0,
        clients: hero.clients || 0,
        customers: hero.customers || 0,
        experienceYears: hero.experience_years || 0,
        trustYears: hero.trust_years || 0,
      }
      
      if (heroData.value.backgrounds.length > 1) {
        startBackgroundSlider()
      }
    } else {
      error.value = 'Hero section not configured'
    }
  } catch (err) {
    console.error('Error loading hero data:', err)
    error.value = 'Failed to load hero section'
  } finally {
    isLoading.value = false
  }
}

const startBackgroundSlider = () => {
  if (sliderInterval) {
    clearInterval(sliderInterval)
  }

  sliderInterval = setInterval(() => {
    if (heroData.value && heroData.value.backgrounds.length > 1) {
      currentBackgroundIndex.value =
        (currentBackgroundIndex.value + 1) % heroData.value.backgrounds.length
    }
  }, 5000) // Change background every 5 seconds
}

const retryFetch = () => {
  loadHeroData()
}

const stats = computed(() => {
  if (!heroData.value) return []
  return [
    {
      icon: 'settings',
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
      icon: 'calendar',
      value: heroData.value.experienceYears,
      label: 'TAHUN PENGALAMAN',
    },
    {
      icon: 'shield-check',
      value: heroData.value.trustYears,
      label: 'TERPERCAYA',
    },
  ]
})

onMounted(() => {
  loadHeroData()
})

onUnmounted(() => {
  if (sliderInterval) {
    clearInterval(sliderInterval)
  }
})
</script>
