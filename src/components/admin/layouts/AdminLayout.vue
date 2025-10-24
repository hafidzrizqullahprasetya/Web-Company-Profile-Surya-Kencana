<template>
  <div class="flex h-screen bg-cream">
    <Sidebar />

    <!-- Main Content -->
    <main class="flex-1 overflow-auto">
      <Navbar />

      <div class="p-6">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Sidebar from '../Sidebar.vue'

const router = useRouter()
const isAdminSuperadmin = ref(false)
const currentUser = ref<{ id: number; username: string } | null>(null)

const loadUser = async () => {
  console.log('AdminLayout: loadUser called')
  try {
    const token = localStorage.getItem('token')
    const userData = localStorage.getItem('user')
    console.log('AdminLayout: token exists?', !!token)
    console.log('AdminLayout: userData exists?', !!userData)
    if (token && userData) {
      currentUser.value = JSON.parse(userData)
      isAdminSuperadmin.value = true
      console.log('AdminLayout: user loaded', currentUser.value)
    } else {
      console.log('AdminLayout: no token or userData, redirecting to login')
      router.push('/login')
    }
  } catch (error) {
    console.error('AdminLayout: Error loading user:', error)
    router.push('/login')
  }
}

onMounted(() => {
  console.log('AdminLayout: onMounted called')
  loadUser()
})
</script>
