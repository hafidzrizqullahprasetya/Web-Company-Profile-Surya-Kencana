<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6 pt-24 sm:pt-28">
    <div class="mb-6 sm:mb-8">
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Hero Section</h1>
      <p class="text-sm sm:text-base text-gray-600 mt-2">
        Kelola tampilan utama halaman depan website Anda
      </p>
    </div>

    <!-- Skeleton Loading -->
    <div v-if="isLoading" class="space-y-6">
      <SkeletonLoader type="card" />
      <SkeletonLoader type="form" :rows="6" />
    </div>

    <div v-else class="space-y-6">
      <!-- Background Images Slider Section -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Gambar Background Slider</h2>
        <p class="text-sm text-gray-600 mb-4">
          Upload beberapa gambar untuk slider hero section (Max 100MB per gambar)
        </p>

        <!-- Existing Backgrounds -->
        <div v-if="existingBackgrounds.length > 0" class="mb-6">
          <h3 class="text-sm font-medium text-gray-700 mb-3">Gambar Saat Ini:</h3>
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div v-for="(bg, index) in existingBackgrounds" :key="index" class="relative group">
              <img
                :src="getBackgroundUrl(bg)"
                :alt="`Background ${index + 1}`"
                class="w-full h-32 object-cover rounded-lg border border-gray-200"
              />
              <button
                type="button"
                @click="removeExistingBackground(index)"
                class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                title="Hapus gambar"
              >
                <i class="fa-solid fa-xmark w-4 h-4"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Upload New Backgrounds -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2"> Tambah Gambar Baru </label>
          <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
            <input
              ref="fileInput"
              type="file"
              multiple
              accept="image/jpeg,image/png,image/jpg,image/webp"
              @change="handleFileSelect"
              class="hidden"
            />
            <button
              type="button"
              @click="$refs.fileInput.click()"
              class="w-full flex flex-col items-center justify-center text-gray-600 hover:text-primary transition"
            >
              <i class="fa-solid fa-cloud-arrow-up w-12 h-12 mb-2 text-3xl"></i>
              <span class="text-sm font-medium">Klik untuk upload gambar</span>
              <span class="text-xs text-gray-500 mt-1">Maks. 100MB per gambar</span>
            </button>
          </div>

          <!-- Preview New Uploads -->
          <div v-if="newBackgroundFiles.length > 0" class="mt-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Preview Gambar Baru:</h4>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
              <div v-for="(file, index) in newBackgroundFiles" :key="index" class="relative group">
                <img
                  :src="getPreviewUrl(file)"
                  :alt="`Preview ${index + 1}`"
                  class="w-full h-32 object-cover rounded-lg border border-gray-200"
                />
                <button
                  type="button"
                  @click="removeNewBackground(index)"
                  class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                  title="Hapus gambar"
                >
                  <i class="fa-solid fa-xmark w-4 h-4"></i>
                </button>
                <span
                  class="absolute bottom-2 left-2 text-xs bg-black/50 text-white px-2 py-1 rounded"
                >
                  {{ formatFileSize(file.size) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Hero Content Form -->
      <form
        @submit.prevent="saveHero"
        class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
      >
        <h2 class="text-xl font-bold text-gray-900 mb-6">Konten Hero Section</h2>
        <p class="text-sm text-gray-600 mb-6">
          Semua field bersifat opsional. Isi hanya yang diperlukan.
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Kolom Kiri -->
          <div class="space-y-4">
            <!-- Lokasi -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
              <input
                v-model="hero.location"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="Jakarta, Indonesia"
              />
            </div>

            <!-- Judul -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Judul Utama</label>
              <textarea
                v-model="hero.title"
                rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="MESIN TERBAIK UNTUK INDUSTRI ANDA"
              ></textarea>
            </div>
          </div>

          <!-- Kolom Kanan - Statistik -->
          <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-900">Statistik</h3>

            <!-- Jumlah Mesin -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Mesin</label>
              <input
                v-model.number="hero.machines"
                type="number"
                min="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="500"
              />
            </div>

            <!-- Jumlah Klien -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Klien</label>
              <input
                v-model.number="hero.clients"
                type="number"
                min="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="200"
              />
            </div>

            <!-- Jumlah Pelanggan -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Pelanggan</label>
              <input
                v-model.number="hero.customers"
                type="number"
                min="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="5000"
              />
            </div>

            <!-- Tahun Pengalaman -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Pengalaman</label>
              <input
                v-model.number="hero.experience_years"
                type="number"
                min="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="15"
              />
            </div>

            <!-- Tahun Kepercayaan -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Kepercayaan</label>
              <input
                v-model.number="hero.trust_years"
                type="number"
                min="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="20"
              />
            </div>
          </div>
        </div>

        <!-- Error Message -->
        <div
          v-if="errorMessage"
          class="mt-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"
        >
          {{ errorMessage }}
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end mt-6">
          <button
            type="submit"
            :disabled="isSaving"
            class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            <span v-if="!isSaving">Simpan Perubahan</span>
            <span v-else class="flex items-center gap-2">
              <i class="fa-solid fa-spinner animate-spin w-4 h-4"></i>
              Menyimpan...
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
import api from '@/services/api'
import type { Hero } from '@/services/api'
import { useToast } from '@/composables/useToast'

const toast = useToast()

const hero = ref<Partial<Hero>>({
  location: '',
  title: '',
  machines: 0,
  clients: 0,
  customers: 0,
  experience_years: 0,
  trust_years: 0,
})

const existingBackgrounds = ref<string[]>([])
const backgroundsToDelete = ref<string[]>([])
const newBackgroundFiles = ref<File[]>([])
const fileInput = ref()
const isLoading = ref(true)
const isSaving = ref(false)
const errorMessage = ref('')

const MAX_FILE_SIZE = 104857600 // 100MB in bytes

const loadHero = async () => {
  try {
    isLoading.value = true
    const data = await api.getHero()
    if (data.length > 0) {
      hero.value = { ...data[0] }
      existingBackgrounds.value = data[0].backgrounds || []
    }
  } catch (error) {
    console.error('Error fetching hero:', error)
    toast.error('Gagal memuat data hero section')
  } finally {
    isLoading.value = false
  }
}

const handleFileSelect = (event: Event) => {
  const target = event.target as HTMLInputElement
  const files = Array.from(target.files || [])

  // Validate file sizes
  const validFiles = files.filter((file) => {
    if (file.size > MAX_FILE_SIZE) {
      toast.error(`File ${file.name} terlalu besar (maks. 100MB)`)
      return false
    }
    return true
  })

  newBackgroundFiles.value = [...newBackgroundFiles.value, ...validFiles]
}

const removeExistingBackground = (index: number) => {
  const pathToDelete = existingBackgrounds.value[index]
  backgroundsToDelete.value.push(pathToDelete)
  existingBackgrounds.value.splice(index, 1)
}

const removeNewBackground = (index: number) => {
  newBackgroundFiles.value.splice(index, 1)
}

const getBackgroundUrl = (path: string): string => {
  if (path.startsWith('http://') || path.startsWith('https://')) {
    return path
  }
  const cdnUrl =
    import.meta.env.VITE_CDN_URL || 'https://pub-2fb44babc7a4420e8fa728891ac101ef.r2.dev'
  return `${cdnUrl}/${path}`
}

const getPreviewUrl = (file: File): string => {
  return URL.createObjectURL(file)
}

const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i]
}

