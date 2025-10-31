<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="min-h-screen flex items-center justify-center bg-primary p-4">
    <div class="w-full max-w-md">
      <div class="bg-white rounded-xl shadow-2xl p-10">
        <!-- Logo/Title -->
        <div class="text-center mb-8">
          <div class="mb-4">
            <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
          </div>
          <h1 class="text-2xl font-bold text-gray-900">Panel Admin</h1>
          <p class="text-gray-600 mt-1 text-sm">Silakan login untuk melanjutkan</p>
        </div>

        <!-- Login Form -->
        <form @submit.prevent="handleSubmit" class="space-y-5">
          <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
              Username
            </label>
            <input
              id="username"
              v-model="username"
              type="text"
              required
              autocomplete="username"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
              placeholder="Masukkan username Anda"
            />
          </div>

          <div class="relative">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
              Password
            </label>
            <div class="relative">
              <input
                id="password"
                v-model="password"
                :type="showPassword ? 'text' : 'password'"
                required
                autocomplete="current-password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition pr-12"
                placeholder="Masukkan password Anda"
              />
              <button
                type="button"
                @click="togglePasswordVisibility"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700"
              >
                <svg
                  v-if="showPassword"
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  />
                </svg>
                <svg
                  v-else
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                  />
                </svg>
              </button>
            </div>
          </div>

          <!-- Error Message -->
          <div v-if="error" class="p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            {{ error }}
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="isLoading"
            class="w-full py-3 px-4 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            <span v-if="!isLoading">Login</span>
            <span v-else class="flex items-center justify-center">
              <svg
                class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              Memproses...
            </span>
          </button>
        </form>
        
        <div class="mt-4 text-center text-xs text-gray-500">
          <p>Untuk Admin: username=admin, password=admin123</p>
          <p>Untuk Super Admin: username=superadmin, password=superadmin123</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import { useRouter, useRoute } from 'vue-router'

const username = ref('')
const password = ref('')
const showPassword = ref(false)
const isLoading = ref(false)
const error = ref('')
const router = useRouter()
const route = useRoute()

onMounted(() => {
  const token = localStorage.getItem('token')
  if (token) {
    // Redirect based on role after checking user role
    const userRole = localStorage.getItem('userRole')
    if (userRole === 'superadmin') {
      router.push('/admin/dashboard')
    } else {
      router.push('/admin/dashboard')
    }
  }
})

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}

const handleSubmit = async () => {
  try {
    isLoading.value = true
    error.value = ''
    
    // For the current backend, there's only one login endpoint
    // We'll use the standard login and determine the role based on credentials
    await api.login({
      username: username.value,
      password: password.value,
    })
    
    // Determine role based on credentials since backend doesn't return role info
    if (username.value === 'superadmin' && password.value === 'superadmin123') {
      localStorage.setItem('userRole', 'superadmin')
    } else if (username.value === 'admin' && password.value === 'admin123') {
      localStorage.setItem('userRole', 'admin')
    } else {
      // For other credentials, try to determine role
      // Default to admin for now, but this should be handled by the backend
      localStorage.setItem('userRole', 'admin')
    }
    
    // Redirect to dashboard
    const redirectPath = (route.query.redirect as string) || '/admin/dashboard'
    router.push(redirectPath)
  } catch (err: unknown) {
    console.error('Login error:', err)
    error.value = 'Username atau password tidak valid. Silakan coba lagi.'
  } finally {
    isLoading.value = false
  }
}
</script>
