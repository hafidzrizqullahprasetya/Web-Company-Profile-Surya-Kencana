<template>
  <div class="max-w-4xl mx-auto">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Vision & Mission Management</h1>
      <p class="text-gray-600 mt-2">Update the company's vision and mission statements</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
      <form @submit.prevent="saveVisionMission">
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Vision</label>
          <textarea
            v-model="visionMission.vision"
            rows="5"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
            placeholder="Enter company vision..."
          ></textarea>
        </div>

        <div class="mb-8">
          <label class="block text-sm font-medium text-gray-700 mb-2">Mission</label>
          <textarea
            v-model="visionMission.mission"
            rows="5"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
            placeholder="Enter company mission..."
          ></textarea>
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

      <div class="space-y-8">
        <div class="p-6 bg-cream rounded-lg">
          <h3 class="text-lg font-semibold text-primary mb-3">Our Vision</h3>
          <p class="text-gray-700 leading-relaxed" v-if="visionMission.vision">
            {{ visionMission.vision }}
          </p>
          <p class="text-gray-400 italic" v-else>
            No vision statement yet. Enter a vision statement above to see it here.
          </p>
        </div>

        <div class="p-6 bg-cream rounded-lg">
          <h3 class="text-lg font-semibold text-primary mb-3">Our Mission</h3>
          <p class="text-gray-700 leading-relaxed" v-if="visionMission.mission">
            {{ visionMission.mission }}
          </p>
          <p class="text-gray-400 italic" v-else>
            No mission statement yet. Enter a mission statement above to see it here.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/services/api'

// State
const visionMission = ref({
  id: 0,
  vision: '',
  mission: '',
})
const isSaving = ref(false)

// Methods
const loadVisionMission = async () => {
  try {
    const data = await api.getVisionMission()
    if (data.length > 0) {
      visionMission.value = data[0]
    }
  } catch (error: unknown) {
    console.error('Error fetching vision mission:', error)
    // Keep default empty values
  }
}

const saveVisionMission = async () => {
  isSaving.value = true
  try {
    await api.updateVisionMission({
      vision: visionMission.value.vision,
      mission: visionMission.value.mission,
    })

    // Show success notification
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
