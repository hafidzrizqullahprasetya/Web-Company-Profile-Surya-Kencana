<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div
        class="bg-gradient-to-br from-primary to-primary/90 rounded-2xl p-6 text-white shadow-lg transform transition hover:scale-105"
      >
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm opacity-80 mb-1">Total Produk</p>
            <p class="text-3xl font-bold">{{ stats.products }}</p>
          </div>
          <div class="bg-white/20 p-3 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
              ></path>
            </svg>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/20">
          <div class="flex items-center text-xs">
            <span class="mr-2 text-white/80">+12%</span>
            <span class="text-white/80">bulan ini</span>
          </div>
        </div>
      </div>

      <div
        class="bg-gradient-to-br from-primary to-primary/90 rounded-2xl p-6 text-white shadow-lg transform transition hover:scale-105"
      >
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm opacity-80 mb-1">Total Klien</p>
            <p class="text-3xl font-bold">{{ stats.clients }}</p>
          </div>
          <div class="bg-white/20 p-3 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
              ></path>
            </svg>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/20">
          <div class="flex items-center text-xs">
            <span class="mr-2">+8%</span>
            <span>bulan ini</span>
          </div>
        </div>
      </div>

      <div
        class="bg-gradient-to-br from-primary to-primary/90 rounded-2xl p-6 text-white shadow-lg transform transition hover:scale-105"
      >
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm opacity-80 mb-1">Total Testimoni</p>
            <p class="text-3xl font-bold">{{ stats.testimonials }}</p>
          </div>
          <div class="bg-white/20 p-3 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
              ></path>
            </svg>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/20">
          <div class="flex items-center text-xs">
            <span class="mr-2">+5%</span>
            <span>bulan ini</span>
          </div>
        </div>
      </div>

      <div
        class="bg-gradient-to-br from-primary to-primary/90 rounded-2xl p-6 text-white shadow-lg transform transition hover:scale-105"
      >
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm opacity-80 mb-1">Total Admin</p>
            <p class="text-3xl font-bold">{{ stats.admins }}</p>
          </div>
          <div class="bg-white/20 p-3 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
              ></path>
            </svg>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/20">
          <div class="flex items-center text-xs">
            <span class="mr-2">+2%</span>
            <span>bulan ini</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
      <!-- Recent Products -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Produk Terbaru</h3>
            <router-link
              :to="{ name: 'admin-product' }"
              class="text-primary hover:text-primary/80 text-sm font-medium"
            >
              Lihat Semua
            </router-link>
          </div>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div
              v-for="product in recentProducts"
              :key="product.id"
              class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition"
            >
              <div
                class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mr-4"
              >
                <svg
                  class="w-6 h-6 text-primary"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                  />
                </svg>
              </div>
              <div class="flex-1 min-w-0">
                <p class="font-medium text-gray-900 truncate">{{ product.name }}</p>
                <p class="text-sm text-gray-500 truncate">
                  {{ truncate(product.description, 30) }}
                </p>
              </div>
              <div class="text-right">
                <p class="font-bold text-gray-900">Rp {{ formatCurrency(product.price) }}</p>
              </div>
            </div>
            <div v-if="recentProducts.length === 0" class="text-center py-8 text-gray-500">
              <svg
                class="mx-auto h-12 w-12 text-gray-400 mb-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                />
              </svg>
              <p>Tidak ada produk terbaru</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Testimonials -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Testimoni Terbaru</h3>
            <router-link
              :to="{ name: 'admin-testimonial' }"
              class="text-primary hover:text-primary/80 text-sm font-medium"
            >
              Lihat Semua
            </router-link>
          </div>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div
              v-for="testimonial in recentTestimonials"
              :key="testimonial.id"
              class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition"
            >
              <div class="flex items-start">
                <div
                  class="flex-shrink-0 w-10 h-10 rounded-full bg-cream flex items-center justify-center text-primary font-bold mr-4"
                >
                  {{ testimonial.client_name.charAt(0).toUpperCase() }}
                </div>
                <div class="flex-1">
                  <p class="text-gray-700 italic mb-2">
                    "{{ truncate(testimonial.feedback, 60) }}"
                  </p>
                  <div class="flex items-center justify-between text-sm">
                    <div>
                      <p class="font-medium text-gray-900">{{ testimonial.client_name }}</p>
                      <p class="text-gray-500">{{ testimonial.institution }}</p>
                    </div>
                    <p class="text-gray-500">{{ formatDate(testimonial.date) }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="recentTestimonials.length === 0" class="text-center py-8 text-gray-500">
              <svg
                class="mx-auto h-12 w-12 text-gray-400 mb-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                />
              </svg>
              <p>Tidak ada testimoni terbaru</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
      <h3 class="text-xl font-bold text-gray-900 mb-6">Akses Cepat</h3>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <button
          @click="$router.push({ name: 'admin-product' })"
          class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md"
        >
          <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
              />
            </svg>
          </div>
          <span class="text-sm font-medium">Produk</span>
        </button>

        <button
          @click="$router.push({ name: 'admin-client' })"
          class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md"
        >
          <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
              />
            </svg>
          </div>
          <span class="text-sm font-medium">Klien</span>
        </button>

        <button
          @click="$router.push({ name: 'admin-testimonial' })"
          class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md"
        >
          <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
              />
            </svg>
          </div>
          <span class="text-sm font-medium">Testimoni</span>
        </button>

        <button
          @click="$router.push({ name: 'admin-vision-mission' })"
          class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md"
        >
          <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              />
            </svg>
          </div>
          <span class="text-sm font-medium">Visi & Misi</span>
        </button>

        <button
          @click="$router.push({ name: 'admin-kontak' })"
          class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md"
        >
          <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
              />
            </svg>
          </div>
          <span class="text-sm font-medium">Kontak</span>
        </button>

        <button
          @click="$router.push({ name: 'admin-hero' })"
          class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md"
        >
          <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
              />
            </svg>
          </div>
          <span class="text-sm font-medium">Hero</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import type { Product, Testimonial } from '@/services/api'

// Stats data
const stats = ref({
  products: 0,
  clients: 0,
  testimonials: 0,
  admins: 0,
})

// Recent items
const recentProducts = ref<Product[]>([])
const recentTestimonials = ref<Testimonial[]>([])

// Helper functions
const truncate = (str: string, length: number) => {
  if (!str) return ''
  return str.length > length ? str.substring(0, length) + '...' : str
}

const formatCurrency = (value: number) => {
  return new Intl.NumberFormat('id-ID').format(value)
}

const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
  })
}

