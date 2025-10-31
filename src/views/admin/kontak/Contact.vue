<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Manajemen Informasi Kontak</h1>
      <p class="text-gray-600 mt-2">Perbarui informasi kontak perusahaan Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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
            <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
            <input
              v-model="contact.phone"
              type="text"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
              placeholder="+62 21 1234 5678"
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
            <div v-if="contact.email" class="flex items-start p-4 bg-white rounded-lg border border-gray-200">
              <svg class="w-6 h-6 text-primary mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Email</h3>
                <p class="text-gray-900">{{ contact.email }}</p>
              </div>
            </div>

            <div v-if="contact.phone" class="flex items-start p-4 bg-white rounded-lg border border-gray-200">
              <svg class="w-6 h-6 text-primary mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Telepon</h3>
                <p class="text-gray-900">{{ contact.phone }}</p>
              </div>
            </div>

            <div v-if="contact.address" class="flex items-start p-4 bg-white rounded-lg border border-gray-200">
              <svg class="w-6 h-6 text-primary mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Alamat</h3>
                <p class="text-gray-900">{{ contact.address }}</p>
              </div>
            </div>

            <div v-if="contact.map_url" class="flex items-start p-4 bg-white rounded-lg border border-gray-200">
              <svg class="w-6 h-6 text-primary mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
              </svg>
              <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Tautan Maps</h3>
                <p class="text-gray-900 break-all">{{ contact.map_url }}</p>
              </div>
            </div>

            <!-- Empty state if no data -->
            <div v-if="!contact.email && !contact.phone && !contact.address && !contact.map_url" class="text-center py-12">
              <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <p class="text-gray-500">Belum ada informasi kontak</p>
              <p class="text-gray-400 text-sm">Lengkapi form di sisi kiri untuk melihat pratinjau</p>
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

// State
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
  try {
    const data = await api.getContact()
    if (data.length > 0) {
      contact.value = { ...data[0] }
    }
  } catch (error: unknown) {
    console.error('Error fetching contact:', error)
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
