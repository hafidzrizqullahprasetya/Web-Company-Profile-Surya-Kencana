<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Pengaturan Situs</h1>
      <p class="text-gray-600">Kelola nama perusahaan, logo, dan judul bagian</p>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="flex items-center justify-center py-20">
      <div class="w-12 h-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
    </div>

    <!-- Form -->
    <div v-else class="bg-white rounded-lg shadow-lg p-8">
      <form @submit.prevent="handleSubmit" class="space-y-8">
        <!-- Company Info Section -->
        <div>
          <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Company Information</h2>

          <div class="space-y-4">
            <!-- Company Name -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
              <input
                v-model="formData.company_name"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                required
              />
            </div>

            <!-- Company Logo -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Company Logo</label>
              <ImageUpload
                v-model="logoFile"
                label="Upload Logo"
                accept="image/*"
                :max-size="104857600"
                :current-image-url="formData.company_logo_url"
              />
            </div>
          </div>
        </div>

        <!-- Hero Section -->
        <div>
          <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Hero Section</h2>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Hero Title</label>
              <input
                v-model="formData.hero_title"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Hero Subtitle</label>
              <input
                v-model="formData.hero_subtitle"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              />
            </div>
          </div>
        </div>

        <!-- Visi Misi Section -->
        <div>
          <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Vision & Mission Section</h2>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
              <input
                v-model="formData.visi_misi_label"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
              <textarea
                v-model="formData.visi_misi_title"
                rows="2"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              ></textarea>
            </div>
          </div>
        </div>

        <!-- Products Section -->
        <div>
          <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Products Section</h2>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
              <input
                v-model="formData.produk_label"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
              <textarea
                v-model="formData.produk_title"
                rows="2"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              ></textarea>
            </div>
          </div>
        </div>

        <!-- Clients Section -->
        <div>
          <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Clients Section</h2>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
              <input
                v-model="formData.clients_label"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
              <textarea
                v-model="formData.clients_title"
                rows="2"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              ></textarea>
            </div>
          </div>
        </div>

        <!-- Company History Section -->
        <div>
          <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Company History Section</h2>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
              <input
                v-model="formData.riwayat_label"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
              <textarea
                v-model="formData.riwayat_title"
                rows="2"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              ></textarea>
            </div>
          </div>
        </div>

        <!-- Testimonials Section -->
        <div>
          <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Testimonials Section</h2>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
              <input
                v-model="formData.testimoni_label"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
              <textarea
                v-model="formData.testimoni_title"
                rows="2"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              ></textarea>
            </div>
          </div>
        </div>

        <!-- Contact Section -->
        <div>
          <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Contact Section</h2>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
              <input
                v-model="formData.kontak_label"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
              <textarea
                v-model="formData.kontak_title"
                rows="2"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              ></textarea>
            </div>
          </div>
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
          {{ errorMessage }}
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-6 border-t">
          <button
            type="submit"
            :disabled="isSubmitting"
            class="px-8 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            <span v-if="!isSubmitting">Simpan Pengaturan</span>
            <span v-else class="flex items-center gap-2">
              <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api, { type SiteSetting } from '@/services/api'
import ImageUpload from '@/components/common/ImageUpload.vue'
import { useToast } from '@/composables/useToast'

const toast = useToast()

const isLoading = ref(true)
const isSubmitting = ref(false)
const errorMessage = ref('')
const logoFile = ref<File | null>(null)

const formData = ref<Partial<SiteSetting>>({
  company_name: '',
  hero_title: '',
  hero_subtitle: '',
  visi_misi_label: '',
  visi_misi_title: '',
  produk_label: '',
  produk_title: '',
  clients_label: '',
  clients_title: '',
  riwayat_label: '',
  riwayat_title: '',
  testimoni_label: '',
  testimoni_title: '',
  kontak_label: '',
  kontak_title: '',
  company_logo_url: null,
})

const loadSettings = async () => {
  try {
    isLoading.value = true
    const data = await api.getSiteSettings()
    formData.value = { ...data }
  } catch (error) {
    console.error('Error loading settings:', error)
    toast.error('Gagal memuat pengaturan situs')
  } finally {
    isLoading.value = false
  }
}

const handleSubmit = async () => {
  try {
    isSubmitting.value = true
    errorMessage.value = ''

    let response

    if (logoFile.value) {
      // If logo file is selected, use FormData
      const formDataToSend = new FormData()
      formDataToSend.append('company_logo', logoFile.value)

      // Append all text fields
      Object.keys(formData.value).forEach((key) => {
        if (key !== 'company_logo_url' && key !== 'company_logo' && key !== 'id') {
          const value = formData.value[key as keyof SiteSetting]
          if (value !== null && value !== undefined) {
            formDataToSend.append(key, String(value))
          }
        }
      })

      response = await api.updateSiteSettings(formDataToSend)
    } else {
      // Otherwise send JSON
      const dataToSend: Partial<SiteSetting> = { ...formData.value }
      delete dataToSend.company_logo_url
      delete dataToSend.company_logo
      delete dataToSend.id

      response = await api.updateSiteSettings(dataToSend)
    }

    formData.value = { ...response }
    logoFile.value = null
    toast.success('Pengaturan situs berhasil diperbarui!')
  } catch (error) {
    console.error('Error updating settings:', error)
    const axiosError = error as { response?: { data?: { message?: string } } }
    const message = axiosError.response?.data?.message || 'Gagal memperbarui pengaturan situs'
    errorMessage.value = message
    toast.error(message)
  } finally {
    isSubmitting.value = false
  }
}

onMounted(() => {
  loadSettings()
})
</script>