// Load dashboard data
const loadDashboardData = async () => {
  try {
    // Load products
    try {
      const products = await api.getProducts()
      console.log('Dashboard: products', products)
      stats.value.products = products.length
      recentProducts.value = products.slice(0, 5)
    } catch (error) {
      console.error('Error loading products:', error)
      stats.value.products = 0
      recentProducts.value = []
    }

    // Load clients
    try {
      const clients = await api.getClients()
      console.log('Dashboard: clients', clients)
      stats.value.clients = clients.length
    } catch (error) {
      console.error('Error loading clients:', error)
      stats.value.clients = 0
    }

    // Load testimonials
    try {
      const testimonials = await api.getTestimonials()
      console.log('Dashboard: testimonials', testimonials)
      stats.value.testimonials = testimonials.length
      recentTestimonials.value = testimonials.slice(0, 5)
    } catch (error) {
      console.error('Error loading testimonials:', error)
      stats.value.testimonials = 0
      recentTestimonials.value = []
    }

    // Load admins
    try {
      const admins = await api.getAdmins()
      console.log('Dashboard: admins', admins)
      stats.value.admins = admins.length
    } catch (error) {
      console.error('Error loading admins:', error)
      stats.value.admins = 0
    }
  } catch (error) {
    console.error('General error loading dashboard data:', error)
  }
}

onMounted(() => {
  loadDashboardData()
})
</script>
