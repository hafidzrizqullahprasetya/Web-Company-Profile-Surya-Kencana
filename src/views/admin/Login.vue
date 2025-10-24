<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200 p-4"
  >
    <div class="w-full max-w-md">
      <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-10 border border-primary-200">
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-primary-900">Admin Login</h1>
          <p class="text-gray-600 mt-2">Silakan masuk untuk melanjutkan</p>
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-6">
          <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1"
              >Username</label
            >
            <input
              id="username"
              v-model="username"
              type="text"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
              placeholder="masukkan username anda"
            />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1"
              >Password</label
            >
            <input
              id="password"
              v-model="password"
              type="password"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
              placeholder="masukkan password anda"
            />
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input
                id="remember-me"
                name="remember-me"
                type="checkbox"
                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
              />
              <label for="remember-me" class="ml-2 block text-sm text-gray-700"> Ingat saya </label>
            </div>

            <div class="text-sm">
              <a href="#" class="font-medium text-primary-600 hover:text-primary-500">
                Lupa password?
              </a>
            </div>
          </div>

          <div>
            <button
              type="submit"
              :disabled="isLoading"
              class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-700 hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed transition"
            >
              <span v-if="!isLoading">Masuk</span>
              <span v-else class="flex items-center">
                <svg
                  class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
          </div>
        </form>

        <div class="mt-8">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">Atau masuk sebagai</span>
            </div>
          </div>

          <div class="mt-6 grid grid-cols-2 gap-3">
            <button
              @click="loginAs('admin')"
              :disabled="isLoading"
              class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition"
            >
              Admin
            </button>
            <button
              @click="loginAs('superadmin')"
              :disabled="isLoading"
              class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition"
            >
              Superadmin
            </button>
          </div>
        </div>
      </div>

      <div
        v-if="error"
        class="mt-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-center"
      >
        {{ error }}
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
const isLoading = ref(false)
const error = ref('')
const router = useRouter()
const route = useRoute()

onMounted(() => {
  const token = localStorage.getItem('token')
  if (token) {
    router.push('/admin/dashboard')
  }
})

const handleSubmit = async () => {
  try {
    isLoading.value = true
    error.value = ''

    await api.adminLogin({
      username: username.value,
      password: password.value,
    })
    const redirectPath = (route.query.redirect as string) || '/admin/dashboard'
    router.push(redirectPath)
  } catch (err: unknown) {
    console.error('Login error:', err)
    error.value = 'Username atau password salah. Silakan coba lagi.'
  } finally {
    isLoading.value = false
  }
}

const loginAs = async (role: 'admin' | 'superadmin') => {
  try {
    isLoading.value = true
    error.value = ''

    if (role === 'admin') {
      await api.adminLogin({
        username: username.value,
        password: password.value,
      })
    } else {
      await api.superAdminLogin({
        username: username.value,
        password: password.value,
      })
    }

    const redirectPath = (route.query.redirect as string) || '/admin/dashboard'
    router.push(redirectPath)
  } catch (err: unknown) {
    console.error(`Login as ${role} error:`, err)
    error.value = `Gagal login sebagai ${role}. Silakan coba lagi.`
  } finally {
    isLoading.value = false
  }
}
</script>
