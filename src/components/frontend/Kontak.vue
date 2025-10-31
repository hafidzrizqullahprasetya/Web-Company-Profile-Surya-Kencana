<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-white overflow-hidden" id="kontak">
    <div class="container mx-auto px-4">
      <div class="text-center mb-20">
        <div class="inline-block mb-6">
          <span
            class="bg-primary text-white px-6 py-3 text-xs font-semibold uppercase tracking-widest"
          >
            {{ siteSettings?.kontak_label || 'HUBUNGI KAMI' }}
          </span>
        </div>
        <h2
          v-html="siteSettings?.kontak_title || 'JANGAN<br><span class=\'text-secondary relative\'>RAGU<div class=\'absolute -bottom-1 left-0 w-full h-3 bg-primary -z-10\'></div></span><br>MENGHUBUNGI KAMI.'"
          class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-epilogue font-bold text-secondary leading-tight uppercase tracking-wide mb-10"
        ></h2>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="flex flex-col items-center justify-center py-16 text-center">
        <div
          class="w-12 h-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin mb-4"
        ></div>
        <p class="text-secondary text-base">Loading contact information...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="flex flex-col items-center justify-center py-16 text-center">
        <div class="mb-4">
          <svg class="w-16 h-16 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <p class="text-red-500 text-base mb-4 font-medium">{{ error }}</p>
        <button
          @click="retryFetch"
          class="bg-primary text-white px-6 py-3 text-sm font-semibold rounded-lg transition-all duration-300 hover:bg-primary/90"
        >
          Coba Lagi
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="!contactInfo" class="flex flex-col items-center justify-center py-16 text-center">
        <div class="mb-4">
          <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
        </div>
        <p class="text-gray-600 text-base">Contact information not available yet</p>
      </div>

      <!-- Content -->
      <div v-else class="max-w-6xl mx-auto">
        <!-- Contact Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
          <div
            class="bg-primary text-white p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col items-center text-center gap-4"
          >
            <div
              class="w-16 h-16 bg-white/20 text-white rounded-full flex items-center justify-center"
            >
              <i-lucide:map-pin class="w-8 h-8" />
            </div>
            <div>
              <h3 class="text-lg font-epilogue font-bold uppercase tracking-wide text-white mb-2">
                Alamat
              </h3>
              <p class="text-white/90 text-sm leading-relaxed">{{ contactInfo.address || 'N/A' }}</p>
            </div>
          </div>

          <div
            class="bg-primary text-white p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col items-center text-center gap-4"
          >
            <div
              class="w-16 h-16 bg-white/20 text-white rounded-full flex items-center justify-center"
            >
              <i-lucide:phone class="w-8 h-8" />
            </div>
            <div>
              <h3 class="text-lg font-epilogue font-bold uppercase tracking-wide text-white mb-2">
                Telepon
              </h3>
              <a :href="`tel:${contactInfo.phone}`" class="text-white/90 text-sm leading-relaxed hover:text-white transition">
                {{ contactInfo.phone || 'N/A' }}
              </a>
            </div>
          </div>

          <div
            class="bg-primary text-white p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col items-center text-center gap-4"
          >
            <div
              class="w-16 h-16 bg-white/20 text-white rounded-full flex items-center justify-center"
            >
              <i-lucide:mail class="w-8 h-8" />
            </div>
            <div>
              <h3 class="text-lg font-epilogue font-bold uppercase tracking-wide text-white mb-2">
                Email
              </h3>
              <a :href="`mailto:${contactInfo.email}`" class="text-white/90 text-sm leading-relaxed hover:text-white transition break-all">
                {{ contactInfo.email || 'N/A' }}
              </a>
            </div>
          </div>
        </div>

        <!-- Map Section -->
        <div v-if="contactInfo.map_url" class="w-full">
          <div class="rounded-2xl overflow-hidden shadow-2xl border-4 border-primary/10">
            <iframe
              :src="contactInfo.map_url"
              width="100%"
              height="500"
              style="border: 0"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
          </div>
        </div>

        <!-- No Map State -->
        <div v-else class="w-full p-16 bg-gray-100 rounded-2xl text-center">
          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
          </svg>
          <p class="text-gray-600">Map location not configured</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api, { type Contact, type SiteSetting } from '@/services/api'

const contactInfo = ref<Contact | null>(null)
const siteSettings = ref<SiteSetting | null>(null)
const isLoading = ref(true)
const error = ref<string | null>(null)

const fetchContact = async () => {
  try {
    isLoading.value = true
    error.value = null
    const [contactData, settingsData] = await Promise.all([
      api.getContact(),
      api.getSiteSettings()
    ])
    if (contactData && contactData.length > 0 && contactData[0]) {
      contactInfo.value = contactData[0]
    } else {
      error.value = null // Not an error, just empty
      contactInfo.value = null
    }
    siteSettings.value = settingsData
  } catch (err) {
    console.error('Error fetching contact:', err)
    error.value = 'Failed to load contact information'
  } finally {
    isLoading.value = false
  }
}

const retryFetch = () => {
  fetchContact()
}

onMounted(() => {
  fetchContact()
})
</script>
