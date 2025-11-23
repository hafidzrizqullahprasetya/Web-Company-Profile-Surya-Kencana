<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <header class="bg-primary shadow-sm text-white sticky top-0 z-40">
    <div class="flex items-center justify-between p-4">
      <h2 class="text-xl font-semibold text-white capitalize">
        {{
          typeof $route.name === 'string'
            ? $route.name.replace('admin-', '').replace('-', ' ')
            : 'Dashboard'
        }}   
      </h2>
      <div class="flex items-center relative">
        <div class="mr-4 text-right">
          <p class="text-sm font-medium text-white">
            {{ currentUser?.username || 'Admin User' }}
          </p>
          <p class="text-xs text-cream">{{ isAdminSuperadmin ? 'Super Admin' : 'Admin' }}</p>
        </div>
        <button
          @click.stop="toggleDropdown"
          class="w-10 h-10 rounded-full bg-cream bg-opacity-20 flex items-center justify-center hover:bg-opacity-30 transition"
        >
          <span class="text-cream font-medium">{{
            initials(currentUser?.username || 'Admin')
          }}</span>
        </button>

        <!-- Dropdown Menu -->
        <div
          ref="dropdown"
          v-show="isDropdownOpen"
          @click.stop
          class="absolute right-0 top-14 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border"
        >
          <div class="py-1">
            <button
              @click="logout"
              class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-600 hover:text-white transition"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const router = useRouter()
const isAdminSuperadmin = ref(false)
const currentUser = ref<{ id: number; username: string } | null>(null)
const isDropdownOpen = ref(false)
const dropdown = ref<HTMLElement | null>(null)

const closeDropdown = (event: Event) => {
  if (dropdown.value && !dropdown.value.contains(event.target as Node)) {
    isDropdownOpen.value = false
  }
}

const loadUser = async () => {
  try {
    const token = localStorage.getItem('token')
    const userData = localStorage.getItem('user')
    if (token && userData) {
      currentUser.value = JSON.parse(userData)
      isAdminSuperadmin.value = true
    } else {
      router.push('/login')
    }
  } catch (error) {
    console.error('Error loading user:', error)
    router.push('/login')
  }
}

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value
}

const logout = async () => {
  try {
    await api.logout()
    router.push('/login')
  } catch (error) {
    console.error('Logout error:', error)
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    router.push('/login')
  }
}

const initials = (name: string) => {
  return name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase()
    .substring(0, 2)
}

onMounted(() => {
  loadUser()
  document.addEventListener('click', closeDropdown)
})

onUnmounted(() => {
  document.removeEventListener('click', closeDropdown)
})
</script>
