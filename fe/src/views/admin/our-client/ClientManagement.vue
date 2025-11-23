<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Client</h1>
      <p class="text-sm sm:text-base text-gray-600 mt-2">Kelola daftar client perusahaan Anda</p>
    </div>

    <!-- Action Bar -->
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
      <div class="flex-1 sm:max-w-md">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari client..."
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
        />
      </div>
      <button
        @click="openModal()"
        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-2 whitespace-nowrap"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span class="hidden sm:inline">Tambah Client</span>
        <span class="sm:hidden">Tambah</span>
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="flex justify-center items-center py-20">
      <div class="w-12 h-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
    </div>

    <!-- Clients Grid -->
    <div v-else-if="filteredClients.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="client in filteredClients"
        :key="client.id"
        class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group"
      >
        <!-- Client Logo -->
        <div class="relative h-32 bg-gray-100 overflow-hidden flex items-center justify-center p-4">
          <img
            v-if="client.logo_url"
            :src="client.logo_url"
            :alt="client.client_name"
            class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-300"
            @error="handleImageError"
          />
          <div v-else class="text-gray-400 text-sm">Tidak ada logo</div>
          <div class="absolute top-3 right-3 flex gap-2">
            <button
              @click="openModal(client)"
              class="p-2 bg-white/90 text-primary rounded-lg hover:bg-white transition shadow-sm"
              title="Edit"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </button>
            <button
              @click="confirmDelete(client)"
              class="p-2 bg-white/90 text-red-500 rounded-lg hover:bg-white transition shadow-sm"
              title="Hapus"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Client Info -->
        <div class="p-5">
          <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ client.client_name }}</h3>
          <p class="text-sm text-gray-600 line-clamp-2">{{ client.institution || 'Tidak ada institusi' }}</p>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-20">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <p class="text-gray-600 text-lg">Belum ada client</p>
      <button
        @click="openModal()"
        class="mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition"
      >
        Tambah Client Pertama
      </button>
    </div>

    <!-- Modal Form -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
      @click.self="closeModal"
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
          <h2 class="text-2xl font-bold text-gray-900">
            {{ editMode ? 'Edit Client' : 'Tambah Client Baru' }}
          </h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="handleSubmit" class="p-6 space-y-5">
          <!-- Nama Client -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Nama Client <span class="text-red-500">*</span>
            </label>
            <input
              v-model="formData.client_name"
              type="text"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              placeholder="Contoh: PT Sejahtera Indonesia"
            />
          </div>

          <!-- Institusi -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Institusi
            </label>
            <input
              v-model="formData.institution"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              placeholder="Nama institusi atau perusahaan"
            />
          </div>

          <!-- Logo -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Logo {{ !editMode ? '*' : '' }}
            </label>
            <ImageUpload
              v-model="logoFile"
              label="Upload Logo"
              accept="image/*"
              :max-size="104857600"
              :current-image-url="currentLogoUrl"
            />
          </div>

          <!-- Error Message -->
          <div v-if="errorMessage" class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
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
              <span v-if="!isSubmitting">{{ editMode ? 'Simpan Perubahan' : 'Tambah Client' }}</span>
              <span v-else class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
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
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Client?</h3>
          <p class="text-sm text-gray-500 mb-6">
            Apakah Anda yakin ingin menghapus client <strong>{{ clientToDelete?.client_name }}</strong>?
            Tindakan ini tidak dapat dibatalkan.
          </p>
          <div class="flex gap-3">
            <button
              @click="showDeleteModal = false"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
            >
              Batal
            </button>
            <button
              @click="deleteClient"
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
import api, { type OurClient } from '@/services/api'
import ImageUpload from '@/components/common/ImageUpload.vue'
import { useToast } from '@/composables/useToast'

const toast = useToast()

const clients = ref<OurClient[]>([])
const isLoading = ref(true)
const searchQuery = ref('')
const showModal = ref(false)
const showDeleteModal = ref(false)
const editMode = ref(false)
const isSubmitting = ref(false)
const isDeleting = ref(false)
const errorMessage = ref('')
const logoFile = ref<File | null>(null)
const currentLogoUrl = ref<string | null>(null)
const clientToDelete = ref<OurClient | null>(null)

const formData = ref({
  client_name: '',
  institution: '',
})

const editingId = ref<number | null>(null)

const filteredClients = computed(() => {
  if (!searchQuery.value) return clients.value
  const query = searchQuery.value.toLowerCase()
  return clients.value.filter(c =>
    c.client_name.toLowerCase().includes(query) ||
    (c.institution && c.institution.toLowerCase().includes(query))
  )
})

const fetchClients = async () => {
  try {
    isLoading.value = true
    const data = await api.getClients()
    clients.value = data
  } catch (error) {
    console.error('Error fetching clients:', error)
    toast.error('Gagal memuat data client')
  } finally {
    isLoading.value = false
  }
}

const openModal = (client?: OurClient) => {
  if (client) {
    editMode.value = true
    editingId.value = client.id
    formData.value = {
      client_name: client.client_name,
      institution: client.institution || '',
    }
    currentLogoUrl.value = client.logo_url || null
  } else {
    editMode.value = false
    editingId.value = null
    formData.value = {
      client_name: '',
      institution: '',
    }
    currentLogoUrl.value = null
  }
  logoFile.value = null
  errorMessage.value = ''
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  logoFile.value = null
  currentLogoUrl.value = null
}

const handleSubmit = async () => {
  try {
    isSubmitting.value = true
    errorMessage.value = ''

    const formDataToSend = new FormData()
    formDataToSend.append('client_name', formData.value.client_name)
    formDataToSend.append('institution', formData.value.institution)

    if (logoFile.value) {
      formDataToSend.append('logo_path', logoFile.value)
    }

    if (editMode.value && editingId.value) {
      await api.updateClient(editingId.value, formDataToSend)
      toast.success('Client berhasil diperbarui!')
    } else {
      if (!logoFile.value) {
        errorMessage.value = 'Logo wajib diisi'
        return
      }
      await api.createClient(formDataToSend)
      toast.success('Client berhasil ditambahkan!')
    }

    await fetchClients()
    closeModal()
  } catch (error) {
    console.error('Error saving client:', error)
    const axiosError = error as { response?: { data?: { message?: string } } }
    const message = axiosError.response?.data?.message || 'Gagal menyimpan client'
    errorMessage.value = message
    toast.error(message)
  } finally {
    isSubmitting.value = false
  }
}

const confirmDelete = (client: OurClient) => {
  clientToDelete.value = client
  showDeleteModal.value = true
}

const deleteClient = async () => {
  if (!clientToDelete.value) return

  try {
    isDeleting.value = true
    await api.deleteClient(clientToDelete.value.id)
    toast.success('Client berhasil dihapus!')
    await fetchClients()
    showDeleteModal.value = false
    clientToDelete.value = null
  } catch (error) {
    console.error('Error deleting client:', error)
    toast.error('Gagal menghapus client')
  } finally {
    isDeleting.value = false
  }
}

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement
  target.src = 'https://placehold.co/400x200/e5e7eb/6b7280?text=No+Logo'
}

onMounted(() => {
  fetchClients()
})
</script>
