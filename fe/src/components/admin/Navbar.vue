<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <header class="bg-primary shadow-sm text-white sticky top-0 z-50">
        <div class="flex items-center justify-between px-4 sm:px-6 h-16">
            <!-- Hamburger Menu Button (Mobile Only) -->
            <button @click="handleMobileMenuToggle" class="lg:hidden p-2 hover:bg-white/10 rounded-lg transition">
                <i class="fa-solid fa-bars w-5 h-5"></i>
            </button>

            <!-- Page Title -->
            <h2 class="text-lg sm:text-xl font-semibold text-white capitalize line-clamp-1 flex-1 px-4 lg:px-0">
                {{
                    typeof $route.name === 'string'
                        ? $route.name.replace('admin-', '').replace('-', ' ')
                        : 'Dashboard'
                }}
            </h2>

            <!-- User Info & Logout -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- User Info (Hidden on mobile) -->
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-medium text-white">
                        {{ currentUser?.username || 'Admin' }}
                    </p>
                    <p class="text-xs text-white/70">{{ userRoleLabel }}</p>
                </div>

                <!-- Logout Button -->
                <button @click="handleLogout"
                    class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition">
                    <i class="fa-solid fa-sign-out-alt w-4 h-4 sm:w-5 sm:h-5"></i>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { useAuth } from '@/composables/useAuth'

const router = useRouter()
const { logout } = useAuth()
const currentUser = ref<{ id: number; username: string } | null>(null)
const userRole = ref<string>('admin')

const userRoleLabel = computed(() => {
    return userRole.value === 'superadmin' ? 'Super Admin' : 'Admin'
})

const handleMobileMenuToggle = () => {
    window.dispatchEvent(new CustomEvent('toggleMobileSidebar'))
}

onMounted(async () => {
    try {
        const token = localStorage.getItem('token')
        const userData = localStorage.getItem('user')

        if (token && userData) {
            currentUser.value = JSON.parse(userData)
        }

        const response = await api.getCurrentAdmin()
        userRole.value = response.role || 'admin'
    } catch (error) {
        console.error('Error loading user info:', error)
    }
})

const handleLogout = async () => {
    await logout()
}
</script>
```

Now let me fix the Dashboard grid to be 2 columns on mobile:
