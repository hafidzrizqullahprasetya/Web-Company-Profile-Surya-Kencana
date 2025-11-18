<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-white overflow-hidden" id="kontak">
    <div class="container mx-auto px-4">
      <SectionTitle
        :label="siteSettings?.kontak_label"
        :title="siteSettings?.kontak_title"
        :icon="['fas', 'phone']"
        label-variant="default"
        title-variant="default"
      />

      <!-- Content -->
      <div class="max-w-6xl mx-auto">
        <!-- Contact Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
          <template v-if="isLoading || !contactInfo">
            <!-- Skeleton contact cards -->
            <div
              v-for="n in 3"
              :key="'contact-skeleton-' + n"
              class="bg-primary text-white p-8 rounded-xl shadow-xl flex flex-col items-center text-center gap-4"
            >
              <div
                class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center animate-pulse"
              ></div>
              <div class="w-24 h-5 bg-white/30 rounded animate-pulse mb-2"></div>
              <div class="w-full h-4 bg-white/20 rounded animate-pulse"></div>
              <div class="w-3/4 h-4 bg-white/20 rounded animate-pulse"></div>
            </div>
          </template>
          <template v-else>
            <div
              class="bg-primary text-white p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col items-center text-center gap-4"
            >
              <div
                class="w-16 h-16 bg-white/20 text-white rounded-full flex items-center justify-center"
              >
                <font-awesome-icon :icon="['fas', 'map-marker-alt']" class="w-8 h-8" />
              </div>
              <div>
                <h3
                  class="text-2xl font-epilogue font-bold uppercase tracking-wide text-white mb-3"
                >
                  Alamat
                </h3>
                <p class="text-white text-lg leading-relaxed">
                  {{ contactInfo?.address || 'N/A' }}
                </p>
              </div>
            </div>

            <div
              class="bg-primary text-white p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col items-center text-center gap-4"
            >
              <div
                class="w-16 h-16 bg-white/20 text-white rounded-full flex items-center justify-center"
              >
                <font-awesome-icon :icon="['fab', 'whatsapp']" class="w-8 h-8" />
              </div>
              <div>
                <h3
                  class="text-2xl font-epilogue font-bold uppercase tracking-wide text-white mb-3"
                >
                  WhatsApp
                </h3>
                <a
                  :href="whatsappUrl"
                  target="_blank"
                  class="text-white text-lg leading-relaxed hover:text-white/90 transition"
                >
                  {{ contactInfo?.phone || 'N/A' }}
                </a>
              </div>
            </div>

            <div
              class="bg-primary text-white p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col items-center text-center gap-4"
            >
              <div
                class="w-16 h-16 bg-white/20 text-white rounded-full flex items-center justify-center"
              >
                <font-awesome-icon :icon="['fas', 'envelope']" class="w-8 h-8" />
              </div>
              <div>
                <h3
                  class="text-2xl font-epilogue font-bold uppercase tracking-wide text-white mb-3"
                >
                  Email
                </h3>
                <a
                  :href="`mailto:${contactInfo?.email || ''}`"
                  class="text-white text-lg leading-relaxed hover:text-white/90 transition break-all"
                >
                  {{ contactInfo?.email || 'N/A' }}
                </a>
              </div>
            </div>
          </template>
        </div>

        <!-- Map Section -->
        <template v-if="isLoading || !contactInfo">
          <!-- Skeleton map -->
          <div
            class="w-full h-96 bg-gray-200 rounded-2xl shadow-2xl border-4 border-gray-300/10 animate-pulse"
          ></div>
        </template>
        <template v-else>
          <div v-if="contactInfo.map_url" class="w-full">
            <div class="rounded-2xl overflow-hidden shadow-2xl border-4 border-primary/10">
              <iframe
                :src="optimizedMapUrl"
                width="100%"
                height="500"
                style="border: 0"
                allow="accelerometer"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                sandbox="allow-scripts allow-same-origin allow-popups"
              ></iframe>
            </div>
          </div>
        </template>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import SectionTitle from './SectionTitle.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

// Use computed properties to extract specific data
const contactInfo = computed(() => {
  return landingPageData.value?.contact || null
})

const siteSettings = computed(() => {
  return landingPageData.value?.siteSettings || null
})

const optimizedMapUrl = computed(() => {
  if (!contactInfo.value?.map_url) return ''
  // Strip unnecessary parameters for faster loading
  return contactInfo.value.map_url.replace(/&g_ep=.*?(&|$)/, '')
})

const whatsappUrl = computed(() => {
  if (contactInfo.value?.phone) {
    // Remove any non-numeric characters except + at the beginning
    const phoneNumber = contactInfo.value.phone.replace(/[^\d+]/g, '')
    // Ensure the phone number starts with + or 62
    let formattedNumber = phoneNumber
    if (phoneNumber.startsWith('0')) {
      // If starts with 0, replace with 62 (Indonesia's country code)
      formattedNumber = '62' + phoneNumber.substring(1)
    } else if (phoneNumber.startsWith('8')) {
      // If starts with 8, add 62
      formattedNumber = '62' + phoneNumber
    }

    const message = encodeURIComponent('Halo, saya ingin bertanya lebih lanjut.')
    return `https://wa.me/${formattedNumber}?text=${message}`
  }
  return '#'
})

onMounted(() => {
  // Data is automatically fetched by useLandingPageData composable
})
</script>
