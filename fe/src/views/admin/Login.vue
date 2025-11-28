<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="min-h-screen flex items-center justify-center bg-primary p-4">
    <div class="w-full max-w-md">
      <div class="bg-white rounded-xl shadow-2xl p-10">
        <!-- Logo/Title -->
        <div class="text-center mb-8">
          <div class="mb-4">
            <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto">
              <i class="fa-solid fa-lock w-8 h-8 text-white"></i>
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
                <i v-if="showPassword" class="fa-solid fa-eye w-5 h-5"></i>
                <i v-else class="fa-solid fa-eye-slash w-5 h-5"></i>
              </button>
            </div>
          </div>

          <!-- Error Message -->
          <div
            v-if="error"
            class="p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"
          >
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
              <i class="fa-solid fa-spinner animate-spin -ml-1 mr-2 h-5 w-5 text-white"></i>
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
import { useAuth } from '@/composables/useAuth'

const username = ref('')
const password = ref('')
const showPassword = ref(false)

const { login, isLoading, error, checkAuthRedirect } = useAuth()

onMounted(() => {
  checkAuthRedirect()
})

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}

const handleSubmit = async () => {
  try {
    await login({
      username: username.value,
      password: password.value,
    })
  } catch (err) {
    // Error is handled by useAuth composable
    console.error('Login failed:', err)
  }
}
</script>
