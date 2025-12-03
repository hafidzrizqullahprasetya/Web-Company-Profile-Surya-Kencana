<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <section
        class="relative w-full min-h-[100vh] md:min-h-screen flex flex-col justify-between overflow-hidden pt-12 md:pt-16 scroll-mt-[100px] md:scroll-mt-[80px]"
        id="home">
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
                                    class="h-8 md:h-10 w-40 md:w-48 bg-white/20 backdrop-blur-md rounded-full animate-pulse">
                                </div>
                            </div>

                            <!-- Title Skeleton -->
                            <div class="my-6 space-y-3 md:space-y-4">
                                <div class="h-12 md:h-16 w-full bg-white/20 rounded-lg animate-pulse"></div>
                                <div class="h-12 md:h-16 w-5/6 bg-white/20 rounded-lg animate-pulse"></div>
                            </div>

                            <!-- Button Skeleton -->
                            <div class="h-12 md:h-14 w-48 md:w-56 bg-white/20 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>

                <!-- Watermark Text Skeleton -->
                <div
                    class="absolute right-[5%] top-[30%] z-5 font-epilogue font-black opacity-[0.05] pointer-events-none flex flex-col items-end leading-none">
                    <div class="h-16 md:h-24 w-24 md:w-32 bg-white/20 rounded animate-pulse mb-2"></div>
                    <div class="h-12 md:h-20 w-32 md:w-40 bg-white/20 rounded animate-pulse mb-2"></div>
                    <div class="h-16 md:h-24 w-28 md:w-36 bg-white/20 rounded animate-pulse mb-2"></div>
                    <div class="h-12 md:h-20 w-36 md:w-44 bg-white/20 rounded animate-pulse"></div>
                </div>
            </div>

            <!-- Stats Skeleton -->
            <div class="relative z-20 bg-primary/95 backdrop-blur-md border-t border-cream/20">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4 max-w-[1400px] mx-auto px-4 md:px-5 py-6 md:py-8">
                    <div v-for="n in 5" :key="'stat-skeleton-' + n" class="text-center flex-1 relative">
                        <!-- Icon Skeleton -->
                        <div
                            class="flex items-center justify-center w-16 md:w-18 lg:w-20 h-16 md:h-18 lg:h-20 bg-cream/10 rounded-full mx-auto mb-2 md:mb-3 lg:mb-4 border-2 border-cream/20 animate-pulse">
                        </div>
                        <!-- Value Skeleton -->
                        <div class="h-6 md:h-8 w-12 md:w-16 bg-white/20 rounded mx-auto mb-1 md:mb-2 animate-pulse">
                        </div>
                        <!-- Label Skeleton -->
                        <div class="h-3 md:h-4 w-20 md:w-24 bg-white/20 rounded mx-auto animate-pulse"></div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Hero Content -->
        <div v-else-if="heroData" class="flex-1 flex items-center justify-start relative z-10">
            <!-- Background Slider -->
            <div class="absolute inset-0 w-full h-full overflow-hidden">
                <div v-for="(bg, index) in heroData.backgrounds" :key="index"
                    class="absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-1000" :class="{
                        'opacity-100': currentBackgroundIndex === index,
                        'opacity-0': currentBackgroundIndex !== index,
                    }">
                    <template v-if="bg">
                        <picture class="absolute inset-0 w-full h-full">
                            <source :srcset="getImageUrlForFormat(bg, 'webp')" type="image/webp" />
                            <source :srcset="bg" type="image/jpeg" />
                            <img v-lazy="bg" class="w-full h-full object-cover"
                                :alt="heroData.title || 'Hero Background'" />
                        </picture>
                    </template>
                    <template v-else>
                        <div class="absolute inset-0 w-full h-full flex items-center justify-center bg-gradient-to-br from-primary to-secondary">
                            <ImagePlaceholder variant="image" size="xl" text="Hero Background" altText="Gambar background hero tidak ditemukan" />
                        </div>
                    </template>
                </div>
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-secondary/35 to-secondary/50 z-10"></div>

            <div class="container mx-auto px-4 relative z-20">
                <div class="flex items-center justify-start min-h-[45vh] sm:min-h-[50vh] md:min-h-[60vh]">
                    <div class="max-w-[700px] text-white text-left">
                        <div class="mb-4 sm:mb-6 animate-fade-in">
                            <span
                                class="text-white font-semibold text-xs md:text-sm py-1.5 md:py-2.5 px-3 md:px-6 bg-cream/20 backdrop-blur-md rounded-full inline-flex items-center gap-2 border border-cream/30 animate-slide-in-left">
                                <i
                                    class="fa-solid fa-map-marker-alt flex-shrink-0 text-white w-3 md:w-3.5 h-3 md:h-3.5"></i>
                                {{ heroData.location }}
                            </span>
                        </div>

                        <div class="my-3 sm:my-6 animate-fade-in animation-delay-200">
                            <h1
                                class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl font-epilogue font-extrabold uppercase text-white leading-tight mb-4 sm:mb-6 tracking-wider drop-shadow-lg text-left">
                                {{ heroData.title }}
                            </h1>
                        </div>

                        <div class="animate-fade-in animation-delay-400">
                            <BadgeButton :href="whatsappUrl" target="_blank"
                                class="text-sm md:text-base px-3 md:px-6 py-2 md:py-3">
                                <span>Hubungi Kami</span>
                                <i class="fa-solid fa-external-link-alt w-4 md:w-5 h-4 md:h-5"></i>
                            </BadgeButton>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vertical Pagination Dots -->
            <div v-if="heroData.backgrounds.length > 1"
                class="absolute right-4 md:right-6 lg:right-8 top-1/2 -translate-y-1/2 z-30 flex flex-col items-center gap-1.5 md:gap-2 lg:gap-3">
                <button v-for="(bg, index) in heroData.backgrounds" :key="'dot-' + index" type="button"
                    @click="goToBackground(index)" class="transition-all duration-500 ease-in-out transform" :class="currentBackgroundIndex === index
                        ? 'h-8 md:h-10 lg:h-12 w-2 md:w-2.5 lg:w-3 bg-white rounded-full shadow-lg scale-100'
                        : 'w-1.5 md:w-2 lg:w-2.5 h-1.5 md:h-2 lg:h-2.5 bg-white/40 rounded-full hover:bg-white/60 hover:scale-110 md:hover:scale-125'
                        " :aria-label="`Go to background ${index + 1}`" />
            </div>
        </div>

        <div class="relative z-20 bg-primary backdrop-blur-md border-t border-cream/20">
            <div class="max-w-[1400px] mx-auto px-3 sm:px-4 md:px-5 py-4 sm:py-6 md:py-8">
                <!-- Desktop: 5 Stats Horizontal -->
                <div class="hidden md:grid grid-cols-5 gap-2 sm:gap-3 md:gap-4">
                    <div v-for="(stat, idx) in stats" :key="idx"
                        class="text-center relative transition-transform duration-300 hover:-translate-y-1.25">
                        <div
                            class="flex items-center justify-center w-10 sm:w-16 md:w-18 lg:w-20 h-10 sm:h-16 md:h-18 lg:h-20 bg-cream/10 rounded-full mx-auto mb-1 sm:mb-2 md:mb-3 lg:mb-4 text-white transition-all duration-300 border-2 border-cream/20 hover:bg-cream/20 hover:scale-110 hover:text-cream">
                            <i
                                :class="['fa-solid', 'fa-' + stat.icon, 'text-xs sm:text-xl md:text-2xl lg:text-3xl']"></i>
                        </div>
                        <div
                            class="text-base sm:text-2xl md:text-3xl lg:text-4xl font-epilogue font-extrabold text-white mb-0.5 sm:mb-1 md:mb-2 transition-all duration-300 hover:scale-110 hover:text-cream leading-tight">
                            {{ stat.value }}
                        </div>
                        <div
                            class="text-[0.65rem] sm:text-sm md:text-sm lg:text-base font-bold uppercase text-white tracking-wider">
                            {{ stat.label }}
                        </div>
                    </div>
                </div>

                <!-- Mobile: 3 Top + 2 Bottom (Centered) -->
                <div class="md:hidden">
                    <!-- Top 3 Stats -->
                    <div class="grid grid-cols-3 gap-2 sm:gap-3 mb-2 sm:mb-3">
                        <div v-for="(stat, idx) in stats.slice(0, 3)" :key="idx"
                            class="text-center relative transition-transform duration-300 hover:-translate-y-1.25">
                            <div
                                class="flex items-center justify-center w-10 sm:w-16 h-10 sm:h-16 bg-cream/10 rounded-full mx-auto mb-1 sm:mb-2 text-white transition-all duration-300 border-2 border-cream/20 hover:bg-cream/20 hover:scale-110 hover:text-cream">
                                <i :class="['fa-solid', 'fa-' + stat.icon, 'text-xs sm:text-xl']"></i>
                            </div>
                            <div
                                class="text-base sm:text-2xl font-epilogue font-extrabold text-white mb-0.5 sm:mb-1 transition-all duration-300 hover:scale-110 hover:text-cream leading-tight">
                                {{ stat.value }}
                            </div>
                            <div class="text-[0.65rem] sm:text-sm font-bold uppercase text-white tracking-wider">
                                {{ stat.label }}
                            </div>
                        </div>
                    </div>

                    <!-- Bottom 2 Stats (Centered) -->
                    <div class="grid grid-cols-2 gap-1 sm:gap-2 justify-center max-w-sm mx-auto">
                        <div v-for="(stat, idx) in stats.slice(3, 5)" :key="idx + 3"
                            class="text-center relative transition-transform duration-300 hover:-translate-y-1.25 px-1">
                            <div
                                class="flex items-center justify-center w-10 sm:w-16 h-10 sm:h-16 bg-cream/10 rounded-full mx-auto mb-1 sm:mb-2 text-white transition-all duration-300 border-2 border-cream/20 hover:bg-cream/20 hover:scale-110 hover:text-cream">
                                <i :class="['fa-solid', 'fa-' + stat.icon, 'text-xs sm:text-xl']"></i>
                            </div>
                            <div
                                class="text-base sm:text-2xl font-epilogue font-extrabold text-white mb-0.5 sm:mb-1 transition-all duration-300 hover:scale-110 hover:text-cream leading-tight">
                                {{ stat.value }}
                            </div>
                            <div class="text-[0.65rem] sm:text-sm font-bold uppercase text-white tracking-wider">
                                {{ stat.label }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useLandingPageData, useImageUrl, useWhatsApp } from '@/composables'
import BadgeButton from './BadgeButton.vue'
import ImagePlaceholder from '@/components/common/ImagePlaceholder.vue'

const { data: landingPageData, isLoading } = useLandingPageData()
const { getImageUrlForFormat } = useImageUrl()
const { createWhatsAppUrl } = useWhatsApp()

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
    return createWhatsAppUrl(contactInfo.value)
})

const goToBackground = (index: number) => {
    currentBackgroundIndex.value = index
    startBackgroundSlider()
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

onUnmounted(() => {
    if (sliderInterval) {
        clearInterval(sliderInterval)
    }
})
</script>
