<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <aside
    :class="{
      'bg-primary text-white shadow-lg min-h-screen transition-all duration-300': true,
      'w-64': isOpen,
      'w-20': !isOpen,
    }"
  >
    <div class="p-5 border-b border-primary-light flex items-center justify-between">
      <h1 v-if="isOpen" class="text-xl text-white font-bold">Admin Panel</h1>
      <button
        @click="toggleSidebar"
        class="p-2 hover:bg-primary-light rounded-lg transition ml-auto"
      >
        <i-lucide:menu class="w-5 h-5" />
      </button>
    </div>
    <nav class="p-3">
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
            <span v-if="isOpen">Testimonial</span>
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
        <li v-if="isAdminSuperadmin">
          <router-link
            :to="{ name: 'admin-history' }"
            :class="{
              'flex items-center p-3 rounded-lg transition-colors duration-200': true,
              'bg-cream text-primary': $route.name === 'admin-history',
              'hover:bg-cream hover:text-primary': $route.name !== 'admin-history',
              'justify-center': !isOpen,
            }"
            :title="!isOpen ? 'Admin Management' : ''"
          >
            <i-lucide:settings :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'" />
            <span v-if="isOpen">Admin Management</span>
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
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const router = useRouter()
const isAdminSuperadmin = ref(false)
const isOpen = ref(true)

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