const saveHero = async () => {
  try {
    isSaving.value = true
    errorMessage.value = ''

    const formData = new FormData()

    // Add hero data (only if provided)
    if (hero.value.location) formData.append('location', hero.value.location)
    if (hero.value.title) formData.append('title', hero.value.title)
    if (hero.value.machines !== undefined) formData.append('machines', String(hero.value.machines))
    if (hero.value.clients !== undefined) formData.append('clients', String(hero.value.clients))
    if (hero.value.customers !== undefined)
      formData.append('customers', String(hero.value.customers))
    if (hero.value.experience_years !== undefined)
      formData.append('experience_years', String(hero.value.experience_years))
    if (hero.value.trust_years !== undefined)
      formData.append('trust_years', String(hero.value.trust_years))

    // Add new background images
    if (newBackgroundFiles.value.length > 0) {
      newBackgroundFiles.value.forEach((file) => {
        formData.append('backgrounds[]', file)
      })
    }

    // Add backgrounds to delete
    if (backgroundsToDelete.value.length > 0) {
      backgroundsToDelete.value.forEach((path) => {
        formData.append('deleted_backgrounds[]', path)
      })
    }

    await api.updateHero(formData)
    toast.success('Hero section berhasil diperbarui!')

    // Reload data and reset
    await loadHero()
    newBackgroundFiles.value = []
    backgroundsToDelete.value = []
  } catch (error) {
    console.error('Error saving hero:', error)
    const axiosError = error as { response?: { data?: { message?: string } } }
    const message = axiosError.response?.data?.message || 'Gagal menyimpan hero section'
    errorMessage.value = message
    toast.error(message)
  } finally {
    isSaving.value = false
  }
}

onMounted(() => {
  loadHero()
})
</script>
