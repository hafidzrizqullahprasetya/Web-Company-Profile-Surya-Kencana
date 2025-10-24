<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <header
    id="header"
    :class="[
      'fixed left-0 w-full z-50 bg-primary transition-all duration-300 shadow-lg',
      isScrolled ? 'top-6 rounded-[1.5rem]' : 'top-0 rounded-b-[1.5rem]',
      isScrolled ? 'py-2 scale-95' : 'py-6 scale-100',
    ]"
  >
    <div class="relative h-full">
      <nav class="navigation">
        <div class="container mx-auto px-4">
          <div class="flex items-center justify-between h-20">
            <div class="logo-area">
              <router-link to="/" class="navbar-brand">
                <img
                  src="https://placehold.co/150x50/FFFFFF/1C1817?text=SURYA KENCANA&font=raleway"
                  alt="SURYA KENCANA Logo"
                  class="h-12 transition-all duration-300"
                />
              </router-link>
            </div>

            <div class="hidden lg:flex items-center justify-center flex-1">
              <ul class="flex items-center gap-10 list-none p-0 m-0">
                <li>
                  <a
                    href="#"
                    class="nav-link text-white font-semibold text-sm uppercase py-3 px-0 relative transition-all duration-300 hover:text-cream after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-cream after:transition-all after:duration-300 hover:after:w-full"
                    :class="{ 'text-cream after:w-full': activeSection === 'home' }"
                    @click="setActiveSection('home')"
                  >
                    Home
                  </a>
                </li>
                <li>
                  <a
                    href="#visi-misi"
                    class="nav-link text-white font-semibold text-sm uppercase py-3 px-0 relative transition-all duration-300 hover:text-cream after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-cream after:transition-all after:duration-300 hover:after:w-full"
                    :class="{ 'text-cream after:w-full': activeSection === 'visi-misi' }"
                    @click="setActiveSection('visi-misi')"
                  >
                    About Us
                  </a>
                </li>
                <li>
                  <a
                    href="#produk"
                    class="nav-link text-white font-semibold text-sm uppercase py-3 px-0 relative transition-all duration-300 hover:text-cream after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-cream after:transition-all after:duration-300 hover:after:w-full"
                    :class="{ 'text-cream after:w-full': activeSection === 'produk' }"
                    @click="setActiveSection('produk')"
                  >
                    Products
                  </a>
                </li>
                <li>
                  <a
                    href="#riwayat"
                    class="nav-link text-white font-semibold text-sm uppercase py-3 px-0 relative transition-all duration-300 hover:text-cream after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-cream after:transition-all after:duration-300 hover:after:w-full"
                    :class="{ 'text-cream after:w-full': activeSection === 'riwayat' }"
                    @click="setActiveSection('riwayat')"
                  >
                    Gallery
                  </a>
                </li>
                <li>
                  <a
                    href="#testimoni"
                    class="nav-link text-white font-semibold text-sm uppercase py-3 px-0 relative transition-all duration-300 hover:text-cream after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-cream after:transition-all after:duration-300 hover:after:w-full"
                    :class="{ 'text-cream after:w-full': activeSection === 'testimoni' }"
                    @click="setActiveSection('testimoni')"
                  >
                    Testimonials
                  </a>
                </li>
                <li>
                  <a
                    href="#kontak"
                    class="nav-link text-white font-semibold text-sm uppercase py-3 px-0 relative transition-all duration-300 hover:text-cream after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-cream after:transition-all after:duration-300 hover:after:w-full"
                    :class="{ 'text-cream after:w-full': activeSection === 'kontak' }"
                    @click="setActiveSection('kontak')"
                  >
                    Contact
                  </a>
                </li>
              </ul>
            </div>

            <div class="hidden lg:flex items-center gap-4">
              <router-link
                to="/login"
                class="login-button bg-white text-primary font-semibold text-sm uppercase px-5 py-3 border-2 border-primary rounded-md flex items-center gap-2 transition-all duration-300 hover:bg-cream hover:shadow-lg"
              >
                <span class="login-text">Admin Login</span>
                <i-lucide:user class="login-icon w-5 h-5" />
              </router-link>
            </div>

            <div class="lg:hidden">
              <button
                @click="toggleMobileMenu"
                type="button"
                class="mobile-menu-btn text-white p-2 transition-all duration-300"
              >
                <span class="sr-only">Toggle navigation</span>
                <div class="hamburger-lines flex flex-col gap-1">
                  <span
                    class="line w-6 h-0.5 bg-white transition-all duration-300"
                    :class="{ 'rotate-45 translate-y-1.5': isMobileMenuOpen }"
                  ></span>
                  <span
                    class="line w-6 h-0.5 bg-white transition-all duration-300"
                    :class="{ 'opacity-0': isMobileMenuOpen }"
                  ></span>
                  <span
                    class="line w-6 h-0.5 bg-white transition-all duration-300"
                    :class="{ '-rotate-45 -translate-y-1.5': isMobileMenuOpen }"
                  ></span>
                </div>
              </button>
            </div>
          </div>
        </div>
      </nav>

      <div
        class="mobile-menu fixed top-0 left-0 w-full h-screen z-[9999] invisible opacity-0 transition-all duration-300"
        :class="{ 'visible opacity-100': isMobileMenuOpen }"
      >
        <div
          class="mobile-menu-overlay absolute inset-0 bg-black/70"
          @click="toggleMobileMenu"
        ></div>
        <div
          class="mobile-menu-content absolute top-0 right-0 w-80 h-full bg-secondary p-8 overflow-y-auto transform translate-x-full transition-transform duration-300"
          :class="{ 'translate-x-0': isMobileMenuOpen }"
        >
          <div
            class="mobile-menu-header flex justify-between items-center mb-10 pb-5 border-b border-white/10"
          >
            <img
              src="https://placehold.co/120x40/FFFFFF/1C1817?text=SURYA KENCANA&font=raleway"
              alt="SURYA KENCANA Logo"
              class="h-10"
            />
            <button
              @click="toggleMobileMenu"
              class="mobile-close-btn text-white text-xl p-2 transition-all duration-300 hover:text-primary"
            >
              <i-lucide:x />
            </button>
          </div>

          <ul class="mobile-menu-list list-none p-0 m-0">
            <li class="mb-2">
              <a
                href="#"
                @click="toggleMobileMenu"
                class="mobile-nav-link text-white text-base font-semibold py-4 px-0 border-b border-white/10 uppercase transition-all duration-300 hover:text-primary"
                >Home</a
              >
            </li>
            <li class="mb-2">
              <a
                href="#visi-misi"
                @click="toggleMobileMenu"
                class="mobile-nav-link text-white text-base font-semibold py-4 px-0 border-b border-white/10 uppercase transition-all duration-300 hover:text-primary"
                >About Us</a
              >
            </li>
            <li class="mb-2">
              <a
                href="#produk"
                @click="toggleMobileMenu"
                class="mobile-nav-link text-white text-base font-semibold py-4 px-0 border-b border-white/10 uppercase transition-all duration-300 hover:text-primary"
                >Products</a
              >
            </li>
            <li class="mb-2">
              <a
                href="#riwayat"
                @click="toggleMobileMenu"
                class="mobile-nav-link text-white text-base font-semibold py-4 px-0 border-b border-white/10 uppercase transition-all duration-300 hover:text-primary"
                >Gallery</a
              >
            </li>
            <li class="mb-2">
              <a
                href="#testimoni"
                @click="toggleMobileMenu"
                class="mobile-nav-link text-white text-base font-semibold py-4 px-0 border-b border-white/10 uppercase transition-all duration-300 hover:text-primary"
                >Testimonials</a
              >
            </li>
            <li class="mb-2">
              <a
                href="#kontak"
                @click="toggleMobileMenu"
                class="mobile-nav-link text-white text-base font-semibold py-4 px-0 border-b border-white/10 uppercase transition-all duration-300 hover:text-primary"
                >Contact</a
              >
            </li>
          </ul>

          <div class="mobile-menu-footer mt-10 pt-5 border-t border-white/10">
            <div class="flex flex-col gap-3">
              <router-link
                to="/login"
                class="login-button bg-white text-primary font-semibold text-sm uppercase px-5 py-3 border-2 border-primary rounded-md flex items-center gap-2 transition-all duration-300 hover:bg-cream hover:shadow-lg"
              >
                <span class="login-text">Admin Login</span>
                <i-lucide:user class="login-icon w-5 h-5" />
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

const isMobileMenuOpen = ref(false)
const activeSubmenu = ref<string | null>(null)
const isScrolled = ref(false)
const activeSection = ref('home')

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

const handleScroll = () => {
  isScrolled.value = window.scrollY > 100
  const sections = ['home', 'visi-misi', 'produk', 'riwayat', 'testimoni', 'kontak']
  const scrollPosition = window.scrollY + 200

  for (const section of sections) {
    const element = document.getElementById(section)
    if (element) {
      const offsetTop = element.offsetTop
      const offsetHeight = element.offsetHeight

      if (scrollPosition >= offsetTop && scrollPosition < offsetTop + offsetHeight) {
        activeSection.value = section
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
