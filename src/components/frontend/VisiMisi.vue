<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-white overflow-hidden" id="visi-misi">
    <div class="container mx-auto px-4">
      <div class="text-center mb-20">
        <div class="inline-block mb-6">
          <span
            class="bg-primary text-cream-light px-6 py-3 text-xs font-semibold uppercase tracking-widest rounded-md"
          >
            TENTANG KAMI
          </span>
        </div>
        <h2
          class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-epilogue font-bold text-secondary leading-tight uppercase tracking-wide mb-10"
        >
          CREATE YOUR STORY IN A PLACE<br />
          WHERE
          <span class="text-secondary relative"
            >DREAMS
            <div class="absolute -bottom-1 left-0 w-full h-3 bg-primary -z-10"></div
          ></span>
          AND REALITY<br />
          MERGE.
        </h2>
      </div>

      <div v-if="isLoading" class="flex flex-col items-center justify-center py-16 text-center">
        <div
          class="w-10 h-10 border-4 border-primary/30 border-t-primary rounded-full animate-spin mb-4"
        ></div>
        <p class="text-gray-600 text-base">Loading vision and mission...</p>
      </div>

      <div v-else-if="error" class="flex flex-col items-center justify-center py-16 text-center">
        <p class="text-red-500 text-base mb-4 font-medium">{{ error }}</p>
        <button
          @click="retryFetch"
          class="bg-primary text-secondary px-6 py-3 text-sm font-semibold rounded-md transition-all duration-300 hover:bg-primary-dark hover:-translate-y-0.5"
        >
          Retry
        </button>
      </div>

      <!-- Main Content Grid -->
      <div v-else-if="visiMisi" class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-20">
        <div
          class="relative p-12 bg-primary text-white rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl overflow-hidden"
        >
          <div
            class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-secondary to-secondary/30"
          ></div>
          <div class="mb-8">
            <div
              class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mb-6 transition-all duration-300 hover:scale-110"
            >
              <i-lucide:star class="w-7 h-7" style="color: white" />
            </div>
            <h3 class="text-2xl font-epilogue font-bold uppercase tracking-wider mb-3 text-white">
              MISI KAMI
            </h3>
            <div class="w-16 h-0.5 bg-white"></div>
          </div>
          <div>
            <p class="text-base leading-relaxed text-white/90">
              {{ visiMisi.mission }}
            </p>
          </div>
        </div>

        <!-- Vision Card (Right) -->
        <div
          class="relative p-12 bg-primary text-white rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl overflow-hidden"
        >
          <div class="absolute top-5 right-5 flex gap-1.5">
            <span class="w-2 h-2 bg-white rounded-full opacity-60"></span>
            <span class="w-2 h-2 bg-white rounded-full opacity-60"></span>
            <span class="w-2 h-2 bg-white rounded-full opacity-60"></span>
          </div>
          <div class="mb-8">
            <div
              class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mb-6 transition-all duration-300 hover:scale-110"
            >
              <i-lucide:eye class="w-7 h-7" style="color: white" />
            </div>
            <h3 class="text-2xl font-epilogue font-bold uppercase tracking-wider mb-3 text-white">
              VISI KAMI
            </h3>
            <div class="w-16 h-0.5 bg-white"></div>
          </div>
          <div>
            <p class="text-base leading-relaxed text-white/90">
              {{ visiMisi.vision }}
            </p>
          </div>
        </div>
      </div>

      <!-- CTA Button -->
      <div class="text-center">
        <router-link
          to="/contact"
          class="inline-flex items-center bg-primary text-cream px-10 py-5 text-base font-semibold uppercase tracking-wide rounded-lg shadow-soft transition-all duration-300 hover:bg-primary-dark hover:-translate-y-1 hover:shadow-lg gap-3"
        >
          <span>Hubungi Kami</span>
          <i-lucide:arrow-right class="w-5 h-5" />
        </router-link>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api, { type VisionMission } from '@/services/api'

const visiMisi = ref<VisionMission | null>(null)
const isLoading = ref(true)
const error = ref<string | null>(null)

const fetchVisionMission = async () => {
  try {
    isLoading.value = true
    error.value = null
    const data = await api.getVisionMission()
    if (data.length > 0) {
      visiMisi.value = data[0]
    } else {
      error.value = 'Vision and mission data not found'
    }
  } catch (err) {
    console.error('Error fetching visi misi:', err)
    const message =
      (err as { response?: { data?: { message?: string } } })?.response?.data?.message ||
      'Failed to load data'
    error.value = message
  } finally {
    isLoading.value = false
  }
}

const retryFetch = () => {
  fetchVisionMission()
}

onMounted(() => {
  fetchVisionMission()
})
</script>
