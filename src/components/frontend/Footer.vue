<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <footer class="bg-primary">
    <div class="py-20">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- About Widget -->
          <div>
            <div class="mb-6">
              <router-link to="/">
                <img
                  src="https://placehold.co/150x50/F5F6E4/1C1817?text=SURYA+KENCANA"
                  alt="Surya Kencana Logo"
                  class="max-w-[150px]"
                />
              </router-link>
            </div>
            <p class="text-white/80 text-sm leading-relaxed mb-6">
              Your trusted partner in finding the perfect property. We provide quality real estate
              solutions with integrity and excellence.
            </p>
            <ul class="flex space-x-3">
              <li>
                <a
                  href="#"
                  class="w-10 h-10 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300"
                >
                  <i-lucide:facebook class="w-4 h-4" />
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="w-10 h-10 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300"
                >
                  <i-lucide:twitter class="w-4 h-4" />
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="w-10 h-10 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300"
                >
                  <i-lucide:instagram class="w-4 h-4" />
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="w-10 h-10 bg-secondary/20 hover:bg-cream text-white hover:text-secondary rounded-full flex items-center justify-center transition-all duration-300"
                >
                  <i-lucide:linkedin class="w-4 h-4" />
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
                <router-link
                  to="/"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  Home
                </router-link>
              </li>
              <li>
                <a
                  href="#visi-misi"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  About Us
                </a>
              </li>
              <li>
                <a
                  href="#produk"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  Products
                </a>
              </li>
              <li>
                <a
                  href="#testimoni"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  Testimonials
                </a>
              </li>
              <li>
                <a
                  href="#kontak"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  Contact
                </a>
              </li>
            </ul>
          </div>

          <!-- Services -->
          <div>
            <h3 class="text-white text-xl font-semibold mb-6 uppercase relative">
              Our Services
              <div class="absolute -bottom-1 left-0 w-12 h-0.5 bg-cream"></div>
            </h3>
            <ul class="space-y-3">
              <li>
                <a
                  href="#"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  Property Sales
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  Property Rental
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  Property Management
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  Investment Consulting
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="text-white/80 hover:text-cream transition-colors duration-300 flex items-center"
                >
                  <i-lucide:arrow-right class="w-3 h-3 mr-2" />
                  Legal Assistance
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
            <ul class="space-y-4">
              <li class="flex items-start">
                <i-lucide:map-pin class="text-cream w-5 h-5 mr-3 mt-1 flex-shrink-0" />
                <div>
                  <span class="text-white/80 text-sm">
                    Jl. Sudirman No. 123,<br />
                    Jakarta Pusat, DKI Jakarta 10220
                  </span>
                </div>
              </li>
              <li class="flex items-start">
                <i-lucide:phone class="text-cream w-5 h-5 mr-3 mt-1 flex-shrink-0" />
                <div>
                  <a
                    href="tel:+622112345678"
                    class="text-white/80 text-sm hover:text-cream transition-colors"
                  >
                    +62 21 1234 5678
                  </a>
                </div>
              </li>
              <li class="flex items-start">
                <i-lucide:mail class="text-cream w-5 h-5 mr-3 mt-1 flex-shrink-0" />
                <div>
                  <a
                    href="mailto:info@suqatestate.com"
                    class="text-white/80 text-sm hover:text-cream transition-colors"
                  >
                    info@suqatestate.com
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Lower Footer -->
    <div class="py-6 border-t border-secondary/20">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="text-white/80 text-sm mb-3 md:mb-0">
            <p>&copy; {{ currentYear }} Surya Kencana. All rights reserved.</p>
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
      <i-lucide:arrow-up class="w-5 h-5" />
    </button>
  </footer>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue'

const showScrollTop = ref(false)
const currentYear = computed(() => new Date().getFullYear())

const handleScroll = () => {
  showScrollTop.value = window.scrollY > 300
}

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth',
  })
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>
