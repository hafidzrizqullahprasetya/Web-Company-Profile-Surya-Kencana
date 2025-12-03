<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div>
        <header id="header" :class="[
            'fixed left-0 right-0 z-[100] transition-all duration-300 shadow-lg',
            isScrolled ? 'top-6' : 'top-0',
            isScrolled ? 'mx-6 rounded-[1.5rem] scale-95' : 'mx-0',
            isOnPrimarySection ? 'bg-white' : 'bg-primary',
        ]">
            <nav class="navigation py-2 md:py-3">
                <div class="container mx-auto px-4 md:px-6">
                    <div class="flex items-center justify-between">
                        <div class="logo-area">
                            <router-link to="/" class="navbar-brand">
                                <!-- Loading skeleton -->
                                <div v-if="isLoadingData"
                                    class="inline-block bg-white p-2 rounded-lg">
                                    <div class="h-6 md:h-8 w-16 md:w-20 bg-gray-300 animate-pulse rounded"></div>
                                </div>
                                <!-- Logo -->
                                <template v-else-if="isLogoAvailable">
                                    <picture class="inline-block bg-white p-2 rounded-lg">
                                        <source
                                            :srcset="siteSettings?.company_logo_url?.replace(/\.(jpg|jpeg|png)$/, '.webp') || ''"
                                            type="image/webp" />
                                        <source :srcset="siteSettings?.company_logo_url || ''" type="image/png" />
                                        <img v-lazy="siteSettings?.company_logo_url"
                                            :alt="(siteSettings?.company_name || 'Company') + ' Logo'"
                                            class="h-6 md:h-8 transition-all duration-300 block" />
                                    </picture>
                                </template>
                                <template v-else>
                                    <div class="inline-block bg-white p-2 rounded-lg flex items-center justify-center">
                                        <ImagePlaceholder variant="logo" size="sm" text="Logo" altText="Logo perusahaan tidak ditemukan" />
                                    </div>
                                </template>
                            </router-link>
                        </div>

                        <div class="hidden lg:flex items-center justify-center flex-1 px-8">
                            <ul class="flex items-center gap-8 xl:gap-10 list-none p-0 m-0">
                                <li>
                                    <a href="#home" :class="[
                                        'nav-link font-bold text-sm uppercase py-2 px-0 relative transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:transition-all after:duration-300 hover:after:w-full whitespace-nowrap',
                                        isOnPrimarySection
                                            ? 'text-primary hover:text-secondary after:bg-secondary'
                                            : 'text-white hover:text-cream after:bg-cream',
                                        activeSection === 'home'
                                            ? isOnPrimarySection
                                                ? 'text-secondary after:w-full'
                                                : 'text-cream after:w-full'
                                            : '',
                                    ]" @click="(e) => scrollToSection(e, 'home')">
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="#visi-misi" :class="[
                                        'nav-link font-bold text-sm uppercase py-2 px-0 relative transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:transition-all after:duration-300 hover:after:w-full whitespace-nowrap',
                                        isOnPrimarySection
                                            ? 'text-primary hover:text-secondary after:bg-secondary'
                                            : 'text-white hover:text-cream after:bg-cream',
                                        activeSection === 'visi-misi'
                                            ? isOnPrimarySection
                                                ? 'text-secondary after:w-full'
                                                : 'text-cream after:w-full'
                                            : '',
                                    ]" @click="(e) => scrollToSection(e, 'visi-misi')">
                                        About Us
                                    </a>
                                </li>
                                <li>
                                    <a href="#produk" :class="[
                                        'nav-link font-bold text-sm uppercase py-2 px-0 relative transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:transition-all after:duration-300 hover:after:w-full whitespace-nowrap',
                                        isOnPrimarySection
                                            ? 'text-primary hover:text-secondary after:bg-secondary'
                                            : 'text-white hover:text-cream after:bg-cream',
                                        activeSection === 'produk'
                                            ? isOnPrimarySection
                                                ? 'text-secondary after:w-full'
                                                : 'text-cream after:w-full'
                                            : '',
                                    ]" @click="(e) => scrollToSection(e, 'produk')">
                                        Products
                                    </a>
                                </li>
                                <li>
                                    <a href="#riwayat" :class="[
                                        'nav-link font-bold text-sm uppercase py-2 px-0 relative transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:transition-all after:duration-300 hover:after:w-full whitespace-nowrap',
                                        isOnPrimarySection
                                            ? 'text-primary hover:text-secondary after:bg-secondary'
                                            : 'text-white hover:text-cream after:bg-cream',
                                        activeSection === 'riwayat'
                                            ? isOnPrimarySection
                                                ? 'text-secondary after:w-full'
                                                : 'text-cream after:w-full'
                                            : '',
                                    ]" @click="(e) => scrollToSection(e, 'riwayat')">
                                        Gallery
                                    </a>
                                </li>
                                <li>
                                    <a href="#clients" :class="[
                                        'nav-link font-bold text-sm uppercase py-2 px-0 relative transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:transition-all after:duration-300 hover:after:w-full whitespace-nowrap',
                                        isOnPrimarySection
                                            ? 'text-primary hover:text-secondary after:bg-secondary'
                                            : 'text-white hover:text-cream after:bg-cream',
                                        activeSection === 'clients'
                                            ? isOnPrimarySection
                                                ? 'text-secondary after:w-full'
                                                : 'text-cream after:w-full'
                                            : '',
                                    ]" @click="(e) => scrollToSection(e, 'clients')">
                                        Clients
                                    </a>
                                </li>
                                <li>
                                    <a href="#testimoni" :class="[
                                        'nav-link font-bold text-sm uppercase py-2 px-0 relative transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:transition-all after:duration-300 hover:after:w-full whitespace-nowrap',
                                        isOnPrimarySection
                                            ? 'text-primary hover:text-secondary after:bg-secondary'
                                            : 'text-white hover:text-cream after:bg-cream',
                                        activeSection === 'testimoni'
                                            ? isOnPrimarySection
                                                ? 'text-secondary after:w-full'
                                                : 'text-cream after:w-full'
                                            : '',
                                    ]" @click="(e) => scrollToSection(e, 'testimoni')">
                                        Testimonials
                                    </a>
                                </li>
                                <li>
                                    <a href="#kontak" :class="[
                                        'nav-link font-bold text-sm uppercase py-2 px-0 relative transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:transition-all after:duration-300 hover:after:w-full whitespace-nowrap',
                                        isOnPrimarySection
                                            ? 'text-primary hover:text-secondary after:bg-secondary'
                                            : 'text-white hover:text-cream after:bg-cream',
                                        activeSection === 'kontak'
                                            ? isOnPrimarySection
                                                ? 'text-secondary after:w-full'
                                                : 'text-cream after:w-full'
                                            : '',
                                    ]" @click="(e) => scrollToSection(e, 'kontak')">
                                        Contact
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="hidden lg:flex items-center gap-4">
                            <BadgeButton href="/login" :variant="isOnPrimarySection ? 'default' : 'inverted'" size="sm">
                                <span>Admin Login</span>
                                <i class="fa-solid fa-user w-4 h-4"></i>
                            </BadgeButton>
                        </div>

                        <div class="lg:hidden z-[130] relative">
                            <button @click="toggleMobileMenu" type="button" :class="[
                                'mobile-menu-btn p-2 transition-all duration-300',
                                isOnPrimarySection ? 'text-primary' : 'text-white',
                            ]">
                                <span class="sr-only">Toggle navigation</span>
                                <div class="hamburger-lines flex flex-col gap-1.5">
                                    <span :class="[
                                        'line w-7 h-0.5 transition-all duration-300',
                                        isOnPrimarySection ? 'bg-primary' : 'bg-white',
                                        { 'rotate-45 translate-y-2': isMobileMenuOpen },
                                    ]"></span>
                                    <span :class="[
                                        'line w-7 h-0.5 transition-all duration-300',
                                        isOnPrimarySection ? 'bg-primary' : 'bg-white',
                                        { 'opacity-0': isMobileMenuOpen },
                                    ]"></span>
                                    <span :class="[
                                        'line w-7 h-0.5 transition-all duration-300',
                                        isOnPrimarySection ? 'bg-primary' : 'bg-white',
                                        { '-rotate-45 -translate-y-2': isMobileMenuOpen },
                                    ]"></span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="mobile-menu fixed inset-0 z-[120] transition-all duration-300 lg:hidden" :class="[
            isMobileMenuOpen ? 'visible opacity-100 pointer-events-auto' : 'invisible opacity-0 pointer-events-none'
        ]">
            <div class="mobile-menu-overlay absolute inset-0 bg-black/70 backdrop-blur-sm transition-opacity duration-300"
                @click="toggleMobileMenu"></div>
            <div class="mobile-menu-content absolute top-0 right-0 w-[85%] max-w-sm h-full bg-primary p-6 sm:p-8 overflow-y-auto transition-transform duration-300 ease-out shadow-2xl"
                :class="[
                    isMobileMenuOpen ? 'translate-x-0' : 'translate-x-full'
                ]">
                <div class="mobile-menu-header flex justify-between items-center mb-8 pb-4 border-b border-white/10">
                    <picture v-if="siteSettings?.company_logo_url" class="inline-block bg-white p-2 rounded-lg">
                        <source :srcset="siteSettings.company_logo_url.replace(/\.(jpg|jpeg|png)$/, '.webp')"
                            type="image/webp" />
                        <source :srcset="siteSettings.company_logo_url" type="image/png" />
                        <img :src="siteSettings.company_logo_url" :alt="siteSettings.company_name + ' Logo'"
                            class="h-8 sm:h-10 block" />
                    </picture>
                    <button @click="toggleMobileMenu"
                        class="mobile-close-btn text-white text-2xl p-2 transition-all duration-300 hover:text-cream hover:rotate-90">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                <ul class="mobile-menu-list list-none p-0 m-0 space-y-2">
                    <li>
                        <a href="#home" @click="
                            (e) => {
                                scrollToSection(e, 'home')
                                toggleMobileMenu()
                            }
                        " :class="[
                            'mobile-nav-link block text-sm font-semibold py-2.5 px-3 rounded-lg border-b border-white/10 uppercase transition-all duration-300 hover:bg-white/15 hover:pl-5',
                            activeSection === 'home' ? 'bg-white/20 text-cream' : 'text-white hover:text-cream'
                        ]">Home</a>
                    </li>
                    <li>
                        <a href="#visi-misi" @click="
                            (e) => {
                                scrollToSection(e, 'visi-misi')
                                toggleMobileMenu()
                            }
                        " :class="[
                            'mobile-nav-link block text-sm font-semibold py-2.5 px-3 rounded-lg border-b border-white/10 uppercase transition-all duration-300 hover:bg-white/15 hover:pl-5',
                            activeSection === 'visi-misi' ? 'bg-white/20 text-cream' : 'text-white hover:text-cream'
                        ]">About Us</a>
                    </li>
                    <li>
                        <a href="#produk" @click="
                            (e) => {
                                scrollToSection(e, 'produk')
                                toggleMobileMenu()
                            }
                        " :class="[
                            'mobile-nav-link block text-sm font-semibold py-2.5 px-3 rounded-lg border-b border-white/10 uppercase transition-all duration-300 hover:bg-white/15 hover:pl-5',
                            activeSection === 'produk' ? 'bg-white/20 text-cream' : 'text-white hover:text-cream'
                        ]">Products</a>
                    </li>
                    <li>
                        <a href="#riwayat" @click="
                            (e) => {
                                scrollToSection(e, 'riwayat')
                                toggleMobileMenu()
                            }
                        " :class="[
                            'mobile-nav-link block text-sm font-semibold py-2.5 px-3 rounded-lg border-b border-white/10 uppercase transition-all duration-300 hover:bg-white/15 hover:pl-5',
                            activeSection === 'riwayat' ? 'bg-white/20 text-cream' : 'text-white hover:text-cream'
                        ]">Gallery</a>
                    </li>
                    <li>
                        <a href="#clients" @click="
                            (e) => {
                                scrollToSection(e, 'clients')
                                toggleMobileMenu()
                            }
                        " :class="[
                            'mobile-nav-link block text-sm font-semibold py-2.5 px-3 rounded-lg border-b border-white/10 uppercase transition-all duration-300 hover:bg-white/15 hover:pl-5',
                            activeSection === 'clients' ? 'bg-white/20 text-cream' : 'text-white hover:text-cream'
                        ]">Clients</a>
                    </li>
                    <li>
                        <a href="#testimoni" @click="
                            (e) => {
                                scrollToSection(e, 'testimoni')
                                toggleMobileMenu()
                            }
                        " :class="[
                            'mobile-nav-link block text-sm font-semibold py-2.5 px-3 rounded-lg border-b border-white/10 uppercase transition-all duration-300 hover:bg-white/15 hover:pl-5',
                            activeSection === 'testimoni' ? 'bg-white/20 text-cream' : 'text-white hover:text-cream'
                        ]">Testimonials</a>
                    </li>
                    <li>
                        <a href="#kontak" @click="
                            (e) => {
                                scrollToSection(e, 'kontak')
                                toggleMobileMenu()
                            }
                        " :class="[
                            'mobile-nav-link block text-sm font-semibold py-2.5 px-3 rounded-lg border-b border-white/10 uppercase transition-all duration-300 hover:bg-white/15 hover:pl-5',
                            activeSection === 'kontak' ? 'bg-white/20 text-cream' : 'text-white hover:text-cream'
                        ]">Contact</a>
                    </li>
                </ul>

                <div class="mobile-menu-footer mt-8 pt-4 border-t border-white/10">
                    <div class="flex flex-col gap-3">
                        <BadgeButton href="/login" variant="inverted" size="md" class="w-full justify-center">
                            <span class="text-sm">Admin Login</span>
                            <i class="fa-solid fa-user w-4 h-4"></i>
                        </BadgeButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import BadgeButton from './BadgeButton.vue'
