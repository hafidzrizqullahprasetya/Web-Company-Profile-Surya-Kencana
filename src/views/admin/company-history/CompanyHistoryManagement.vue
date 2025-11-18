<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Manajemen Riwayat Perusahaan</h1>
      <p class="text-gray-600 mt-2">Kelola timeline dan pencapaian perusahaan Anda</p>
    </div>

    <!-- Action Bar -->
    <div class="mb-6 flex justify-between items-center">
      <div class="flex-1 max-w-md">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari riwayat..."
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
        />
      </div>
      <button
        @click="openModal()"
        class="ml-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center gap-2"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Riwayat
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="flex justify-center items-center py-20">
      <div class="w-12 h-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
    </div>

    <!-- Timeline View -->
    <div v-else-if="filteredHistories.length > 0" class="relative">
      <!-- Timeline Line -->
      <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-300"></div>

      <!-- Timeline Items -->
      <div class="space-y-8">
        <div
          v-for="history in filteredHistories"
          :key="history.id"
          class="relative pl-20 group"
        >
          <!-- Year Badge -->
          <div class="absolute left-0 flex items-center justify-center w-16 h-16 bg-primary text-white rounded-full font-bold text-sm shadow-lg">
            {{ history.tahun }}
          </div>

          <!-- Content Card -->
          <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
            <!-- Image if exists -->
            <div v-if="history.image_url" class="relative h-48 bg-gray-200 overflow-hidden">
              <img
                :src="history.image_url"
                :alt="history.judul"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                @error="handleImageError"
              />
            </div>

            <!-- Content -->
            <div class="p-6">
              <div class="flex justify-between items-start mb-3">
                <h3 class="text-xl font-bold text-gray-900">{{ history.judul }}</h3>
                <div class="flex gap-2">
                  <button
                    @click="openModal(history)"
                    class="p-2 text-primary hover:bg-primary/10 rounded-lg transition"
                    title="Edit"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  <button
                    @click="confirmDelete(history)"
                    class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition"
                    title="Hapus"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </div>
              <p class="text-gray-600">{{ history.deskripsi }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-20">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <p class="text-gray-600 text-lg">Belum ada riwayat perusahaan</p>
      <button
        @click="openModal()"
        class="mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition"
      >
        Tambah Riwayat Pertama
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
            {{ editMode ? 'Edit Riwayat' : 'Tambah Riwayat Baru' }}
          </h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="handleSubmit" class="p-6 space-y-5">
          <!-- Tahun -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Tahun <span class="text-red-500">*</span>
            </label>
            <input
              v-model.number="formData.tahun"
              type="number"
              :min="1900"
              :max="new Date().getFullYear() + 10"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              placeholder="2024"
            />
          </div>

          <!-- Judul -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Judul <span class="text-red-500">*</span>
            </label>
            <input
              v-model="formData.judul"
              type="text"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              placeholder="Contoh: Pendirian Perusahaan"
            />
          </div>

          <!-- Deskripsi -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea
              v-model="formData.deskripsi"
              required
              rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              placeholder="Deskripsikan pencapaian atau peristiwa penting..."
            ></textarea>
          </div>

          <!-- Gambar Utama -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Gambar Utama (Opsional)
            </label>
            <ImageUpload
              v-model="imageFile"
              label="Upload Gambar Utama"
              accept="image/*"
              :max-size="104857600"
              :current-image-url="currentImageUrl"
            />
          </div>

          <!-- Gambar Album (Multiple Images) -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Gambar Album (Opsional)
            </label>

            <!-- Existing Images -->
            <div v-if="existingImages.length > 0" class="mb-3">
              <p class="text-sm text-gray-600 mb-2">Gambar yang sudah ada:</p>
              <div class="grid grid-cols-3 gap-2">
                <div
                  v-for="(img, index) in existingImages"
                  :key="index"
                  class="relative group"
                >
                  <img
                    :src="img"
                    class="w-full h-24 object-cover rounded-lg border-2 border-gray-200"
                  />
                  <button
                    type="button"
                    @click="removeExistingImage(index)"
                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <!-- New Images Upload -->
            <div>
              <input
                type="file"
                ref="multipleImagesInput"
                multiple
                accept="image/*"
                @change="handleMultipleImagesSelect"
                class="hidden"
              />
              <button
                type="button"
                @click="$refs.multipleImagesInput.click()"
                class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-primary/5 transition text-gray-600 hover:text-primary"
              >
                <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Gambar
              </button>
              <p class="text-xs text-gray-500 mt-1">Maks. 100MB per gambar</p>

              <!-- Preview New Images -->
              <div v-if="newImageFiles.length > 0" class="mt-3 grid grid-cols-3 gap-2">
                <div
                  v-for="(file, index) in newImageFiles"
                  :key="index"
                  class="relative group"
                >
                  <img
                    :src="getPreviewUrl(file)"
                    class="w-full h-24 object-cover rounded-lg border-2 border-primary"
                  />
                  <button
                    type="button"
                    @click="removeNewImage(index)"
                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
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
              <span v-if="!isSubmitting">{{ editMode ? 'Simpan Perubahan' : 'Tambah Riwayat' }}</span>
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
          <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Riwayat?</h3>
          <p class="text-sm text-gray-500 mb-6">
            Apakah Anda yakin ingin menghapus riwayat <strong>{{ historyToDelete?.judul }}</strong>?
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
              @click="deleteHistory"
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
import api, { type CompanyHistory } from '@/services/api'
import ImageUpload from '@/components/common/ImageUpload.vue'
import { useToast } from '@/composables/useToast'

const toast = useToast()

const histories = ref<CompanyHistory[]>([])
const isLoading = ref(true)
const searchQuery = ref('')
const showModal = ref(false)
const showDeleteModal = ref(false)
const editMode = ref(false)
const isSubmitting = ref(false)
const isDeleting = ref(false)
const errorMessage = ref('')
const imageFile = ref<File | null>(null)
const currentImageUrl = ref<string | null>(null)
const historyToDelete = ref<CompanyHistory | null>(null)

// Multiple images state
const newImageFiles = ref<File[]>([])
const existingImages = ref<string[]>([])
const imagesToDelete = ref<string[]>([])

const formData = ref({
  tahun: new Date().getFullYear(),
  judul: '',
  deskripsi: '',
})

const editingId = ref<number | null>(null)

const filteredHistories = computed(() => {
  if (!searchQuery.value) return histories.value
  const query = searchQuery.value.toLowerCase()
  return histories.value.filter(h =>
    h.judul.toLowerCase().includes(query) ||
    h.deskripsi.toLowerCase().includes(query) ||
    h.tahun.toString().includes(query)
  )
})

const fetchHistories = async () => {
  try {
    isLoading.value = true
    const data = await api.getCompanyHistories()
    histories.value = data
  } catch (error) {
    console.error('Error fetching histories:', error)
    toast.error('Gagal memuat data riwayat')
  } finally {
    isLoading.value = false
  }
}

const openModal = (history?: CompanyHistory) => {
  if (history) {
    editMode.value = true
    editingId.value = history.id
    formData.value = {
      tahun: history.tahun,
      judul: history.judul,
      deskripsi: history.deskripsi,
    }
    currentImageUrl.value = history.image_url || null
    existingImages.value = history.image_urls || []
  } else {
    editMode.value = false
    editingId.value = null
    formData.value = {
      tahun: new Date().getFullYear(),
      judul: '',
      deskripsi: '',
    }
    currentImageUrl.value = null
    existingImages.value = []
  }
  imageFile.value = null
  newImageFiles.value = []
  imagesToDelete.value = []
  errorMessage.value = ''
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  imageFile.value = null
  currentImageUrl.value = null
  newImageFiles.value = []
  existingImages.value = []
  imagesToDelete.value = []
}

// Multiple images handlers
const handleMultipleImagesSelect = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files) {
    const files = Array.from(target.files)
    const MAX_SIZE = 104857600 // 100MB

    const validFiles = files.filter(file => {
      if (file.size > MAX_SIZE) {
        toast.error(`File ${file.name} terlalu besar (maks. 100MB)`)
        return false
      }
      return true
    })

    newImageFiles.value = [...newImageFiles.value, ...validFiles]
  }
  // Reset input
  target.value = ''
}

