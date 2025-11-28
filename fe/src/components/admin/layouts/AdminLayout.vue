<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Mobile Overlay -->
    <div
      v-if="isSidebarOpen"
      @click="toggleSidebar"
      class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
    ></div>

    <div class="flex">
      <!-- Sidebar -->
      <aside
        :class="[
          'bg-primary text-white shadow-lg fixed left-0 top-0 h-screen z-50 overflow-y-auto transition-all duration-300',
          {
            '-translate-x-full lg:translate-x-0': !isSidebarOpen && !isDesktopCollapsed,
            'translate-x-0': isSidebarOpen,
            'w-64': !isDesktopCollapsed,
            'w-20': isDesktopCollapsed,
          },
        ]"
      >
        <div class="p-5 border-b border-primary-light flex items-center justify-between">
          <h1 v-if="!isDesktopCollapsed" class="text-xl text-white font-bold">Admin Panel</h1>
          <button @click="toggleSidebar" class="lg:hidden text-white hover:text-cream">
            <i class="fa-solid fa-xmark w-6 h-6"></i>
          </button>
          <button
            @click="toggleDesktopCollapse"
            class="hidden lg:block text-white hover:text-cream"
          >
            <i
              class="fa-solid"
              :class="isDesktopCollapsed ? 'fa-angles-right' : 'fa-angles-left'"
            ></i>
          </button>
        </div>
        <nav class="p-3">
          <ul class="space-y-2">
            <li>
              <router-link
                to="/admin/dashboard"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-dashboard',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-dashboard',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Dashboard' : ''"
              >
                <i class="fa-solid fa-gauge w-5 h-5" :class="{ 'mr-3': !isDesktopCollapsed }"></i>
                <span v-if="!isDesktopCollapsed">Dashboard</span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/admin/produk"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-product',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-product',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Manajemen Produk' : ''"
              >
                <i class="fa-solid fa-box w-5 h-5" :class="{ 'mr-3': !isDesktopCollapsed }"></i>
                <span v-if="!isDesktopCollapsed">Manajemen Produk</span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/admin/our-client"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-client',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-client',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Manajemen Klien' : ''"
              >
                <i class="fa-solid fa-users w-5 h-5" :class="{ 'mr-3': !isDesktopCollapsed }"></i>
                <span v-if="!isDesktopCollapsed">Manajemen Klien</span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/admin/testimoni"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-testimonial',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-testimonial',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Manajemen Testimoni' : ''"
              >
                <i class="fa-solid fa-comment w-5 h-5" :class="{ 'mr-3': !isDesktopCollapsed }"></i>
                <span v-if="!isDesktopCollapsed">Manajemen Testimoni</span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/admin/visi-misi"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-vision-mission',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-vision-mission',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Visi & Misi' : ''"
              >
                <i
                  class="fa-solid fa-file-lines w-5 h-5"
                  :class="{ 'mr-3': !isDesktopCollapsed }"
                ></i>
                <span v-if="!isDesktopCollapsed">Visi & Misi</span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/admin/kontak"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-contact',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-contact',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Kontak' : ''"
              >
                <i class="fa-solid fa-phone w-5 h-5" :class="{ 'mr-3': !isDesktopCollapsed }"></i>
                <span v-if="!isDesktopCollapsed">Kontak</span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/admin/hero"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-hero',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-hero',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Hero Section' : ''"
              >
                <i class="fa-solid fa-image w-5 h-5" :class="{ 'mr-3': !isDesktopCollapsed }"></i>
                <span v-if="!isDesktopCollapsed">Hero Section</span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/admin/company-history"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-company-history',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-company-history',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Riwayat Perusahaan' : ''"
              >
                <i
                  class="fa-solid fa-clock-rotate-left w-5 h-5"
                  :class="{ 'mr-3': !isDesktopCollapsed }"
                ></i>
                <span v-if="!isDesktopCollapsed">Riwayat Perusahaan</span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/admin/settings"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-settings',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-settings',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Pengaturan Situs' : ''"
              >
                <i class="fa-solid fa-gear w-5 h-5" :class="{ 'mr-3': !isDesktopCollapsed }"></i>
                <span v-if="!isDesktopCollapsed">Pengaturan Situs</span>
              </router-link>
            </li>

            <!-- Super Admin only menu items -->
            <li v-if="isSuperAdmin()">
              <router-link
                to="/admin/riwayat"
                @click="closeSidebarOnMobile"
                :class="{
                  'flex items-center p-3 rounded-lg transition-colors duration-200': true,
                  'bg-cream text-primary': $route.name === 'admin-history',
                  'hover:bg-cream hover:text-primary': $route.name !== 'admin-history',
                  'justify-center': isDesktopCollapsed,
                }"
                :title="isDesktopCollapsed ? 'Manajemen Admin' : ''"
              >
                <i
                  class="fa-solid fa-user-gear w-5 h-5"
                  :class="{ 'mr-3': !isDesktopCollapsed }"
                ></i>
                <span v-if="!isDesktopCollapsed">Manajemen Admin</span>
              </router-link>
            </li>
          </ul>
        </nav>
      </aside>

      <div
        class="flex-1 transition-all duration-300"
        :class="isDesktopCollapsed ? 'lg:ml-20' : 'lg:ml-64'"
      >
        <!-- Top Navigation Bar -->
        <header
          class="bg-primary shadow-sm text-white fixed top-0 right-0 left-0 z-40 transition-all duration-300"
          :class="isDesktopCollapsed ? 'lg:left-20' : 'lg:left-64'"
        >
          <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
              <div class="flex items-center space-x-3">
                <!-- Hamburger Menu Button -->
                <button
                  @click="toggleSidebar"
                  class="lg:hidden text-white hover:text-cream focus:outline-none"
                >
                  <i class="fa-solid fa-bars w-6 h-6"></i>
                </button>

                <h1 class="text-lg sm:text-xl font-semibold text-white capitalize">
                  {{
                    typeof $route.name === 'string'
                      ? $route.name.replace('admin-', '').replace('-', ' ')
                      : 'Dashboard'
                  }}
                </h1>
              </div>

              <div class="flex items-center space-x-2 sm:space-x-4">
                <!-- Role badge -->
                <span
                  class="hidden sm:inline-block px-2 py-1 text-xs font-semibold rounded-full"
                  :class="{
                    'bg-blue-100 text-blue-800': isAdmin(),
                    'bg-purple-100 text-purple-800': isSuperAdmin(),
                  }"
                >
                  {{ isSuperAdmin() ? 'Super Admin' : 'Admin' }}
                </span>

                <button
                  @click="showLogoutConfirmation"
                  class="flex items-center text-sm font-medium text-cream hover:text-white"
                >
                  <i class="fa-solid fa-right-from-bracket w-5 h-5 sm:mr-1"></i>
                  <span class="hidden sm:inline">Logout</span>
                </button>
              </div>
            </div>
          </div>
        </header>

        <!-- Main Content -->
        <main class="pt-32 p-4 sm:p-6 bg-gray-50 min-h-screen">
          <div class="max-w-full">
            <router-view />
          </div>
        </main>
      </div>
    </div>

    <!-- Toast Notifications -->
    <ToastNotification ref="toastRef" />

    <!-- Logout Confirmation Modal -->
    <div
      v-if="showLogoutModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-[60] p-4"
      @click="closeLogoutModal"
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6" @click.stop>
        <div class="text-center">
          <div
            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4"
          >
            <i class="fa-solid fa-right-from-bracket text-2xl text-red-600"></i>
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
const isSidebarOpen = ref(false)
const showLogoutModal = ref(false)
const isDesktopCollapsed = ref(false)

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}

const toggleDesktopCollapse = () => {
  isDesktopCollapsed.value = !isDesktopCollapsed.value
}

const closeSidebarOnMobile = () => {
  if (window.innerWidth < 1024) {
    isSidebarOpen.value = false
  }
}

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
    console.error('Error during logout:', error)
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    localStorage.removeItem('userRole')
    router.push('/login')
  } finally {
    showLogoutModal.value = false
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
