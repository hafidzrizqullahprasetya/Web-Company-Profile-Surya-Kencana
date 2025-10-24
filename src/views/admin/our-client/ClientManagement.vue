<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="max-w-6xl mx-auto">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Client Management</h1>
      <p class="text-gray-600 mt-2">Manage your company's clients</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="w-full sm:w-auto">
          <input
            type="text"
            v-model="searchQuery"
            placeholder="Search clients..."
            class="w-full sm:w-80 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
          />
        </div>
        <button
          @click="openAddModal"
          class="w-full sm:w-auto flex items-center justify-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Add Client
        </button>
      </div>

      <!-- Client List -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Institution</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="client in filteredClients" :key="client.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ client.id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ client.client_name }}</td>
              <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ client.institution || 'No institution' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <img v-if="client.logo_url" :src="client.logo_url" alt="Logo" class="w-10 h-10 object-cover rounded" />
                <span v-else>No logo</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button
                  @click="openEditModal(client)"
                  class="text-primary hover:text-primary-dark mr-4 transition"
                >
                  Edit
                </button>
                <button
                  @click="deleteClient(client.id)"
                  class="text-red-600 hover:text-red-900 transition"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-700">
          Showing {{ Math.min((currentPage - 1) * itemsPerPage + 1, clients.length) }} to
          {{ Math.min(currentPage * itemsPerPage, clients.length) }} of {{ clients.length }} results
        </div>
        <div class="flex space-x-2">
          <button
            @click="currentPage = Math.max(1, currentPage - 1)"
            :disabled="currentPage === 1"
            class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            Previous
          </button>
          <button
            @click="currentPage = Math.min(totalPages, currentPage + 1)"
            :disabled="currentPage === totalPages"
            class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            Next
          </button>
        </div>
      </div>
    </div>

    <!-- Client Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-900">{{ isEditing ? 'Edit Client' : 'Add Client' }}</h3>
            <button @click="closeModal" class="text-gray-400 hover:text-gray-500">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <form @submit.prevent="submitClient" class="space-y-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Client Name</label>
              <input
                v-model="formData.client_name"
                type="text"
                required
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                placeholder="Client name"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Institution</label>
              <input
                v-model="formData.institution"
                type="text"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                placeholder="Institution"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Logo Path</label>
              <input
                v-model="formData.logo_path"
                type="text"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                placeholder="Logo path"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Logo URL</label>
              <input
                v-model="formData.logo_url"
                type="text"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                placeholder="Logo URL"
              />
            </div>

            <div class="flex justify-end space-x-3 pt-4">
              <button
                type="button"
                @click="closeModal"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="isSubmitting"
                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed transition"
              >
                <span v-if="!isSubmitting">{{ isEditing ? 'Update Client' : 'Add Client' }}</span>
                <span v-else class="flex items-center">
                  <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Saving...
                </span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import api from '@/services/api'
import type { OurClient } from '@/services/api'

// State
const clients = ref<OurClient[]>([])
const showModal = ref(false)
const isEditing = ref(false)
const isSubmitting = ref(false)
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Form data
const formData = ref<OurClient>({
  id: 0,
  client_name: '',
  institution: '',
  logo_path: '',
  logo_url: ''
})

// Computed
const filteredClients = computed(() => {
  let result = clients.value

  // Apply search filter
  if (searchQuery.value) {
    result = result.filter(client =>
      client.client_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      (client.institution && client.institution.toLowerCase().includes(searchQuery.value.toLowerCase()))
    )
  }

  // Apply pagination
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return result.slice(start, end)
})

const totalPages = computed(() => {
  return Math.ceil(clients.value.length / itemsPerPage.value)
})

// Methods
const loadClients = async () => {
  try {
    const data = await api.getClients()
    clients.value = data
  } catch (error: unknown) {
    console.error('Error fetching clients:', error)
  }
}

const openAddModal = () => {
  isEditing.value = false
  formData.value = {
    id: 0,
    client_name: '',
    institution: '',
    logo_path: '',
    logo_url: ''
  }
  showModal.value = true
}

const openEditModal = (client: OurClient) => {
  isEditing.value = true
  formData.value = { ...client }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
}

const submitClient = async () => {
  isSubmitting.value = true
  try {
    if (isEditing.value) {
      await api.updateClient(formData.value.id, formData.value)

      // Show success notification
      const successMsg = document.createElement('div')
      successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
      successMsg.textContent = 'Client updated successfully!'
      document.body.appendChild(successMsg)

      setTimeout(() => {
        document.body.removeChild(successMsg)
      }, 3000)
    } else {
      await api.createClient(formData.value)

      // Show success notification
      const successMsg = document.createElement('div')
      successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
      successMsg.textContent = 'Client created successfully!'
      document.body.appendChild(successMsg)

      setTimeout(() => {
        document.body.removeChild(successMsg)
      }, 3000)
    }
    await loadClients()
    closeModal()
  } catch (error: unknown) {
    console.error('Error saving client:', error)

    // Show error notification
    const errorMsg = document.createElement('div')
    errorMsg.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    errorMsg.textContent = 'Error saving client. Please try again.'
    document.body.appendChild(errorMsg)

    setTimeout(() => {
      document.body.removeChild(errorMsg)
    }, 3000)
  } finally {
    isSubmitting.value = false
  }
}

const deleteClient = async (id: number) => {
  if (!confirm('Are you sure you want to delete this client?')) return

  try {
    await api.deleteClient(id)
    await loadClients()

    // Show success notification
    const successMsg = document.createElement('div')
    successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    successMsg.textContent = 'Client deleted successfully!'
    document.body.appendChild(successMsg)

    setTimeout(() => {
      document.body.removeChild(successMsg)
    }, 3000)
  } catch (error: unknown) {
    console.error('Error deleting client:', error)

    // Show error notification
    const errorMsg = document.createElement('div')
    errorMsg.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    errorMsg.textContent = 'Error deleting client. Please try again.'
    document.body.appendChild(errorMsg)

    setTimeout(() => {
      document.body.removeChild(errorMsg)
    }, 3000)
  }
}

// Load data on component mount
onMounted(() => {
  loadClients()
})
</script>
