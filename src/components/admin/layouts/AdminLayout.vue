<template>
  <div class="min-h-screen bg-gray-50">
    <div class="flex">
      <!-- Sidebar -->
      <aside class="bg-primary text-white shadow-lg w-64 fixed left-0 top-0 h-screen z-50 overflow-y-auto">
        <div class="p-5 border-b border-primary-light">
          <h1 class="text-xl text-white font-bold">Admin Panel</h1>
        </div>
        <nav class="p-3">
        <ul class="space-y-2">
          <li>
            <router-link 
              to="/admin/dashboard" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-dashboard',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-dashboard',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              Dashboard
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/produk" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-product',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-product',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
              Manajemen Produk
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/our-client" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-client',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-client',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              Manajemen Klien
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/testimoni" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-testimonial',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-testimonial',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
              </svg>
              Manajemen Testimoni
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/visi-misi" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-vision-mission',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-vision-mission',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              Visi & Misi
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/kontak" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-contact',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-contact',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              Kontak
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/hero" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-hero',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-hero',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              Hero Section
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/company-history" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-company-history',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-company-history',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              Riwayat Perusahaan
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/settings" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-settings',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-settings',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Pengaturan Situs
            </router-link>
          </li>
          
          <!-- Super Admin only menu items -->
          <li v-if="isSuperAdmin()">
            <router-link 
              to="/admin/riwayat" 
              :class="{
                'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                'bg-cream text-primary': $route.name === 'admin-history',
                'hover:bg-cream hover:text-primary': $route.name !== 'admin-history',
              }"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Manajemen Admin
            </router-link>
          </li>
        </ul>
        </nav>
      </aside>

      <div class="flex-1 ml-64">
        <!-- Top Navigation Bar -->
        <header class="bg-primary shadow-sm text-white fixed top-0 right-0 left-64 z-40">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
              <h1 class="text-xl font-semibold text-white capitalize">
                {{
                  typeof $route.name === 'string'
                    ? $route.name.replace('admin-', '').replace('-', ' ')
                    : 'Dashboard'
                }}
              </h1>
            </div>
            
            <div class="flex items-center space-x-4">
              <div class="text-sm text-cream">
                <span class="font-medium">Halo,</span> 
                <span class="font-semibold">{{ currentUser?.username || 'Admin' }}</span>
              </div>
              
              <!-- Role badge -->
              <span 
                class="px-2 py-1 text-xs font-semibold rounded-full"
                :class="{
                  'bg-blue-100 text-blue-800': isAdmin(),
                  'bg-purple-100 text-purple-800': isSuperAdmin()
                }"
              >
                {{ isSuperAdmin() ? 'Super Admin' : 'Admin' }}
              </span>
              
              <button 
                @click="handleLogout"
                class="flex items-center text-sm font-medium text-cream hover:text-white"
              >
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
              </button>
            </div>
          </div>
        </div>
        </header>

        <!-- Main Content -->
        <main class="pt-[88px] p-6 bg-gray-50 min-h-screen">
          <div class="max-w-full">
            <router-view />
          </div>
        </main>
      </div>
    </div>

    <!-- Toast Notifications -->
    <ToastNotification ref="toastRef" />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { authService } from '@/services/auth'
import ToastNotification from '@/components/common/ToastNotification.vue'
import { useToast } from '@/composables/useToast'

const router = useRouter()
const currentUser = ref<{ id: number; username: string } | null>(null)
const toastRef = ref()
const toast = useToast()

const loadUser = async () => {
  try {
    const token = localStorage.getItem('token')
    const userData = localStorage.getItem('user')
    
    if (token && userData) {
      try {
        currentUser.value = JSON.parse(userData)
      } catch (e) {
        console.error('Error parsing user data:', e)
        router.push('/login')
      }
    } else {
      router.push('/login')
    }
  } catch (error) {
    console.error('Error loading user:', error)
    router.push('/login')
  }
}

const handleLogout = async () => {
  try {
    await api.logout()
    router.push('/login')
  } catch (error) {
    console.error('Error during logout:', error)
    // Even if logout API fails, clear local storage and redirect to login
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    localStorage.removeItem('userRole')
    router.push('/login')
  }
}

const isAdmin = () => {
  return authService.isAdmin()
}

const isSuperAdmin = () => {
  return authService.isSuperAdmin()
}

onMounted(() => {
  loadUser()

  // Initialize toast instance
  if (toastRef.value) {
    toast.setToastInstance(toastRef.value)
  }
})
</script>
