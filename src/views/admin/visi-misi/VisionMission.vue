<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <div class="mb-6 sm:mb-8">
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Visi & Misi</h1>
      <p class="text-sm sm:text-base text-gray-600 mt-2">Perbarui pernyataan visi dan misi perusahaan Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                  </svg>
                </button>
              </div>
              <button
                type="button"
                @click="addMissionItem"
                class="w-full p-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-primary hover:text-primary transition flex items-center justify-center gap-2"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4"
                  />
                </svg>
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

        <div class="space-y-6">
          <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
            <div class="flex items-center mb-4">
              <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center mr-3">
                <svg
                  class="w-5 h-5 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  />
                </svg>
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
                <svg
                  class="w-5 h-5 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                  />
                </svg>
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

// State
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