import ImagePlaceholder from '@/components/common/ImagePlaceholder.vue'

const { data: landingPageData, isLoading: isLoadingData } = useLandingPageData()

const isMobileMenuOpen = ref(false)
const activeSubmenu = ref<string | null>(null)
const isScrolled = ref(false)
const activeSection = ref('home')
const siteSettings = computed(() => landingPageData.value?.siteSettings || null)
const isOnPrimarySection = ref(false)

// Computed to check if logo is available after data has loaded
const isLogoAvailable = computed(() => {
  if (isLoadingData.value) return false; // Still loading
  return !!siteSettings.value?.company_logo_url; // Check if logo exists
})

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value
    if (!isMobileMenuOpen.value) {
        activeSubmenu.value = null
    }

    if (isMobileMenuOpen.value) {
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = ''
    }
}

const setActiveSection = (section: string) => {
    activeSection.value = section
}

// Smooth scroll to section - uses Tailwind scroll-mt-* classes
const scrollToSection = (event: Event, sectionId: string) => {
    event.preventDefault()

    const element = document.getElementById(sectionId)
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        })
        setActiveSection(sectionId)
    } else if (sectionId === 'home') {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        })
        setActiveSection('home')
    }
}

const handleScroll = () => {
    isScrolled.value = window.scrollY > 100
    const sections = ['home', 'visi-misi', 'produk', 'riwayat', 'clients', 'testimoni', 'kontak']
    const primarySections = ['riwayat', 'testimoni']
    const scrollPosition = window.scrollY + 250

    for (const section of sections) {
        const element = document.getElementById(section)
        if (element) {
            const offsetTop = element.offsetTop
            const offsetHeight = element.offsetHeight

            if (scrollPosition >= offsetTop && scrollPosition < offsetTop + offsetHeight) {
                activeSection.value = section
                isOnPrimarySection.value = primarySections.includes(section)
                break
            }
        }
    }
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
    handleScroll()
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
    document.body.style.overflow = ''
})
</script>
