<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
      <div class="flex items-center">
        <div class="p-3 rounded-lg bg-primary/10 text-primary mr-4">
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
            ></path>
          </svg>
        </div>
        <div>
          <p class="text-sm font-medium text-gray-600">Total Products</p>
          <p class="text-2xl font-bold text-gray-900">{{ stats.products }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
      <div class="flex items-center">
        <div class="p-3 rounded-lg bg-secondary text-white mr-4">
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
            ></path>
          </svg>
        </div>
        <div>
          <p class="text-sm font-medium text-gray-600">Total Clients</p>
          <p class="text-2xl font-bold text-gray-900">{{ stats.clients }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
      <div class="flex items-center">
        <div class="p-3 rounded-lg bg-cream text-primary mr-4">
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
            ></path>
          </svg>
        </div>
        <div>
          <p class="text-sm font-medium text-gray-600">Total Testimonials</p>
          <p class="text-2xl font-bold text-gray-900">{{ stats.testimonials }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
      <div class="flex items-center">
        <div class="p-3 rounded-lg bg-secondary text-white mr-4">
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
            ></path>
          </svg>
        </div>
        <div>
          <p class="text-sm font-medium text-gray-600">Total Admins</p>
          <p class="text-2xl font-bold text-gray-900">{{ stats.admins }}</p>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Products</h3>
      <div class="space-y-4">
        <div
          v-for="product in recentProducts"
          :key="product.id"
          class="flex items-center justify-between p-4 border-b border-gray-100 last:border-0"
        >
          <div>
            <p class="font-medium text-gray-900">{{ product.name }}</p>
            <p class="text-sm text-gray-500">{{ truncate(product.description, 50) }}</p>
          </div>
          <div class="text-right">
            <p class="font-medium text-gray-900">Rp {{ formatCurrency(product.price) }}</p>
            <p class="text-xs text-gray-500">ID: {{ product.id }}</p>
          </div>
        </div>
        <div v-if="recentProducts.length === 0" class="text-center py-4 text-gray-500">
          No recent products
        </div>
      </div>
      <router-link
        :to="{ name: 'admin-product' }"
        class="mt-4 inline-flex items-center text-primary hover:text-primary/70 text-sm font-medium"
      >
        View all products
        <svg
          class="w-4 h-4 ml-1"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5l7 7-7 7"
          ></path>
        </svg>
      </router-link>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Testimonials</h3>
      <div class="space-y-4">
        <div
          v-for="testimonial in recentTestimonials"
          :key="testimonial.id"
          class="p-4 border-b border-gray-100 last:border-0"
        >
          <p class="text-gray-700 mb-2">{{ truncate(testimonial.feedback, 60) }}</p>
          <p class="text-sm font-medium text-gray-900">- {{ testimonial.client_name }}</p>
          <p class="text-xs text-gray-500">{{ formatDate(testimonial.date) }}</p>
        </div>
        <div v-if="recentTestimonials.length === 0" class="text-center py-4 text-gray-500">
          No recent testimonials
        </div>
      </div>
      <router-link
        :to="{ name: 'admin-testimonial' }"
        class="mt-4 inline-flex items-center text-primary hover:text-primary/70 text-sm font-medium"
      >
        View all testimonials
        <svg
          class="w-4 h-4 ml-1"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5l7 7-7 7"
          ></path>
        </svg>
      </router-link>
    </div>
  </div>

  <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <button
        @click="$router.push({ name: 'admin-product' })"
        class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
      >
        <svg
          class="w-8 h-8 text-primary mb-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
          ></path>
        </svg>
        <span class="text-sm font-medium">Products</span>
      </button>
      <button
        @click="$router.push({ name: 'admin-client' })"
        class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
      >
        <svg
          class="w-8 h-8 text-primary mb-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
          ></path>
        </svg>
        <span class="text-sm font-medium">Clients</span>
      </button>
      <button
        @click="$router.push({ name: 'admin-testimonial' })"
        class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
      >
        <svg
          class="w-8 h-8 text-primary mb-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
          ></path>
        </svg>
        <span class="text-sm font-medium">Testimonials</span>
      </button>
      <button
        @click="$router.push({ name: 'admin-vision-mission' })"
        class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
      >
        <svg
          class="w-8 h-8 text-primary mb-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
          ></path>
        </svg>
        <span class="text-sm font-medium">Vision & Mission</span>
      </button>
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
