<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="pt-5 sm:pt-24 md:pt-5 px-4 sm:px-6 lg:px-2">
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
            <!-- Skeleton for Stats Cards -->
            <template v-if="isLoading">
                <SkeletonLoader type="stats" :items="4" :grid-cols="4" />
            </template>

            <!-- Actual Stats Cards -->
            <template v-else>
                <div
                    class="bg-primary rounded-lg sm:rounded-2xl p-3 sm:p-5 text-white shadow-lg transform transition hover:scale-105 flex flex-col">
                    <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm opacity-80 truncate">Total Produk</p>
                            <p class="text-2xl sm:text-4xl font-bold leading-none">{{ stats.products }}</p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 rounded-lg flex-shrink-0">
                            <i class="fa-solid fa-box text-base sm:text-lg"></i>
                        </div>
                    </div>
                    <div class="pt-2 sm:pt-3 border-t border-white/20 mt-auto">
                        <div class="flex items-center text-xs gap-1">
                            <span class="text-white/80 font-medium">+12%</span>
                            <span class="text-white/70">bulan ini</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-primary rounded-lg sm:rounded-2xl p-3 sm:p-5 text-white shadow-lg transform transition hover:scale-105 flex flex-col">
                    <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm opacity-80 truncate">Total Klien</p>
                            <p class="text-2xl sm:text-4xl font-bold leading-none">{{ stats.clients }}</p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 rounded-lg flex-shrink-0">
                            <i class="fa-solid fa-users text-base sm:text-lg"></i>
                        </div>
                    </div>
                    <div class="pt-2 sm:pt-3 border-t border-white/20 mt-auto">
                        <div class="flex items-center text-xs gap-1">
                            <span class="text-white/80 font-medium">+8%</span>
                            <span class="text-white/70">bulan ini</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-primary rounded-lg sm:rounded-2xl p-3 sm:p-5 text-white shadow-lg transform transition hover:scale-105 flex flex-col">
                    <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm opacity-80 truncate">Total Testimoni</p>
                            <p class="text-2xl sm:text-4xl font-bold leading-none">{{ stats.testimonials }}</p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 rounded-lg flex-shrink-0">
                            <i class="fa-solid fa-comments text-base sm:text-lg"></i>
                        </div>
                    </div>
                    <div class="pt-2 sm:pt-3 border-t border-white/20 mt-auto">
                        <div class="flex items-center text-xs gap-1">
                            <span class="text-white/80 font-medium">+5%</span>
                            <span class="text-white/70">bulan ini</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-primary rounded-lg sm:rounded-2xl p-3 sm:p-5 text-white shadow-lg transform transition hover:scale-105 flex flex-col">
                    <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm opacity-80 truncate">Total Admin</p>
                            <p class="text-2xl sm:text-4xl font-bold leading-none">{{ stats.admins }}</p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 rounded-lg flex-shrink-0">
                            <i class="fa-solid fa-user-tie text-base sm:text-lg"></i>
                        </div>
                    </div>
                    <div class="pt-2 sm:pt-3 border-t border-white/20 mt-auto">
                        <div class="flex items-center text-xs gap-1">
                            <span class="text-white/80 font-medium">+2%</span>
                            <span class="text-white/70">bulan ini</span>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Skeleton for Recent Activity -->
            <template v-if="isLoading">
                <div class="bg-white rounded-lg sm:rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6">
                    <SkeletonLoader type="list" :rows="4" />
                </div>
                <div class="bg-white rounded-lg sm:rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6">
                    <SkeletonLoader type="list" :rows="4" />
                </div>
            </template>

            <!-- Actual Recent Activity -->
            <template v-else>
                <!-- Recent Products -->
                <div
                    class="bg-white rounded-lg sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden flex flex-col">
                    <div class="p-4 sm:p-6 border-b border-gray-100 flex-shrink-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Produk Terbaru</h3>
                            <router-link :to="{ name: 'admin-product' }"
                                class="px-3 py-1.5 bg-primary text-white rounded-lg text-xs font-medium hover:bg-primary/90 transition-all">
                                Lihat Semua
                            </router-link>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6 flex-1 overflow-y-auto">
                        <div class="space-y-3">
                            <div v-for="product in recentProducts" :key="product.id"
                                class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition gap-3">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-box text-sm text-primary"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ product.name }}</p>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ truncate(product.description || '', 25) }}
                                    </p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-xs sm:text-sm font-semibold text-gray-900 whitespace-nowrap">Rp {{
                                        formatCurrency(product.price) }}</p>
                                </div>
                            </div>
                            <div v-if="recentProducts.length === 0" class="text-center py-8 text-gray-500">
                                <i class="fa-solid fa-box mx-auto h-8 w-8 text-gray-400 mb-2"></i>
                                <p class="text-sm">Tidak ada produk terbaru</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Testimonials -->
                <div
                    class="bg-white rounded-lg sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden flex flex-col">
                    <div class="p-4 sm:p-6 border-b border-gray-100 flex-shrink-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Testimoni Terbaru</h3>
                            <router-link :to="{ name: 'admin-testimonial' }"
                                class="px-3 py-1.5 bg-primary text-white rounded-lg text-xs font-medium hover:bg-primary/90 transition-all">
                                Lihat Semua
                            </router-link>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6 flex-1 overflow-y-auto">
                        <div class="space-y-3">
                            <div v-for="testimonial in recentTestimonials" :key="testimonial.id"
                                class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-cream flex items-center justify-center text-primary text-xs font-bold">
                                        {{ testimonial.client_name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-700 italic mb-2 line-clamp-2">
                                            "{{ truncate(testimonial.feedback, 50) }}"
                                        </p>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-xs font-medium text-gray-900 truncate">{{
                                                testimonial.client_name }}</p>
                                            <div class="flex items-center justify-between gap-2">
                                                <p class="text-xs text-gray-500 truncate">{{ testimonial.institution }}
                                                </p>
                                                <p class="text-xs text-gray-500 whitespace-nowrap">{{
                                                    formatDate(testimonial.date) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="recentTestimonials.length === 0" class="text-center py-8 text-gray-500">
                                <i class="fa-solid fa-comment mx-auto h-8 w-8 text-gray-400 mb-2"></i>
                                <p class="text-sm">Tidak ada testimoni terbaru</p>
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

const stats = ref({
    products: 0,
    clients: 0,
    testimonials: 0,
    admins: 0,
})

const recentProducts = ref<Product[]>([])
const recentTestimonials = ref<Testimonial[]>([])

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

const isLoading = ref(true)

const loadDashboardData = async () => {
    isLoading.value = true

    const results = await Promise.allSettled([
        api.getProducts(),
        api.getClients(),
        api.getTestimonials(),
        api.getAdmins(),
    ])

    if (results[0].status === 'fulfilled') {
        const products = results[0].value
        stats.value.products = products.length
        recentProducts.value = products.slice(0, 4)
    } else {
        console.error('Error loading products:', results[0].reason)
        stats.value.products = 0
        recentProducts.value = []
    }

    if (results[1].status === 'fulfilled') {
        const clients = results[1].value
        stats.value.clients = clients.length
    } else {
        console.error('Error loading clients:', results[1].reason)
        stats.value.clients = 0
    }

    if (results[2].status === 'fulfilled') {
        const testimonials = results[2].value
        stats.value.testimonials = testimonials.length
        recentTestimonials.value = testimonials.slice(0, 4)
    } else {
        console.error('Error loading testimonials:', results[2].reason)
        stats.value.testimonials = 0
        recentTestimonials.value = []
    }

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
