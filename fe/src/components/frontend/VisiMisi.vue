<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-white overflow-hidden" id="visi-misi">
    <div class="container mx-auto px-4">
      <SectionTitle
        :label="siteSettings?.visi_misi_label"
        :title="siteSettings?.visi_misi_title"
        :icon="['fas', 'lightbulb']"
        label-variant="default"
        title-variant="default"
      />

      <!-- Main Content Grid -->
      <template v-if="isLoading || !visiMisi">
        <!-- Skeleton cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-20">
          <!-- Vision Skeleton (Left) -->
          <div class="relative p-12 bg-primary text-white rounded-xl shadow-xl overflow-hidden">
            <div
              class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-secondary to-secondary/30"
            ></div>
            <div class="mb-8">
              <div
                class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mb-6 animate-pulse"
              ></div>
              <div class="w-24 h-6 bg-white/30 rounded animate-pulse mb-3"></div>
              <div class="w-16 h-0.5 bg-white/30"></div>
            </div>
            <div>
              <div class="bg-white/20 h-4 rounded animate-pulse mb-2"></div>
              <div class="bg-white/20 h-4 rounded animate-pulse mb-2 w-5/6"></div>
              <div class="bg-white/20 h-4 rounded animate-pulse mb-2 w-4/6"></div>
              <div class="bg-white/20 h-4 rounded animate-pulse w-3/6"></div>
            </div>
          </div>

          <!-- Mission Skeleton (Right) -->
          <div class="relative p-12 bg-primary text-white rounded-xl shadow-xl overflow-hidden">
            <div class="absolute top-5 right-5 flex gap-1.5">
              <div class="w-2 h-2 bg-white/30 rounded-full animate-pulse"></div>
              <div class="w-2 h-2 bg-white/30 rounded-full animate-pulse"></div>
              <div class="w-2 h-2 bg-white/30 rounded-full animate-pulse"></div>
            </div>
            <div class="mb-8">
              <div
                class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mb-6 animate-pulse"
              ></div>
              <div class="w-24 h-6 bg-white/30 rounded animate-pulse mb-3"></div>
              <div class="w-16 h-0.5 bg-white/30"></div>
            </div>
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-white/30 rounded-full mt-2 animate-pulse"></div>
                <div class="flex-1 bg-white/20 h-4 rounded animate-pulse"></div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-white/30 rounded-full mt-2 animate-pulse"></div>
                <div class="flex-1 bg-white/20 h-4 rounded animate-pulse w-5/6"></div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-white/30 rounded-full mt-2 animate-pulse"></div>
                <div class="flex-1 bg-white/20 h-4 rounded animate-pulse w-4/6"></div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template v-else>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-20">
          <!-- Vision Card  -->
          <div
            class="relative p-12 bg-primary text-white rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl overflow-hidden"
          >
            <div
              class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-secondary to-secondary/30"
            ></div>
            <div class="mb-8">
              <div
                class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-6 transition-all duration-300 hover:scale-110"
              >
                <i class="fa-solid fa-eye text-3xl text-white"></i>
              </div>
              <h3 class="text-3xl font-epilogue font-bold uppercase tracking-wider mb-3 text-white">
                VISI KAMI
              </h3>
              <div class="w-16 h-0.5 bg-white"></div>
            </div>
            <div>
              <p class="text-2xl leading-relaxed text-white">
                {{ visiMisi.vision }}
              </p>
            </div>
          </div>

          <!-- Mission Card  -->
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
                class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-6 transition-all duration-300 hover:scale-110"
              >
                <i class="fa-solid fa-star text-3xl text-white"></i>
              </div>
              <h3 class="text-3xl font-epilogue font-bold uppercase tracking-wider mb-3 text-white">
                MISI KAMI
              </h3>
              <div class="w-16 h-0.5 bg-white"></div>
            </div>
            <div>
              <!-- Bullet Points for Mission -->
              <ul class="space-y-4">
                <li
                  v-for="(item, index) in missionItems"
                  :key="index"
                  class="flex items-start gap-3 text-lg leading-relaxed text-white"
                >
                  <span class="flex-shrink-0 w-2 h-2 bg-white rounded-full mt-2 opacity-80"></span>
                  <span>{{ item }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </template>

      <!-- CTA Button -->
      <div class="text-center">
        <BadgeButton :href="whatsappUrl" target="_blank">
          <span>Hubungi Kami</span>
          <i class="fa-solid fa-arrow-right w-5 h-5"></i>
        </BadgeButton>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import SectionTitle from './SectionTitle.vue'
import BadgeButton from './BadgeButton.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const visiMisi = computed(() => {
  if (!landingPageData.value?.visionMission || !landingPageData.value.visionMission.length) {
    return null
  }
  return landingPageData.value.visionMission[0]
})

const missionItems = computed(() => {
  if (!visiMisi.value?.mission) return []

  // Try to parse as JSON array first
  try {
    const parsed = JSON.parse(visiMisi.value.mission)
    if (Array.isArray(parsed)) {
      return parsed
    }
  } catch {
    // If not JSON, treat as plain text and return as single item
  }

  // Return as single item if not an array
  return [visiMisi.value.mission]
})

const siteSettings = computed(() => landingPageData.value?.siteSettings || null)
const contactInfo = computed(() => landingPageData.value?.contact || null)

const whatsappUrl = computed(() => {
  if (contactInfo.value?.phone) {
    const phoneNumber = contactInfo.value.phone.replace(/[^\d+]/g, '')
    let formattedNumber = phoneNumber
    if (phoneNumber.startsWith('0')) {
      formattedNumber = '62' + phoneNumber.substring(1)
    } else if (phoneNumber.startsWith('8')) {
      formattedNumber = '62' + phoneNumber
    }

    const message = encodeURIComponent(
      'Halo, saya ingin bertanya tentang visi dan misi perusahaan.',
    )
    return `https://wa.me/${formattedNumber}?text=${message}`
  }
  return '#'
})
</script>