const removeNewImage = (index: number) => {
  newImageFiles.value = newImageFiles.value.filter((_, i) => i !== index)
}

const removeExistingImage = (index: number) => {
  const imageUrl = existingImages.value[index]
  // Extract path from URL for deletion
  const pathMatch = imageUrl.match(/\/storage\/(.+)$/)
  if (pathMatch && pathMatch[1]) {
    imagesToDelete.value.push(pathMatch[1])
  }
  existingImages.value = existingImages.value.filter((_, i) => i !== index)
}

const getPreviewUrl = (file: File): string => {
  return URL.createObjectURL(file)
}

const handleSubmit = async () => {
  try {
    isSubmitting.value = true
    errorMessage.value = ''

    const formDataToSend = new FormData()
    formDataToSend.append('tahun', String(formData.value.tahun))
    formDataToSend.append('judul', formData.value.judul)
    formDataToSend.append('deskripsi', formData.value.deskripsi)

    if (imageFile.value) {
      formDataToSend.append('image', imageFile.value)
    }

    // Append multiple images
    if (newImageFiles.value.length > 0) {
      newImageFiles.value.forEach(file => {
        formDataToSend.append('images[]', file)
      })
    }

    // Append images to delete
    if (imagesToDelete.value.length > 0) {
      imagesToDelete.value.forEach(path => {
        formDataToSend.append('deleted_images[]', path)
      })
    }

    if (editMode.value && editingId.value) {
      await api.updateCompanyHistory(editingId.value, formDataToSend)
      toast.success('Riwayat berhasil diperbarui!')
    } else {
      await api.createCompanyHistory(formDataToSend)
      toast.success('Riwayat berhasil ditambahkan!')
    }

    await fetchHistories()
    closeModal()
  } catch (error) {
    console.error('Error saving history:', error)
    const axiosError = error as { response?: { data?: { message?: string } } }
    const message = axiosError.response?.data?.message || 'Gagal menyimpan riwayat'
    errorMessage.value = message
    toast.error(message)
  } finally {
    isSubmitting.value = false
  }
}

const confirmDelete = (history: CompanyHistory) => {
  historyToDelete.value = history
  showDeleteModal.value = true
}

const deleteHistory = async () => {
  if (!historyToDelete.value) return

  try {
    isDeleting.value = true
    await api.deleteCompanyHistory(historyToDelete.value.id)
    toast.success('Riwayat berhasil dihapus!')
    await fetchHistories()
    showDeleteModal.value = false
    historyToDelete.value = null
  } catch (error) {
    console.error('Error deleting history:', error)
    toast.error('Gagal menghapus riwayat')
  } finally {
    isDeleting.value = false
  }
}

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement
  target.src = 'https://placehold.co/600x300/e5e7eb/6b7280?text=No+Image'
}

onMounted(() => {
  fetchHistories()
})
</script>
