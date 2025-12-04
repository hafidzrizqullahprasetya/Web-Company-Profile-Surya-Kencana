<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <footer class="bg-primary relative z-40 shadow-2xl">
        <div class="py-8 md:py-14 lg:py-16">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-7 lg:gap-8">
                    <!-- About Widget -->
                    <div>
                        <div class="mb-3 md:mb-5 lg:mb-6">
                            <router-link to="/">
                                <!-- Loading skeleton -->
                                <div v-if="isLoading" class="max-w-[150px] h-12 bg-white/20 animate-pulse rounded">
                                </div>
                                <!-- Logo -->
                                <template v-else-if="siteSettings?.company_logo_url">
                                    <picture class="inline-block bg-white p-3 rounded-lg shadow-sm">
                                        <source :srcset="siteSettings.company_logo_url.replace(
                                            /\.(jpg|jpeg|png)$/,
                                            '.webp',
                                        )
                                            " type="image/webp" />
                                        <source :srcset="siteSettings.company_logo_url" type="image/png" />
                                        <img v-lazy="siteSettings.company_logo_url"
                                            :alt="siteSettings.company_name + ' Logo'"
                                            class="max-w-[70px] md:max-w-[90px] h-auto" />
                                    </picture>
                                </template>
                                <template v-else>
                                    <div
                                        class="inline-block bg-white p-3 rounded-lg shadow-sm flex items-center justify-center">
                                        <ImagePlaceholder variant="logo" size="md" text="Logo"
                                            altText="Logo perusahaan tidak ditemukan" />
                                    </div>
                                </template>
                            </router-link>
                        </div>
                        <p class="text-white/80 text-xs md:text-sm leading-relaxed mb-3 md:mb-5 lg:mb-6">
                            {{ siteSettings?.company_name || 'Your Company' }} - Your trusted
                            partner in industrial machinery solutions.
                        </p>
                        <ul class="flex space-x-1.5 md:space-x-2.5 lg:space-x-3">
                            <li>
                                <a href="#"
                                    class="w-7 md:w-9 h-7 md:h-9 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300">
                                    <i class="fa-brands fa-facebook w-3 md:w-4 h-3 md:h-4"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="w-7 md:w-9 h-7 md:h-9 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300">
                                    <i class="fa-brands fa-twitter w-3 md:w-4 h-3 md:h-4"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="w-7 md:w-9 h-7 md:h-9 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300">
                                    <i class="fa-brands fa-instagram w-3 md:w-4 h-3 md:h-4"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="w-7 md:w-9 h-7 md:h-9 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300">
                                    <i class="fa-brands fa-linkedin w-3 md:w-4 h-3 md:h-4"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="w-8 md:w-9 h-8 md:h-9 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300">
                                    <i class="fa-brands fa-twitter w-3.5 md:w-4 h-3.5 md:h-4"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="w-8 md:w-9 h-8 md:h-9 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300">
                                    <i class="fa-brands fa-instagram w-3.5 md:w-4 h-3.5 md:h-4"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="w-8 md:w-9 h-8 md:h-9 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300">
                                    <i class="fa-brands fa-linkedin w-3.5 md:w-4 h-3.5 md:h-4"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3
                            class="text-white text-base md:text-xl font-semibold mb-3 md:mb-5 lg:mb-6 uppercase relative">
                            Quick Links
                            <div class="absolute -bottom-1 left-0 w-12 h-0.5 bg-cream"></div>
                        </h3>
                        <ul class="space-y-1.5 md:space-y-2.5 lg:space-y-3">
                            <li>
                                <a href="#home" @click="(e) => scrollToSection(e, 'home')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer text-xs md:text-sm">
                                    <i class="fa-solid fa-arrow-right w-2.5 h-2.5 md:w-3 md:h-3 mr-2"></i>
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#visi-misi" @click="(e) => scrollToSection(e, 'visi-misi')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer text-xs md:text-sm">
                                    <i class="fa-solid fa-arrow-right w-2.5 h-2.5 md:w-3 md:h-3 mr-2"></i>
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="#produk" @click="(e) => scrollToSection(e, 'produk')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer text-xs md:text-sm">
                                    <i class="fa-solid fa-arrow-right w-2.5 h-2.5 md:w-3 md:h-3 mr-2"></i>
                                    Products
                                </a>
                            </li>
                            <li>
                                <a href="#riwayat" @click="(e) => scrollToSection(e, 'riwayat')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer text-xs md:text-sm">
                                    <i class="fa-solid fa-arrow-right w-2.5 h-2.5 md:w-3 md:h-3 mr-2"></i>
                                    Gallery
                                </a>
                            </li>
                            <li>
                                <a href="#clients" @click="(e) => scrollToSection(e, 'clients')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer text-xs md:text-sm">
                                    <i class="fa-solid fa-arrow-right w-2.5 h-2.5 md:w-3 md:h-3 mr-2"></i>
                                    Clients
                                </a>
                            </li>
                            <li>
                                <a href="#kontak" @click="(e) => scrollToSection(e, 'kontak')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer text-xs md:text-sm">
                                    <i class="fa-solid fa-arrow-right w-2.5 h-2.5 md:w-3 md:h-3 mr-2"></i>
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3
                            class="text-white text-base md:text-xl font-semibold mb-3 md:mb-5 lg:mb-6 uppercase relative">
                            Contact Info
                            <div class="absolute -bottom-1 left-0 w-12 h-0.5 bg-cream"></div>
                        </h3>
                        <ul v-if="contactInfo" class="space-y-2 md:space-y-3.5 lg:space-y-4">
                            <li v-if="contactInfo.address" class="flex items-start">
                                <i
                                    class="fa-solid fa-map-marker-alt text-white w-3.5 md:w-5 h-3.5 md:h-5 mr-2 md:mr-3 mt-0.5 md:mt-1 flex-shrink-0"></i>
                                <div>
                                    <span class="text-white/80 text-xs md:text-sm"
                                        v-html="contactInfo.address.replace(/\n/g, '<br>')"></span>
                                </div>
                            </li>
                            <li v-if="contactInfo.phone" class="flex items-start">
                                <i
                                    class="fa-solid fa-phone text-white w-3.5 md:w-5 h-3.5 md:h-5 mr-2 md:mr-3 mt-0.5 md:mt-1 flex-shrink-0"></i>
                                <div>
                                    <a :href="`tel:${contactInfo.phone}`"
                                        class="text-white/80 text-xs md:text-sm hover:text-cream transition-colors">
                                        {{ contactInfo.phone }}
                                    </a>
                                </div>
                            </li>
                            <li v-if="contactInfo.email" class="flex items-start">
                                <i
                                    class="fa-solid fa-envelope text-white w-3.5 md:w-5 h-3.5 md:h-5 mr-2 md:mr-3 mt-0.5 md:mt-1 flex-shrink-0"></i>
                                <div>
                                    <a :href="`mailto:${contactInfo.email}`"
                                        class="text-white/80 text-xs md:text-sm hover:text-cream transition-colors">
                                        {{ contactInfo.email }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <div v-else class="text-white/60 text-sm">
                            Loading contact information...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lower Footer -->
        <div class="py-4 md:py-6 border-t border-secondary/20">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3 md:gap-0">
                    <div class="text-white/80 text-xs md:text-sm mb-0">
                        <p>
                            &copy; {{ currentYear }}
                            {{ siteSettings?.company_name || 'Company Name' }}. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import ImagePlaceholder from '@/components/common/ImagePlaceholder.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const currentYear = computed(() => new Date().getFullYear())
const contactInfo = computed(() => landingPageData.value?.contact || null)
const siteSettings = computed(() => landingPageData.value?.siteSettings || null)

// Smooth scroll to section
const scrollToSection = (event: Event, sectionId: string) => {
    event.preventDefault()

    const element = document.getElementById(sectionId)
    if (element) {
        const headerOffset = 120 // Height of fixed header
        const elementPosition = element.getBoundingClientRect().top
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth',
        })
    } else if (sectionId === 'home') {
        // If home, scroll to top
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        })
    }
}
</script>
