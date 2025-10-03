<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <footer class="wpo-site-footer bg-gray-900">
    <div class="wpo-upper-footer py-20">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- About Widget -->
          <div class="widget about-widget">
            <div class="logo mb-6">
              <router-link to="/">
                <img src="https://placehold.co/150x50/E5F346/1C1817?text=SUQAT" alt="Suqat Logo" class="max-w-[150px]">
              </router-link>
            </div>
            <p class="text-gray-400 text-sm leading-relaxed mb-6">
              Your trusted partner in finding the perfect property. We provide quality real estate solutions with integrity and excellence.
            </p>
            <ul class="social-links flex space-x-3">
              <li>
                <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-yellow-400 text-white hover:text-gray-900 rounded-full flex items-center justify-center transition-all duration-300">
                  <i class="ti-facebook"></i>
                </a>
              </li>
              <li>
                <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-yellow-400 text-white hover:text-gray-900 rounded-full flex items-center justify-center transition-all duration-300">
                  <i class="ti-twitter-alt"></i>
                </a>
              </li>
              <li>
                <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-yellow-400 text-white hover:text-gray-900 rounded-full flex items-center justify-center transition-all duration-300">
                  <i class="ti-instagram"></i>
                </a>
              </li>
              <li>
                <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-yellow-400 text-white hover:text-gray-900 rounded-full flex items-center justify-center transition-all duration-300">
                  <i class="ti-linkedin"></i>
                </a>
              </li>
            </ul>
          </div>

          <!-- Quick Links -->
          <div class="widget link-widget">
            <h3 class="text-white text-xl font-semibold mb-6 uppercase">Quick Links</h3>
            <ul class="space-y-3">
              <li>
                <router-link to="/" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  Home
                </router-link>
              </li>
              <li>
                <a href="#visi-misi" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  About Us
                </a>
              </li>
              <li>
                <a href="#produk" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  Products
                </a>
              </li>
              <li>
                <a href="#testimoni" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  Testimonials
                </a>
              </li>
              <li>
                <a href="#kontak" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  Contact
                </a>
              </li>
            </ul>
          </div>

          <!-- Services -->
          <div class="widget link-widget">
            <h3 class="text-white text-xl font-semibold mb-6 uppercase">Our Services</h3>
            <ul class="space-y-3">
              <li>
                <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  Property Sales
                </a>
              </li>
              <li>
                <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  Property Rental
                </a>
              </li>
              <li>
                <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  Property Management
                </a>
              </li>
              <li>
                <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  Investment Consulting
                </a>
              </li>
              <li>
                <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors duration-300 flex items-center">
                  <i class="fi flaticon-next text-xs mr-2"></i>
                  Legal Assistance
                </a>
              </li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div class="widget contact-widget">
            <h3 class="text-white text-xl font-semibold mb-6 uppercase">Contact Info</h3>
            <ul class="space-y-4">
              <li class="flex items-start">
                <i class="fi flaticon-placeholder text-yellow-400 text-xl mr-3 mt-1"></i>
                <div>
                  <span class="text-gray-400 text-sm">
                    Jl. Sudirman No. 123,<br>
                    Jakarta Pusat, DKI Jakarta 10220
                  </span>
                </div>
              </li>
              <li class="flex items-start">
                <i class="fi flaticon-phone-call text-yellow-400 text-xl mr-3 mt-1"></i>
                <div>
                  <a href="tel:+622112345678" class="text-gray-400 text-sm hover:text-yellow-400 transition-colors">
                    +62 21 1234 5678
                  </a>
                </div>
              </li>
              <li class="flex items-start">
                <i class="fi flaticon-email text-yellow-400 text-xl mr-3 mt-1"></i>
                <div>
                  <a href="mailto:info@suqatestate.com" class="text-gray-400 text-sm hover:text-yellow-400 transition-colors">
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
    <div class="wpo-lower-footer py-6 border-t border-gray-800">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="copyright text-gray-400 text-sm mb-3 md:mb-0">
            <p>&copy; {{ currentYear }} Suqat Real Estate. All rights reserved.</p>
          </div>
          <div class="footer-menu">
            <ul class="flex space-x-6">
              <li>
                <a href="#" class="text-gray-400 hover:text-yellow-400 text-sm transition-colors duration-300">
                  Privacy Policy
                </a>
              </li>
              <li>
                <a href="#" class="text-gray-400 hover:text-yellow-400 text-sm transition-colors duration-300">
                  Terms & Conditions
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Scroll to Top Button -->
    <div class="scroll-to-top">
      <button
        @click="scrollToTop"
        :class="{ 'show': showScrollTop }"
        class="fixed bottom-8 right-8 w-12 h-12 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 opacity-0 invisible z-50"
      >
        <i class="ti-arrow-up text-xl"></i>
      </button>
    </div>
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
    behavior: 'smooth'
  })
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.wpo-site-footer {
  position: relative;
}

.social-links a {
  font-size: 14px;
}

.widget h3 {
  position: relative;
  padding-bottom: 15px;
}

.widget h3::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 50px;
  height: 2px;
  background: #E5F346;
}

.scroll-to-top button.show {
  opacity: 1;
  visibility: visible;
}

.scroll-to-top button:hover {
  transform: translateY(-3px);
}

/* Responsive */
@media (max-width: 767px) {
  .footer-menu ul {
    flex-direction: column;
    gap: 0.75rem;
    text-align: center;
  }

  .social-links {
    justify-content: center;
  }
}
</style>
