<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <aside
    :class="{
      'bg-primary text-white shadow-lg min-h-screen transition-all duration-300 sticky top-0 h-screen': true,
      'w-64': isOpen,
      'w-20': !isOpen,
    }"
  >
    <div class="p-5 border-b border-primary-light flex items-center justify-between">
      <h1 v-if="isOpen" class="text-xl text-white font-bold">Admin Panel</h1>
      <button
        @click="toggleSidebar"
        class="p-2 hover:bg-primary-light rounded-lg transition"
      >
        <i-lucide:menu v-if="isOpen" class="w-5 h-5" />
        <i-lucide:sidebar class="w-5 h-5" v-else />
      </button>
    </div>
    <nav class="p-3 overflow-y-auto h-[calc(100vh-76px)]">
      <ul class="space-y-2">
        <li>
          <router-link
            :to="{ name: 'admin-dashboard' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-dashboard',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-dashboard',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Dashboard' : ''"
          >
            <i-lucide:home :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Dashboard</span>
          </router-link>
        </li>
        <li>
          <router-link
            :to="{ name: 'admin-product' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-product',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-product',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Produk' : ''"
          >
            <i-lucide:package :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Produk</span>
          </router-link>
        </li>
        <li>
          <router-link
            :to="{ name: 'admin-client' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-client',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-client',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Our Client' : ''"
          >
            <i-lucide:users :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Our Client</span>
          </router-link>
        </li>
        <li>
          <router-link
            :to="{ name: 'admin-testimonial' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-testimonial',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-testimonial',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Testimonial' : ''"
          >
            <i-lucide:message-circle :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Testimoni</span>
          </router-link>
        </li>
        <li>
          <router-link
            :to="{ name: 'admin-vision-mission' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-vision-mission',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-vision-mission',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Visi & Misi' : ''"
          >
            <i-lucide:file-text :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Visi & Misi</span>
          </router-link>
        </li>
        <li>
          <router-link
            :to="{ name: 'admin-contact' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-contact',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-contact',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Kontak' : ''"
          >
            <i-lucide:phone :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Kontak</span>
          </router-link>
        </li>
        <li>
          <router-link
            :to="{ name: 'admin-hero' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-hero',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-hero',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Bagian Hero' : ''"
          >
            <i-lucide:layout :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Bagian Hero</span>
          </router-link>
        </li>
        <li>
          <router-link
            :to="{ name: 'admin-company-history' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-company-history',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-company-history',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Company History' : ''"
          >
            <i-lucide:calendar :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Riwayat Perusahaan</span>
          </router-link>
        </li>
        <li>
          <router-link
            :to="{ name: 'admin-settings' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-settings',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-settings',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Pengaturan Situs' : ''"
          >
            <i-lucide:settings :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Pengaturan Situs</span>
          </router-link>
        </li>
        <li v-if="isAdminSuperadmin">
          <router-link
            :to="{ name: 'admin-history' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-history',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-history',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Manajemen Admin' : ''"
          >
            <i-lucide:user-cog :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Manajemen Admin</span>
          </router-link>
        </li>
      </ul>

      <div class="mt-8 pt-4 border-t border-primary-light">
        <button
          @click="logout"
          :class="{
            'w-full flex items-center p-3 text-red-400 hover:bg-red-900/20 hover:text-red-300 rounded-lg transition-colors duration-200': true,
            'justify-center': !isOpen,
          }"
          :title="!isOpen ? 'Logout' : ''"
        >
          <i-lucide:log-out :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
          <span v-if="isOpen">Logout</span>
        </button>
      </div>
    </nav>
  </aside>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const router = useRouter()
const isAdminSuperadmin = ref(false)
const isOpen = ref(true)

// Check if user is superadmin (for now, we'll check if token exists - can be enhanced with role checking)
onMounted(() => {
  const token = localStorage.getItem('token')
  if (token) {
    // For now, all logged-in users can access admin management
    // TODO: Add proper role checking when backend supports it
    isAdminSuperadmin.value = true
  }
})

const toggleSidebar = () => {
  isOpen.value = !isOpen.value
}

const logout = async () => {
  try {
    await api.logout()
    router.push('/login')
  } catch (error) {
    console.error('Logout error:', error)
    localStorage.removeItem('token')
    router.push('/login')
  }
}
</script>
