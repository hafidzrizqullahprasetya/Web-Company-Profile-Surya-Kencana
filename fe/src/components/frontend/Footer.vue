<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <footer class="bg-primary">
        <div class="py-20">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- About Widget -->
                    <div>
                        <div class="mb-6">
                            <router-link to="/">
                                <!-- Loading skeleton -->
                                <div
                                    v-if="!siteSettings?.company_logo_url"
                                    class="max-w-[150px] h-12 bg-white/20 animate-pulse rounded"
                                ></div>
                                <!-- Logo -->
                                <picture v-else class="inline-block bg-white p-3 rounded-lg shadow-sm">
                                    <source
                                        :srcset="
                                            siteSettings.company_logo_url.replace(
                                                /\.(jpg|jpeg|png)$/,
                                                '.webp',
                                            )
                                        "
                                        type="image/webp"
                                    />
                                    <source
                                        :srcset="siteSettings.company_logo_url"
                                        type="image/png"
                                    />
                                    <img
                                        v-lazy="siteSettings.company_logo_url"
                                        :alt="siteSettings.company_name + ' Logo'"
                                        class="max-w-[100px] h-auto"
                                    />
                                </picture>
                            </router-link>
                        </div>
                        <p class="text-white/80 text-sm leading-relaxed mb-6">
                            {{ siteSettings?.company_name || 'Your Company' }} - Your trusted
                            partner in industrial machinery solutions.
                        </p>
                        <ul class="flex space-x-3">
                            <li>
                                <a
                                    href="#"
                                    class="w-10 h-10 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300"
                                >
                                    <i class="fa-brands fa-facebook w-4 h-4"></i>
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="w-10 h-10 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300"
                                >
                                    <i class="fa-brands fa-twitter w-4 h-4"></i>
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="w-10 h-10 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300"
                                >
                                    <i class="fa-brands fa-instagram w-4 h-4"></i>
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="w-10 h-10 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300"
                                >
                                    <i class="fa-brands fa-linkedin w-4 h-4"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-white text-xl font-semibold mb-6 uppercase relative">
                            Quick Links
                            <div class="absolute -bottom-1 left-0 w-12 h-0.5 bg-cream"></div>
                        </h3>
                        <ul class="space-y-3">
                            <li>
                                <a
                                    href="#home"
                                    @click="(e) => scrollToSection(e, 'home')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer"
                                >
                                    <i class="fa-solid fa-arrow-right w-3 h-3 mr-2"></i>
                                    Home
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#visi-misi"
                                    @click="(e) => scrollToSection(e, 'visi-misi')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer"
                                >
                                    <i class="fa-solid fa-arrow-right w-3 h-3 mr-2"></i>
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#produk"
                                    @click="(e) => scrollToSection(e, 'produk')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer"
                                >
                                    <i class="fa-solid fa-arrow-right w-3 h-3 mr-2"></i>
                                    Products
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#riwayat"
                                    @click="(e) => scrollToSection(e, 'riwayat')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer"
                                >
                                    <i class="fa-solid fa-arrow-right w-3 h-3 mr-2"></i>
                                    Gallery
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#clients"
                                    @click="(e) => scrollToSection(e, 'clients')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer"
                                >
                                    <i class="fa-solid fa-arrow-right w-3 h-3 mr-2"></i>
                                    Clients
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#kontak"
                                    @click="(e) => scrollToSection(e, 'kontak')"
                                    class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center cursor-pointer"
                                >
                                    <i class="fa-solid fa-arrow-right w-3 h-3 mr-2"></i>
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-white text-xl font-semibold mb-6 uppercase relative">
                            Contact Info
                            <div class="absolute -bottom-1 left-0 w-12 h-0.5 bg-cream"></div>
                        </h3>
                        <ul v-if="contactInfo" class="space-y-4">
                            <li v-if="contactInfo.address" class="flex items-start">
                                <i
                                    class="fa-solid fa-map-marker-alt text-cream w-5 h-5 mr-3 mt-1 flex-shrink-0"
                                ></i>
                                <div>
                                    <span
                                        class="text-white/80 text-sm"
                                        v-html="contactInfo.address.replace(/\n/g, '<br>')"
                                    ></span>
                                </div>
                            </li>
                            <li v-if="contactInfo.phone" class="flex items-start">
                                <i
                                    class="fa-solid fa-phone text-cream w-5 h-5 mr-3 mt-1 flex-shrink-0"
                                ></i>
                                <div>
                                    <a
                                        :href="`tel:${contactInfo.phone}`"
                                        class="text-white/80 text-sm hover:text-cream transition-colors"
                                    >
                                        {{ contactInfo.phone }}
                                    </a>
                                </div>
                            </li>
                            <li v-if="contactInfo.email" class="flex items-start">
                                <i
                                    class="fa-solid fa-envelope text-cream w-5 h-5 mr-3 mt-1 flex-shrink-0"
                                ></i>
                                <div>
                                    <a
                                        :href="`mailto:${contactInfo.email}`"
                                        class="text-white/80 text-sm hover:text-cream transition-colors"
                                    >
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
        <div class="py-6 border-t border-secondary/20">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-white/80 text-sm mb-3 md:mb-0">
                        <p>
                            &copy; {{ currentYear }}
                            {{ siteSettings?.company_name || 'Company Name' }}. All rights reserved.
                        </p>
                    </div>
                    <div>
                        <ul class="flex space-x-6">
                            <li>
                                <a
                                    href="#"
                                    class="text-white/80 hover:text-cream text-sm transition-colors duration-300"
                                >
                                    Privacy Policy
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="text-white/80 hover:text-cream text-sm transition-colors duration-300"
                                >
                                    Terms & Conditions
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll to Top Button -->
        <button
            @click="scrollToTop"
            :class="{ 'opacity-100 visible': showScrollTop, 'opacity-0 invisible': !showScrollTop }"
            class="fixed bottom-8 right-8 w-12 h-12 bg-cream hover:bg-cream/90 text-secondary rounded-full flex items-center justify-center shadow-lg transition-all duration-300 z-50"
        >
            <i class="fa-solid fa-arrow-up w-5 h-5"></i>
        </button>
    </footer>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'

const { data: landingPageData } = useLandingPageData()

const showScrollTop = ref(false)
const currentYear = computed(() => new Date().getFullYear())
const contactInfo = computed(() => landingPageData.value?.contact || null)
const siteSettings = computed(() => landingPageData.value?.siteSettings || null)

const handleScroll = () => {
    showScrollTop.value = window.scrollY > 300
}

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    })
}

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

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>
