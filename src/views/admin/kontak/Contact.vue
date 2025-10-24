<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="max-w-4xl mx-auto">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Contact Information Management</h1>
      <p class="text-gray-600 mt-2">Update the company's contact information</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
      <form @submit.prevent="saveContact">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input
              v-model="contact.email"
              type="email"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
              placeholder="company@example.com"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
            <input
              v-model="contact.telepon"
              type="text"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
              placeholder="+123 456 7890"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
            <input
              v-model="contact.alamat"
              type="text"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
              placeholder="Company address"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Maps Link</label>
            <input
              v-model="contact.maps_link"
              type="text"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
              placeholder="https://maps.google.com/..."
            />
          </div>
        </div>

        <div class="flex justify-end">
          <button
            type="submit"
            :disabled="isSaving"
            class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            <span v-if="!isSaving">Save Changes</span>
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
              Saving...
            </span>
          </button>
        </div>
      </form>
    </div>

    <!-- Preview Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-6">Preview</h2>

      <div class="border border-gray-200 rounded-lg p-6 bg-cream">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div v-if="contact.email">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Email</h3>
            <p class="text-gray-900">{{ contact.email }}</p>
          </div>

          <div v-if="contact.telepon">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Telepon</h3>
            <p class="text-gray-900">{{ contact.telepon }}</p>
          </div>

          <div v-if="contact.alamat">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Alamat</h3>
            <p class="text-gray-900">{{ contact.alamat }}</p>
          </div>

          <div v-if="contact.maps_link">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Maps Link</h3>
            <p class="text-gray-900">{{ contact.maps_link }}</p>
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
const contact = ref<Contact>({
  id: 0,
  alamat: '',
  telepon: '',
  email: '',
  maps_link: '',
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
