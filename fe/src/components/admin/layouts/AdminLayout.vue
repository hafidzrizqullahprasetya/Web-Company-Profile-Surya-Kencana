<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="h-screen overflow-hidden flex bg-gray-50">
        <!-- Sidebar Component (Sticky) -->
        <Sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
            <!-- Navbar Component (Sticky) -->
            <Navbar />

            <!-- Main Content (Scrollable) -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50">
                <div class="w-full max-w-full">
                    <router-view />
                </div>
            </main>
        </div>


    </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Sidebar from '@/components/admin/Sidebar.vue'
import Navbar from '@/components/admin/Navbar.vue'

const router = useRouter()

onMounted(() => {
    const token = localStorage.getItem('token')
    if (!token) {
        router.push('/login')
    }
})
</script>
