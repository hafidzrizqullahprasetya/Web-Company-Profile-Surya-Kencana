<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Admin</h1>
      <p class="text-sm sm:text-base text-gray-600 mt-2">Kelola akun admin sistem</p>
    </div>

    <!-- Action Bar -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
      <div class="flex-1 sm:max-w-md">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari admin..."
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
        />
      </div>
      <button
        @click="openModal()"
        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-2 whitespace-nowrap"
      >
        <font-awesome-icon :icon="['fas', 'plus']" class="w-5 h-5" />
        <span class="hidden sm:inline">Tambah Admin</span>
        <span class="sm:hidden">Tambah</span>
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="flex justify-center items-center py-20">
      <div
        class="w-12 h-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin"
      ></div>
    </div>

    <!-- Admins Grid -->
    <div
      v-else-if="filteredAdmins.length > 0"
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
    >
      <div
        v-for="admin in filteredAdmins"
        :key="admin.id"
        class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden"
      >
        <div class="p-6">
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                <font-awesome-icon :icon="['fas', 'user']" class="w-6 h-6 text-primary" />
              </div>
              <div>
                <h3 class="text-lg font-bold text-gray-900">
                  {{ admin.username || 'No Username' }}
                </h3>
              </div>
            </div>
            <div class="flex gap-2">
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700"
              >
                <font-awesome-icon v-if="showPassword" :icon="['fas', 'eye']" class="w-5 h-5" />
                <font-awesome-icon v-else :icon="['fas', 'eye-slash']" class="w-5 h-5" />
              </button>
              <button
                @click="confirmDelete(admin)"
                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition"
                title="Hapus"
              >
                <font-awesome-icon :icon="['fas', 'trash']" class="w-5 h-5" />
              </button>
            </div>
          </div>

          <div v-if="admin.created_at" class="space-y-2 text-sm">
            <div class="flex items-center text-gray-600">
              <font-awesome-icon :icon="['fas', 'clock']" class="w-4 h-4 mr-2" />
              <span>Dibuat: {{ formatDate(admin.created_at) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-20">
      <svg
        class="w-16 h-16 text-gray-400 mx-auto mb-4"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
        />
      </svg>
      <p class="text-gray-600 text-lg">Belum ada admin</p>
      <button
        @click="openModal()"
        class="mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition"
      >
        Tambah Admin Pertama
      </button>
    </div>

    <!-- Modal Form -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
      @click.self="closeModal"
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
          <h2 class="text-2xl font-bold text-gray-900">
            {{ editMode ? 'Edit Admin' : 'Tambah Admin Baru' }}
          </h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>

        <form @submit.prevent="handleSubmit" class="p-6 space-y-5">
          <!-- Username -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Username <span class="text-red-500">*</span>
            </label>
            <input
              v-model="formData.username"
              type="text"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              placeholder="Username admin"
            />
          </div>

          <!-- Password -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Password {{ editMode ? '(kosongkan jika tidak ingin mengubah)' : '' }}
              <span v-if="!editMode" class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input
                v-model="formData.password"
                :type="showPassword ? 'text' : 'password'"
                :required="!editMode"
                minlength="6"
                class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="Minimal 6 karakter"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700"
              >
                <font-awesome-icon v-if="showPassword" :icon="['fas', 'eye']" class="w-5 h-5" />
                <font-awesome-icon v-else :icon="['fas', 'eye-slash']" class="w-5 h-5" />
              </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
          </div>

          <!-- Error Message -->
          <div
            v-if="errorMessage"
            class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"
          >
            {{ errorMessage }}
          </div>

          <!-- Actions -->
          <div class="flex gap-3 pt-4">
            <button
              type="button"
              @click="closeModal"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
            >
              Batal
            </button>
            <button
              type="submit"
              :disabled="isSubmitting"
              class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed transition"
            >
              <span v-if="!isSubmitting">{{ editMode ? 'Simpan Perubahan' : 'Tambah Admin' }}</span>
              <span v-else class="flex items-center justify-center gap-2">
                <svg
                  class="animate-spin h-4 w-4"
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
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      v-if="showDeleteModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
      @click.self="showDeleteModal = false"
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
        <div class="text-center">
          <div
            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4"
          >
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
              />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Admin?</h3>
          <p class="text-sm text-gray-500 mb-6">
            Apakah Anda yakin ingin menghapus admin <strong>{{ adminToDelete?.username }}</strong
            >? Tindakan ini tidak dapat dibatalkan.
          </p>
          <div class="flex gap-3">
            <button
              @click="showDeleteModal = false"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
            >
              Batal
            </button>
            <button
              @click="deleteAdmin"
              :disabled="isDeleting"
              class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 transition"
            >
              {{ isDeleting ? 'Menghapus...' : 'Ya, Hapus' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import api, { type Admin } from '@/services/api'
import { useToast } from '@/composables/useToast'

const toast = useToast()

const admins = ref<Admin[]>([])
const isLoading = ref(true)
const searchQuery = ref('')
const showModal = ref(false)
const showDeleteModal = ref(false)
const editMode = ref(false)
const isSubmitting = ref(false)
const isDeleting = ref(false)
const errorMessage = ref('')
const adminToDelete = ref<Admin | null>(null)

const formData = ref({
  username: '',
  password: '',
})

const showPassword = ref(false)

const editingId = ref<number | null>(null)

const filteredAdmins = computed(() => {
  if (!searchQuery.value) return admins.value
  const query = searchQuery.value.toLowerCase()
  return admins.value.filter((a) => a.username && a.username.toLowerCase().includes(query))
})

const fetchAdmins = async () => {
  try {
    isLoading.value = true
    const data = await api.getAdmins()
    admins.value = data
  } catch (error) {
    console.error('Error fetching admins:', error)
    toast.error('Gagal memuat data admin')
  } finally {
    isLoading.value = false
  }
}

const openModal = (admin?: Admin) => {
  if (admin) {
    editMode.value = true
    editingId.value = admin.id
    formData.value = {
      username: admin.username || '',
      password: '', // Don't populate password for security
    }
  } else {
    editMode.value = false
    editingId.value = null
    formData.value = {
      username: '',
      password: '',
    }
  }
  errorMessage.value = ''
  showPassword.value = false // Reset password visibility when opening modal
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  showPassword.value = false // Reset password visibility when closing modal
}

const handleSubmit = async () => {
  try {
    isSubmitting.value = true
    errorMessage.value = ''

    const dataToSend: Partial<Admin> = {
      username: formData.value.username,
    }

    // Only include password if it's provided
    if (formData.value.password) {
      dataToSend.password = formData.value.password
    }

    if (editMode.value && editingId.value) {
      await api.updateAdmin(editingId.value, dataToSend)
      toast.success('Admin berhasil diperbarui!')
    } else {
      // Password required for new admin
      if (!formData.value.password) {
        errorMessage.value = 'Password wajib diisi untuk admin baru'
        return
      }
      dataToSend.password = formData.value.password
      await api.createAdmin(dataToSend as Omit<Admin, 'id'>)
      toast.success('Admin berhasil ditambahkan!')
    }

    await fetchAdmins()
    closeModal()
  } catch (error) {
    console.error('Error saving admin:', error)
    const axiosError = error as { response?: { data?: { message?: string } } }
    const message = axiosError.response?.data?.message || 'Gagal menyimpan admin'
    errorMessage.value = message
    toast.error(message)
  } finally {
    isSubmitting.value = false
  }
}

const confirmDelete = (admin: Admin) => {
  adminToDelete.value = admin
  showDeleteModal.value = true
}

const deleteAdmin = async () => {
  if (!adminToDelete.value) return

  try {
    isDeleting.value = true
    await api.deleteAdmin(adminToDelete.value.id)
    toast.success('Admin berhasil dihapus!')
    await fetchAdmins()
    showDeleteModal.value = false
    adminToDelete.value = null
  } catch (error) {
    console.error('Error deleting admin:', error)
    toast.error('Gagal menghapus admin')
  } finally {
    isDeleting.value = false
  }
}

const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

onMounted(() => {
  fetchAdmins()
})
</script>
