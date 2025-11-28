<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6 pt-24 sm:pt-28">
    <div class="mb-6 sm:mb-8">
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Visi & Misi</h1>
      <p class="text-sm sm:text-base text-gray-600 mt-2">
        Perbarui pernyataan visi dan misi perusahaan Anda
      </p>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <SkeletonLoader type="form" :rows="6" />
      </div>
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <SkeletonLoader type="card" :rows="8" />
      </div>
    </div>

    <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Form Section (Kiri) -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Form Edit</h2>

        <form @submit.prevent="saveVisionMission" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Visi</label>
            <textarea
              v-model="visionMission.vision"
              rows="5"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
              placeholder="Masukkan visi perusahaan..."
            ></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Misi</label>
            <div class="space-y-3">
              <div
                v-for="(item, index) in missionItems"
                :key="index"
                class="flex items-start gap-2"
              >
                <input
                  v-model="missionItems[index]"
                  type="text"
                  class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                  :placeholder="`Poin misi ${index + 1}...`"
                />
                <button
                  type="button"
                  @click="removeMissionItem(index)"
                  class="p-3 text-red-600 hover:bg-red-50 rounded-lg transition"
                  :disabled="missionItems.length === 1"
                >
                  <i class="fa-solid fa-trash w-5 h-5"></i>
                </button>
              </div>
              <button
                type="button"
                @click="addMissionItem"
                class="w-full p-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-primary hover:text-primary transition flex items-center justify-center gap-2"
              >
                <i class="fa-solid fa-plus w-5 h-5"></i>
                <span>Tambah Poin Misi</span>
              </button>
            </div>
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

        <div class="space-y-6">
          <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
            <div class="flex items-center mb-4">
              <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center mr-3">
                <i class="fa-solid fa-eye w-5 h-5 text-white"></i>
              </div>
              <h3 class="text-lg font-semibold text-primary">Visi Kami</h3>
            </div>
            <p class="text-gray-700 leading-relaxed" v-if="visionMission.vision">
              {{ visionMission.vision }}
            </p>
            <p class="text-gray-400 italic" v-else>
              Belum ada pernyataan visi. Masukkan pernyataan visi di atas untuk melihatnya di sini.
            </p>
          </div>

          <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
            <div class="flex items-center mb-4">
              <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center mr-3">
                <i class="fa-solid fa-arrow-right w-5 h-5 text-white"></i>
              </div>
              <h3 class="text-lg font-semibold text-primary">Misi Kami</h3>
            </div>
            <ul class="space-y-2" v-if="missionItems.length > 0 && missionItems[0]">
              <li
                v-for="(item, index) in missionItems"
                :key="index"
                class="flex items-start gap-2 text-gray-700 leading-relaxed"
              >
                <span class="flex-shrink-0 w-2 h-2 bg-primary rounded-full mt-2"></span>
                <span>{{ item }}</span>
              </li>
            </ul>
            <p class="text-gray-400 italic" v-else>
              Belum ada pernyataan misi. Masukkan poin-poin misi di atas untuk melihatnya di sini.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api, { type VisionMission } from '@/services/api'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'

// State
const isLoading = ref(true)
const visionMission = ref<VisionMission>({
  id: 0,
  vision: '',
  mission: '',
})
const isSaving = ref(false)
const missionItems = ref<string[]>([''])

// Methods
const addMissionItem = () => {
  missionItems.value.push('')
}

const removeMissionItem = (index: number) => {
  if (missionItems.value.length > 1) {
    missionItems.value.splice(index, 1)
  }
}

const loadVisionMission = async () => {
  isLoading.value = true
  try {
    const data = await api.getVisionMission()
    if (data.length > 0 && data[0]) {
      visionMission.value = data[0]

      // Parse mission as JSON array if possible
      try {
        const parsed = JSON.parse(data[0].mission)
        if (Array.isArray(parsed) && parsed.length > 0) {
          missionItems.value = parsed
        } else {
          missionItems.value = [data[0].mission]
        }
      } catch {
        // If not JSON, treat as single item
        missionItems.value = [data[0].mission]
      }
    }
  } catch (error: unknown) {
    console.error('Error fetching vision mission:', error)
    // Keep default empty values
  } finally {
    isLoading.value = false
  }
}

const saveVisionMission = async () => {
  isSaving.value = true
  try {
    // Filter out empty items and convert to JSON
    const filteredItems = missionItems.value.filter((item) => item.trim() !== '')
    const missionJson = JSON.stringify(filteredItems)

    await api.updateVisionMission({
      vision: visionMission.value.vision,
      mission: missionJson,
    }) // Show success notification
    const successMsg = document.createElement('div')
    successMsg.className =
      'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    successMsg.textContent = 'Vision & Mission updated successfully!'
    document.body.appendChild(successMsg)

    setTimeout(() => {
      document.body.removeChild(successMsg)
    }, 3000)
  } catch (error: unknown) {
    console.error('Error saving vision mission:', error)

    // Show error notification
    const errorMsg = document.createElement('div')
    errorMsg.className =
      'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50'
    errorMsg.textContent = 'Error saving vision & mission. Please try again.'
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
  loadVisionMission()
})
</script>
