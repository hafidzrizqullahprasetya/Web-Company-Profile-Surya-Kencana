<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="pt-24 sm:pt-28">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Skeleton for Stats Cards -->
      <template v-if="isLoading">
        <SkeletonLoader type="stats" :items="4" :grid-cols="4" />
      </template>

      <!-- Actual Stats Cards -->
      <template v-else>
        <div
          class="bg-gradient-to-br from-primary to-primary/90 rounded-2xl p-6 text-white shadow-lg transform transition hover:scale-105"
        >
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm opacity-80 mb-1">Total Produk</p>
              <p class="text-3xl font-bold">{{ stats.products }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
              <i class="fa-solid fa-box w-8 h-8"></i>
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
              <i class="fa-solid fa-users w-8 h-8"></i>
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
              <i class="fa-solid fa-comments w-8 h-8"></i>
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
              <i class="fa-solid fa-user-tie w-8 h-8"></i>
            </div>
          </div>
          <div class="mt-4 pt-4 border-t border-white/20">
            <div class="flex items-center text-xs">
              <span class="mr-2">+2%</span>
              <span>bulan ini</span>
            </div>
          </div>
        </div>
      </template>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
      <!-- Skeleton for Recent Activity -->
      <template v-if="isLoading">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
          <SkeletonLoader type="list" :rows="5" />
        </div>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
          <SkeletonLoader type="list" :rows="5" />
        </div>
      </template>

      <!-- Actual Recent Activity -->
      <template v-else>
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
                  <i class="fa-solid fa-box w-6 h-6 text-primary"></i>
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
                <i class="fa-solid fa-box mx-auto h-12 w-12 text-gray-400 mb-2 text-2xl"></i>
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
                <i class="fa-solid fa-comment mx-auto h-12 w-12 text-gray-400 mb-2 text-2xl"></i>
                <p>Tidak ada testimoni terbaru</p>
              </div>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
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

// Loading state to control UI
const isLoading = ref(true)

// Load dashboard data in parallel with timeout handling
const loadDashboardData = async () => {
  isLoading.value = true

  // Load all data in parallel with Promise.allSettled
  // This way if one fails/timeouts, others still load
  const results = await Promise.allSettled([
    api.getProducts(),
    api.getClients(),
    api.getTestimonials(),
    api.getAdmins(),
  ])

  // Handle products
  if (results[0].status === 'fulfilled') {
    const products = results[0].value
    stats.value.products = products.length
    recentProducts.value = products.slice(0, 5)
  } else {
    console.error('Error loading products:', results[0].reason)
    stats.value.products = 0
    recentProducts.value = []
  }

  // Handle clients
  if (results[1].status === 'fulfilled') {
    const clients = results[1].value
    stats.value.clients = clients.length
  } else {
    console.error('Error loading clients:', results[1].reason)
    stats.value.clients = 0
  }

  // Handle testimonials
  if (results[2].status === 'fulfilled') {
    const testimonials = results[2].value
    stats.value.testimonials = testimonials.length
    recentTestimonials.value = testimonials.slice(0, 5)
  } else {
    console.error('Error loading testimonials:', results[2].reason)
    stats.value.testimonials = 0
    recentTestimonials.value = []
  }

  // Handle admins
  if (results[3].status === 'fulfilled') {
    const admins = results[3].value
    stats.value.admins = admins.length
  } else {
    console.error('Error loading admins:', results[3].reason)
    stats.value.admins = 0
  }

  isLoading.value = false
}

onMounted(() => {
  loadDashboardData()
})
</script>
