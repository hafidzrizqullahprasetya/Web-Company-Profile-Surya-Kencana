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
      <button @click="toggleSidebar" class="p-2 hover:bg-primary-light rounded-lg transition">
        <i v-if="isOpen" class="fa-solid fa-bars w-5 h-5"></i>
        <i v-else class="fa-solid fa-table-columns w-5 h-5"></i>
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
            <i class="fa-solid fa-home" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
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
            <i class="fa-solid fa-box" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
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
            <i class="fa-solid fa-users" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
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
            <i class="fa-solid fa-comment" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
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
            <i class="fa-solid fa-file-alt" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
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
            <i class="fa-solid fa-phone" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
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
            <i class="fa-solid fa-layer-group" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
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
            <i class="fa-solid fa-calendar" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
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
            <i class="fa-solid fa-cog" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
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
            <i class="fa-solid fa-user-cog" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
            <span v-if="isOpen">Manajemen Admin</span>
          </router-link>
        </li>
      </ul>

      <div class="mt-8 pt-4 border-t border-primary-light">
        <button
          @click="showLogoutConfirmation"
          :class="{
            'w-full flex items-center p-3 text-red-400 hover:bg-red-900/20 hover:text-red-300 rounded-lg transition-colors duration-200': true,
            'justify-center': !isOpen,
          }"
          :title="!isOpen ? 'Logout' : ''"
        >
          <i class="fa-solid fa-sign-out-alt" :class="isOpen ? 'w-5 h-5 mr-3' : 'w-5 h-5'"></i>
          <span v-if="isOpen">Logout</span>
        </button>
      </div>
    </nav>
  </aside>

  <!-- Logout Confirmation Modal -->
  <div
    v-if="showLogoutModal"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
    @click="closeLogoutModal"
  >
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6" @click.stop>
      <div class="text-center">
        <div
          class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4"
        >
          <i class="fa-solid fa-right-from-bracket h-6 w-6 text-red-600"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Logout?</h3>
        <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin keluar dari akun admin?</p>
        <div class="flex gap-3">
          <button
            @click="closeLogoutModal"
            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
          >
            Batal
          </button>
          <button
            @click="confirmLogout"
            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
          >
            Logout
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const router = useRouter()
const isAdminSuperadmin = ref(false)
const isOpen = ref(true)
const showLogoutModal = ref(false)

onMounted(() => {
  const token = localStorage.getItem('token')
  if (token) {
    isAdminSuperadmin.value = true
  }
})

const toggleSidebar = () => {
  isOpen.value = !isOpen.value
}

const showLogoutConfirmation = () => {
  showLogoutModal.value = true
}

const closeLogoutModal = () => {
  showLogoutModal.value = false
}

const confirmLogout = async () => {
  try {
    await api.logout()
    router.push('/login')
  } catch (error) {
    console.error('Logout error:', error)
    localStorage.removeItem('token')
    router.push('/login')
  } finally {
    showLogoutModal.value = false
  }
}
</script>
