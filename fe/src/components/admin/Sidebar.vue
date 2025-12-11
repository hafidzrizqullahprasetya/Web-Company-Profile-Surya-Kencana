<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <!-- Mobile Drawer Overlay -->
    <div v-if="isOpen && isMobile" @click="closeSidebarOnMobile" class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="{
        'bg-primary text-white shadow-lg transition-all duration-300 flex flex-col flex-shrink-0': true,
        'fixed top-0 left-0 h-screen z-50 w-64': isMobile,
        'translate-x-0': isMobile && isOpen,
        '-translate-x-full': isMobile && !isOpen,
        'h-screen': !isMobile,
        'w-64': !isMobile && isOpen,
        'w-16 sm:w-20': !isMobile && !isOpen,
    }" ref="sidebarElement">
        <!-- Header -->
        <div class="p-3 sm:p-5 border-b border-primary-light flex items-center justify-between flex-shrink-0">
            <h1 v-if="isOpen" class="text-lg sm:text-xl text-white font-bold line-clamp-1">
                {{ panelTitle }}
            </h1>
            <button @click="toggleSidebar" class="p-2 hover:bg-white/10 rounded-lg transition flex-shrink-0">
                <i v-if="isOpen" class="fa-solid fa-bars w-5 h-5"></i>
                <i v-else class="fa-solid fa-bars w-4 h-4 sm:w-5 sm:h-5"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="p-2 sm:p-3 overflow-y-auto flex-1">
            <ul class="space-y-1 sm:space-y-2" draggable="false">
                <li v-for="(item, index) in visibleMenuItems" :key="item.name" draggable="true"
                    @dragstart="handleDragStart(index)" @dragover.prevent="handleDragOver(index)"
                    @drop.prevent="handleDrop()" @dragend="handleDragEnd"
                    :class="{ 'opacity-50 bg-white/10 rounded-lg': draggedIndex === index }"
                    class="transition-all duration-200">
                    <router-link :to="{ name: item.name }" :class="{
                        'flex items-center p-2 sm:p-3 rounded-lg transition-colors duration-200': true,
                        'bg-white text-primary': $route.name === item.name,
                        'hover:bg-white hover:text-primary': $route.name !== item.name,
                        'justify-center': !isOpen,
                    }" :title="!isOpen ? item.label : ''" @click="handleNavClick">
                        <i :class="[item.icon, isOpen ? 'w-5 h-5 mr-2 sm:mr-3' : 'w-4 h-4 sm:w-5 sm:h-5']"></i>
                        <span v-if="isOpen" class="text-sm sm:text-base">{{ item.label }}</span>
                    </router-link>
                </li>
            </ul>

            <!-- Logout Section -->
            <div class="mt-6 sm:mt-8 pt-3 sm:pt-4 border-t border-primary-light">
                <button @click="handleLogout" :class="{
                    'w-full flex items-center p-2 sm:p-3 text-red-400 hover:bg-red-900/20 hover:text-red-300 rounded-lg transition-colors duration-200': true,
                    'justify-center': !isOpen,
                }" :title="!isOpen ? 'Logout' : ''">
                    <i class="fa-solid fa-sign-out-alt"
                        :class="isOpen ? 'w-5 h-5 mr-2 sm:mr-3' : 'w-4 h-4 sm:w-5 sm:h-5'"></i>
                    <span v-if="isOpen" class="text-sm sm:text-base">Logout</span>
                </button>
            </div>
        </nav>
    </aside>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { adminPreferencesApi } from '@/services/admin-preferences'
import { useAuth } from '@/composables/useAuth'
import Swal from 'sweetalert2'

const router = useRouter()
const { logout } = useAuth()
const sidebarElement = ref<HTMLElement | null>(null)
const isMobile = ref(false)
// Initialize to closed first, then update during onMounted based on screen size
const isOpen = ref(false)
const userRole = ref<string>('admin')
const adminId = ref<number>(0)
const draggedIndex = ref<number | null>(null)

interface MenuItem {
    name: string
    label: string
    icon: string
    visible?: boolean
}

const allMenuItems: MenuItem[] = [
    { name: 'admin-dashboard', label: 'Dashboard', icon: 'fa-solid fa-home' },
    { name: 'admin-product', label: 'Produk', icon: 'fa-solid fa-box' },
    { name: 'admin-client', label: 'Our Client', icon: 'fa-solid fa-users' },
    { name: 'admin-testimonial', label: 'Testimoni', icon: 'fa-solid fa-comment' },
    { name: 'admin-vision-mission', label: 'Visi & Misi', icon: 'fa-solid fa-file-alt' },
    { name: 'admin-contact', label: 'Kontak', icon: 'fa-solid fa-phone' },
    { name: 'admin-hero', label: 'Hero', icon: 'fa-solid fa-layer-group' },
    { name: 'admin-company-history', label: 'Riwayat Perusahaan', icon: 'fa-solid fa-calendar' },
    { name: 'admin-settings', label: 'Pengaturan Situs', icon: 'fa-solid fa-cog' },
    { name: 'admin-history', label: 'Manajemen Admin', icon: 'fa-solid fa-user-cog' },
]

