<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <header
    id="header"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300"
    :class="{ 'header-scrolled': isScrolled }"
  >
    <div class="header-inner">
      <nav class="navigation">
        <div class="container mx-auto px-4">
          <div class="flex items-center justify-between h-20">
            <div class="logo-area">
              <router-link to="/" class="navbar-brand">
                <img
                  src="https://placehold.co/150x50/FFFFFF/1C1817?text=SURYA KENCANA&font=raleway"
                  alt="SURYA KENCANA Logo"
                  class="h-12"
                />
              </router-link>
            </div>

            <div class="hidden lg:flex items-center justify-center flex-1">
              <ul class="flex items-center gap-10">
                <li>
                  <a
                    href="#"
                    class="nav-link"
                    :class="{ 'nav-link-active': activeSection === 'home' }"
                    @click="setActiveSection('home')"
                  >
                    Home
                  </a>
                </li>

                <li>
                  <a
                    href="#visi-misi"
                    class="nav-link"
                    :class="{ 'nav-link-active': activeSection === 'visi-misi' }"
                    @click="setActiveSection('visi-misi')"
                  >
                    About Us
                  </a>
                </li>

                <li>
                  <a
                    href="#produk"
                    class="nav-link"
                    :class="{ 'nav-link-active': activeSection === 'produk' }"
                    @click="setActiveSection('produk')"
                  >
                    Products
                  </a>
                </li>

                <li>
                  <a
                    href="#riwayat"
                    class="nav-link"
                    :class="{ 'nav-link-active': activeSection === 'riwayat' }"
                    @click="setActiveSection('riwayat')"
                  >
                    Gallery
                  </a>
                </li>

                <li>
                  <a
                    href="#testimoni"
                    class="nav-link"
                    :class="{ 'nav-link-active': activeSection === 'testimoni' }"
                    @click="setActiveSection('testimoni')"
                  >
                    Testimonials
                  </a>
                </li>

                <li>
                  <a
                    href="#kontak"
                    class="nav-link"
                    :class="{ 'nav-link-active': activeSection === 'kontak' }"
                    @click="setActiveSection('kontak')"
                  >
                    Contact
                  </a>
                </li>
              </ul>
            </div>

            <div class="hidden lg:block">
              <router-link to="/contact" class="cta-button">
                <span class="cta-text">Hubungi Kami</span>
                <i class="ti-arrow-top-right cta-icon"></i>
              </router-link>
            </div>

            <div class="lg:hidden">
              <button @click="toggleMobileMenu" type="button" class="mobile-menu-btn">
                <span class="sr-only">Toggle navigation</span>
                <div class="hamburger-lines">
                  <span
                    class="line"
                    :class="{ 'rotate-45 translate-y-2': isMobileMenuOpen }"
                  ></span>
                  <span class="line" :class="{ 'opacity-0': isMobileMenuOpen }"></span>
                  <span
                    class="line"
                    :class="{ '-rotate-45 -translate-y-2': isMobileMenuOpen }"
                  ></span>
                </div>
              </button>
            </div>
          </div>
        </div>
      </nav>

      <div class="mobile-menu lg:hidden" :class="{ 'mobile-menu-open': isMobileMenuOpen }">
        <div class="mobile-menu-overlay" @click="toggleMobileMenu"></div>
        <div class="mobile-menu-content">
          <div class="mobile-menu-header">
            <img
              src="https://placehold.co/120x40/FFFFFF/1C1817?text=SURYA KENCANA&font=raleway"
              alt="SURYA KENCANA Logo"
              class="h-10"
            />
            <button @click="toggleMobileMenu" class="mobile-close-btn">
              <i class="ti-close"></i>
            </button>
          </div>

          <ul class="mobile-menu-list">
            <li>
              <a href="#" @click="toggleMobileMenu" class="mobile-nav-link">Home</a>
            </li>
            <li>
              <a href="#visi-misi" @click="toggleMobileMenu" class="mobile-nav-link">About Us</a>
            </li>
            <li>
              <a href="#produk" @click="toggleMobileMenu" class="mobile-nav-link">Products</a>
            </li>
            <li>
              <a href="#riwayat" @click="toggleMobileMenu" class="mobile-nav-link">Gallery</a>
            </li>
            <li>
              <a href="#testimoni" @click="toggleMobileMenu" class="mobile-nav-link"
                >Testimonials</a
              >
            </li>
            <li>
              <a href="#kontak" @click="toggleMobileMenu" class="mobile-nav-link">Contact</a>
            </li>
          </ul>

          <div class="mobile-menu-footer">
            <router-link to="#" @click="toggleMobileMenu" class="btn-primary">
              Hubungi Kami
            </router-link>
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

<style scoped>
#header {
  background: rgb(var(--secondary));
  height: 80px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

#header.header-scrolled {
  background: rgb(var(--secondary));
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  height: 80px;
}

.header-inner {
  position: relative;
  height: 100%;
}

/* Logo */
.navbar-brand img {
  max-width: 150px;
  height: auto;
  transition: all 0.3s ease;
}

/* Navigation Links */
.nav-link {
  color: rgb(var(--text-white));
  font-size: 14px;
  font-weight: 500;
  text-transform: uppercase;
  padding: 12px 0;
  display: flex;
  align-items: center;
  transition: all 0.3s ease;
  position: relative;
  letter-spacing: 0.5px;
}

.nav-link:hover {
  color: rgb(var(--primary));
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: -1px;
  left: 0;
  width: 0;
  height: 2px;
  background: rgb(var(--primary));
  transition: width 0.3s ease;
}

.nav-link:hover::after,
.nav-link-active::after {
  width: 100%;
}

.nav-link-active {
  color: rgb(var(--primary));
}

/* CTA Button */
.cta-button {
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  padding: 12px 24px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  gap: 10px;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  letter-spacing: 0.5px;
}

.cta-button::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.2);
  transition: left 0.3s ease;
}

.cta-button:hover::before {
  left: 100%;
}

.cta-button:hover {
  background: rgb(var(--primary-dark));
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(229, 243, 70, 0.3);
}

.cta-icon {
  width: 22px;
  height: 22px;
  background: rgb(var(--secondary));
  color: rgb(var(--text-white));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  position: relative;
  z-index: 2;
}

/* Mobile Menu Button */
.mobile-menu-btn {
  color: rgb(var(--text-white));
  padding: 8px;
  transition: all 0.3s ease;
}

.hamburger-lines {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.line {
  width: 24px;
  height: 2px;
  background: rgb(var(--text-white));
  transition: all 0.3s ease;
}

/* Mobile Menu */
.mobile-menu {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  z-index: 9999;
  visibility: hidden;
  opacity: 0;
  transition: all 0.3s ease;
}

.mobile-menu-open {
  visibility: visible;
  opacity: 1;
}

.mobile-menu-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
}

.mobile-menu-content {
  position: absolute;
  top: 0;
  right: 0;
  width: 320px;
  height: 100%;
  background: rgb(var(--bg-dark));
  padding: 30px;
  overflow-y: auto;
  transform: translateX(100%);
  transition: transform 0.3s ease;
}

.mobile-menu-open .mobile-menu-content {
  transform: translateX(0);
}

.mobile-menu-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
  padding-bottom: 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.mobile-close-btn {
  color: rgb(var(--text-white));
  font-size: 24px;
  padding: 8px;
  transition: all 0.3s ease;
}

.mobile-close-btn:hover {
  color: rgb(var(--primary));
}

.mobile-menu-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.mobile-menu-list > li {
  margin-bottom: 5px;
}

.mobile-nav-link {
  color: rgb(var(--text-white));
  font-size: 16px;
  font-weight: 500;
  padding: 15px 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.mobile-nav-link:hover {
  color: rgb(var(--primary));
  padding-left: 10px;
}

.mobile-menu-footer {
  margin-top: 40px;
  padding-top: 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.btn-primary {
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  padding: 15px 25px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  text-align: center;
  display: block;
  width: 100%;
  transition: all 0.3s ease;
  letter-spacing: 0.5px;
}

.btn-primary:hover {
  background: rgb(var(--primary-dark));
  transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 575px) {
  .mobile-menu-content {
    width: 100%;
  }

  .navbar-brand img {
    max-width: 120px;
  }
}
</style>
