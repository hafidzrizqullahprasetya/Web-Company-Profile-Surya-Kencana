<template>
  <AdminLayout>
    <div class="max-w-6xl mx-auto">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Management</h1>
        <p class="text-gray-600 mt-2">Manage admin accounts and permissions</p>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
          <div class="w-full sm:w-auto">
            <input 
              type="text" 
              v-model="searchQuery" 
              placeholder="Search admins..." 
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
            Add Admin
          </button>
        </div>

        <!-- Admin List -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="admin in filteredAdmins" :key="admin.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ admin.id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ admin.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ admin.email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button 
                    @click="openEditModal(admin)" 
                    class="text-primary hover:text-primary-dark mr-4 transition"
                  >
                    Edit
                  </button>
                  <button 
                    @click="deleteAdmin(admin.id)" 
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
            Showing {{ Math.min((currentPage - 1) * itemsPerPage + 1, admins.length) }} to 
            {{ Math.min(currentPage * itemsPerPage, admins.length) }} of {{ admins.length }} results
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

      <!-- Admin Modal -->
      <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-xl font-semibold text-gray-900">{{ isEditing ? 'Edit Admin' : 'Add Admin' }}</h3>
              <button @click="closeModal" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>

            <form @submit.prevent="submitAdmin" class="space-y-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input 
                  v-model="formData.name" 
                  type="text" 
                  required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                  placeholder="Admin name"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                  v-model="formData.email" 
                  type="email" 
                  required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                  placeholder="admin@example.com"
                />
              </div>

              <div v-if="!isEditing">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input 
                  v-model="formData.password" 
                  type="password" 
                  required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                  placeholder="Password"
                />
              </div>

              <div v-if="isEditing">
                <label class="block text-sm font-medium text-gray-700 mb-2">New Password (optional)</label>
                <input 
                  v-model="formData.password" 
                  type="password" 
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                  placeholder="Leave blank to keep current password"
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
                  <span v-if="!isSubmitting">{{ isEditing ? 'Update Admin' : 'Add Admin' }}</span>
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
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import AdminLayout from '@/components/admin/layouts/AdminLayout.vue'
import api, { type Admin } from '@/services/api'

// State
const admins = ref<Admin[]>([])
const showModal = ref(false)
const isEditing = ref(false)
const isSubmitting = ref(false)
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Form data
const formData = ref({
  id: 0,
  name: '',
  email: '',
  password: ''
})

// Computed
const filteredAdmins = computed(() => {
  let result = admins.value
  
  // Apply search filter
  if (searchQuery.value) {
    result = result.filter(admin => 
      admin.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      admin.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  }
  
  // Apply pagination
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return result.slice(start, end)
})

const totalPages = computed(() => {
  return Math.ceil(admins.value.length / itemsPerPage.value)
})

// Methods
const loadAdmins = async () => {
  try {
    const data = await api.getAdmins()
    admins.value = data
  } catch (error) {
    console.error('Error fetching admins:', error)
  }
}

const openAddModal = () => {
  isEditing.value = false
  formData.value = {
    id: 0,
    name: '',
    email: '',
    password: ''
  }
  showModal.value = true
}

const openEditModal = (admin: Admin) => {
  isEditing.value = true
  formData.value = {
    id: admin.id,
    name: admin.name,
    email: admin.email,
    password: '' // Don't show existing password
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
}

const submitAdmin = async () => {
  isSubmitting.value = true
  try {
    if (isEditing.value) {
      // For editing, we only update name and email
      const updateData: Partial<Admin> = {
        name: formData.value.name,
        email: formData.value.email
      }
      
      if (formData.value.password) {
        updateData.password = formData.value.password
      }
      
      await api.updateAdmin(formData.value.id, updateData)
      
      // Show success notification
      const successMsg = document.createElement('div')
      successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
      successMsg.textContent = 'Admin updated successfully!'
      document.body.appendChild(successMsg)
      
      setTimeout(() => {
        document.body.removeChild(successMsg)
      }, 3000)
    } else {
      await api.createAdmin(formData.value)
      
      // Show success notification
      const successMsg = document.createElement('div')
      successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
      successMsg.textContent = 'Admin created successfully!'
      document.body.appendChild(successMsg)
      
      setTimeout(() => {
        document.body.removeChild(successMsg)
      }, 3000)
    }
    await loadAdmins()
    closeModal()
  } catch (error: any) {
    console.error('Error saving admin:', error)
    
    // Show error notification
    const errorMsg = document.createElement('div')
    errorMsg.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    errorMsg.textContent = 'Error saving admin. Please try again.'
    document.body.appendChild(errorMsg)
    
    setTimeout(() => {
      document.body.removeChild(errorMsg)
    }, 3000)
  } finally {
    isSubmitting.value = false
  }
}

const deleteAdmin = async (id: number) => {
  if (!confirm('Are you sure you want to delete this admin? This action cannot be undone.')) return
  
  try {
    await api.deleteAdmin(id)
    await loadAdmins()
    
    // Show success notification
    const successMsg = document.createElement('div')
    successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    successMsg.textContent = 'Admin deleted successfully!'
    document.body.appendChild(successMsg)
    
    setTimeout(() => {
      document.body.removeChild(successMsg)
    }, 3000)
  } catch (error: any) {
    console.error('Error deleting admin:', error)
    
    // Show error notification
    const errorMsg = document.createElement('div')
    errorMsg.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    errorMsg.textContent = 'Error deleting admin. Please try again.'
    document.body.appendChild(errorMsg)
    
    setTimeout(() => {
      document.body.removeChild(errorMsg)
    }, 3000)
  }
}

// Load data on component mount
onMounted(() => {
  loadAdmins()
})
</script>