const menuItems = ref<MenuItem[]>(allMenuItems)

const visibleMenuItems = computed(() => {
    return menuItems.value.filter(item => {
        if (item.name === 'admin-history') {
            return userRole.value === 'superadmin'
        }
        return true
    })
})

const panelTitle = computed(() => {
    return userRole.value === 'superadmin' ? 'Panel Superadmin' : 'Panel Admin'
})

const checkMobile = () => {
    const wasMobile = isMobile.value
    isMobile.value = window.innerWidth < 1024

    if (!wasMobile && isMobile.value) {
        isOpen.value = false
    } else if (wasMobile && !isMobile.value) {
        isOpen.value = true // Always open sidebar when switching from mobile to desktop
    }
}

const toggleSidebar = () => {
    isOpen.value = !isOpen.value
    if (!isMobile.value && adminId.value) {
        savePreferences()
    }
}

const handleMobileToggle = () => {
    if (isMobile.value) {
        isOpen.value = !isOpen.value
    }
}

const closeSidebarOnMobile = () => {
    if (isMobile.value) {
        isOpen.value = false
    }
}

const handleNavClick = () => {
    if (isMobile.value) {
        isOpen.value = false
    }
}

const handleDragStart = (index: number) => {
    draggedIndex.value = index
}

const handleDragOver = (index: number) => {
    if (draggedIndex.value === null || draggedIndex.value === index) return

    const items = [...menuItems.value]
    const draggedItem = items[draggedIndex.value]
    if (draggedItem) {
        items.splice(draggedIndex.value, 1)
        items.splice(index, 0, draggedItem!)
        menuItems.value = items
    }
    draggedIndex.value = index
}

const handleDrop = () => {
    const orderMap: Record<string, number> = {}
    menuItems.value.forEach((item, index) => {
        orderMap[item.name] = index
    })
    if (adminId.value) {
        saveMenuOrder(orderMap)
        // Show success notification
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Urutan menu berhasil disimpan',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        })
    }
}

const handleDragEnd = () => {
    draggedIndex.value = null
}

const handleLogout = async () => {
    await logout()
}

const savePreferences = async () => {
    if (!adminId.value) return
    try {
        await adminPreferencesApi.updateSidebarState(adminId.value, isOpen.value ? 'open' : 'closed')
    } catch (error) {
        console.error('Error saving preferences:', error)
    }
}

const saveMenuOrder = async (orderMap: Record<string, number>) => {
    if (!adminId.value) return
    try {
        await adminPreferencesApi.updateMenuOrder(adminId.value, orderMap)
    } catch (error) {
        console.error('Error saving menu order:', error)
    }
}

const loadPreferences = async () => {
    if (!adminId.value) return
    try {
        const prefs = await adminPreferencesApi.getPreferences(adminId.value)

        // Only update sidebar state if we're on desktop
        if (!isMobile.value) {
            // Default to open if no preference is set, or if preference says to open
            if (prefs.sidebar_state === 'closed') {
                isOpen.value = false
            } else {
                // If no preference or preference is 'open', default to open on desktop
                isOpen.value = true
            }
        }

        if (prefs.menu_order) {
            const orderMap = typeof prefs.menu_order === 'string'
                ? JSON.parse(prefs.menu_order)
                : prefs.menu_order
            menuItems.value.sort((a, b) => (orderMap[a.name] || 0) - (orderMap[b.name] || 0))
        }
    } catch (error: any) {
        console.error('Error loading preferences:', error)
        if ((error as any).response?.status === 404) {
            console.warn('Admin not found')
        } else {
            // On error, default to open on desktop
            if (!isMobile.value) {
                isOpen.value = true
            }
        }
    }
}

onMounted(async () => {
    checkMobile() // This sets isMobile and initializes isOpen based on screen size
    window.addEventListener('resize', checkMobile)
    window.addEventListener('toggleMobileSidebar', handleMobileToggle)

    try {
        const response = await api.getCurrentAdmin()
        userRole.value = response.role || 'admin'
        adminId.value = response.id || 0

        // Load preferences for all users
        if (!isMobile.value && adminId.value) {
            await loadPreferences()
        }
    } catch (error) {
        console.error('Error fetching user role:', error)
        // On error, default to open on desktop
        if (!isMobile.value) {
            isOpen.value = true
        }
    }
})

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile)
    window.removeEventListener('toggleMobileSidebar', handleMobileToggle)
})
</script>
