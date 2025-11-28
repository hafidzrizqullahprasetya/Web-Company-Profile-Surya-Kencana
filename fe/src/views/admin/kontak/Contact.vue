<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6 pt-24 sm:pt-28">
    <div class="mb-6 sm:mb-8">
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Informasi Kontak</h1>
      <p class="text-sm sm:text-base text-gray-600 mt-2">
        Perbarui informasi kontak perusahaan Anda
      </p>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <SkeletonLoader type="form" :rows="5" />
      </div>
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <SkeletonLoader type="card" :rows="6" />
      </div>
    </div>

    <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Form Section (Kiri) -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Form Edit</h2>

        <form @submit.prevent="saveContact" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input
              v-model="contact.email"
              type="email"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
              placeholder="kontak@perusahaan.com"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
            <input
              v-model="contact.phone"
              type="text"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
              placeholder="+62 812 3456 7890"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
            <input
              v-model="contact.address"
              type="text"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
              placeholder="Alamat perusahaan"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tautan Maps</label>
            <input
              v-model="contact.map_url"
              type="url"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
              placeholder="https://maps.google.com/..."
            />
          </div>

          <div class="flex justify-end pt-4">
            <button
              type="submit"
              :disabled="isSaving"
              class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed transition font-medium"
            >
              <span v-if="!isSaving">Simpan Perubahan</span>
              <span v-else class="flex items-center">
                <i class="fa-solid fa-spinner animate-spin -ml-1 mr-2 text-white w-4 h-4"></i>
                Menyimpan...
              </span>
            </button>
          </div>
        </form>
      </div>

      <!-- Preview Section (Kanan) -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Pratinjau</h2>

        <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
          <div class="space-y-6">
            <div
              v-if="contact.email"
              class="flex items-start p-4 bg-white rounded-lg border border-gray-200"
            >
              <i class="fa-solid fa-envelope text-primary mr-3 mt-0.5 flex-shrink-0 w-6 h-6"></i>
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Email</h3>
                <p class="text-gray-900">{{ contact.email }}</p>
              </div>
            </div>

            <div
              v-if="contact.phone"
              class="flex items-start p-4 bg-white rounded-lg border border-gray-200"
            >
              <i class="fa-solid fa-phone text-primary mr-3 mt-0.5 flex-shrink-0 w-6 h-6"></i>
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Nomor WhatsApp</h3>
                <p class="text-gray-900">{{ contact.phone }}</p>
              </div>
            </div>

            <div
              v-if="contact.address"
              class="flex items-start p-4 bg-white rounded-lg border border-gray-200"
            >
              <i
                class="fa-solid fa-location-dot text-primary mr-3 mt-0.5 flex-shrink-0 w-6 h-6"
              ></i>
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Alamat</h3>
                <p class="text-gray-900">{{ contact.address }}</p>
              </div>
            </div>

            <div
              v-if="contact.map_url"
              class="flex items-start p-4 bg-white rounded-lg border border-gray-200"
            >
              <i class="fa-solid fa-map text-primary mr-3 mt-0.5 flex-shrink-0 w-6 h-6"></i>
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Tautan Maps</h3>
                <p class="text-gray-900 break-all">{{ contact.map_url }}</p>
              </div>
            </div>

            <!-- Empty state if no data -->
            <div
              v-if="!contact.email && !contact.phone && !contact.address && !contact.map_url"
              class="text-center py-12"
            >
              <i class="fa-solid fa-location-dot text-gray-300 mb-4 mx-auto w-16 h-16 text-4xl"></i>
              <p class="text-gray-500">Belum ada informasi kontak</p>
              <p class="text-gray-400 text-sm">
                Lengkapi form di sisi kiri untuk melihat pratinjau
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import type { Contact } from '@/services/api'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'

// State
const isLoading = ref(true)
const contact = ref<Partial<Contact>>({
  id: 0,
  address: '',
  phone: '',
  email: '',
  map_url: '',
})
const isSaving = ref(false)

// Methods
const loadContact = async () => {
  isLoading.value = true
  try {
    const data = await api.getContact()
    if (data.length > 0) {
      contact.value = { ...data[0] }
    }
  } catch (error: unknown) {
    console.error('Error fetching contact:', error)
  } finally {
    isLoading.value = false
  }
}

const saveContact = async () => {
  isSaving.value = true
  try {
    await api.updateContact(contact.value as Partial<Contact>)

    // Show success notification
    const successMsg = document.createElement('div')
    successMsg.className =
      'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    successMsg.textContent = 'Contact information updated successfully!'
    document.body.appendChild(successMsg)

    setTimeout(() => {
      document.body.removeChild(successMsg)
    }, 3000)
  } catch (error: unknown) {
    console.error('Error saving contact:', error)

    // Show error notification
    const errorMsg = document.createElement('div')
    errorMsg.className =
      'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    errorMsg.textContent = 'Error saving contact information. Please try again.'
    document.body.appendChild(errorMsg)

    setTimeout(() => {
      document.body.removeChild(errorMsg)
    }, 3000)
  } finally {
    isSaving.value = false
  }
}

// Load data on component mount
onMounted(() => {
  loadContact()
})
</script>
