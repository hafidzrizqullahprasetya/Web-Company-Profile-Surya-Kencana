<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <section class="relative py-10 md:py-12 lg:py-14 bg-white overflow-hidden scroll-mt-[65px] md:scroll-mt-[65px]"
        id="kontak">
        <div class="container mx-auto px-4">
            <SectionTitle :label="siteSettings?.kontak_label" :title="siteSettings?.kontak_title"
                :icon="['fas', 'phone']" label-variant="default" title-variant="default"
                margin-bottom="mb-6 md:mb-8 lg:mb-10" />

            <!-- Content -->
            <div class="max-w-7xl mx-auto">
                <!-- Contact Info Cards - Horizontal 3 Columns -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5 lg:gap-6 mb-8 md:mb-10 lg:mb-12">
                    <template v-if="isLoading || !contactInfo">
                        <div v-for="n in 3" :key="'contact-skeleton-' + n"
                            class="bg-primary text-white p-5 md:p-6 rounded-xl shadow-lg flex flex-col items-center text-center gap-3">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 rounded-full animate-pulse"></div>
                            <div class="w-20 h-4 bg-white/30 rounded animate-pulse mb-2"></div>
                            <div class="w-full h-3 bg-white/20 rounded animate-pulse"></div>
                            <div class="w-4/5 h-3 bg-white/20 rounded animate-pulse"></div>
                        </div>
                    </template>
                    <template v-else>
                        <div
                            class="bg-primary text-white p-5 md:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col items-center text-center gap-3">
                            <div
                                class="w-12 h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 bg-white/20 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fa-solid fa-map-marker-alt text-lg md:text-xl lg:text-2xl text-white"></i>
                            </div>
                            <div>
                                <h3
                                    class="text-lg md:text-xl font-epilogue font-bold uppercase tracking-wide text-white mb-2">
                                    Alamat
                                </h3>
                                <p class="text-white text-sm md:text-base leading-snug">
                                    {{ contactInfo?.address || 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div
                            class="bg-primary text-white p-5 md:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col items-center text-center gap-3">
                            <div
                                class="w-12 h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 bg-white/20 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fa-brands fa-whatsapp text-lg md:text-xl lg:text-2xl text-white"></i>
                            </div>
                            <div>
                                <h3
                                    class="text-lg md:text-xl font-epilogue font-bold uppercase tracking-wide text-white mb-2">
                                    WhatsApp
                                </h3>
                                <a :href="whatsappUrl" target="_blank"
                                    class="text-white text-sm md:text-base leading-snug hover:text-white/90 transition break-all">
                                    {{ contactInfo?.phone || 'N/A' }}
                                </a>
                            </div>
                        </div>

                        <div
                            class="bg-primary text-white p-5 md:p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col items-center text-center gap-3">
                            <div
                                class="w-12 h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 bg-white/20 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fa-solid fa-envelope text-lg md:text-xl lg:text-2xl text-white"></i>
                            </div>
                            <div>
                                <h3
                                    class="text-lg md:text-xl font-epilogue font-bold uppercase tracking-wide text-white mb-2">
                                    Email
                                </h3>
                                <a :href="`mailto:${contactInfo?.email || ''}`"
                                    class="text-white text-sm md:text-base leading-snug hover:text-white/90 transition break-all">
                                    {{ contactInfo?.email || 'N/A' }}
                                </a>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Form & Map Section - Side by Side -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 lg:gap-10">
                    <!-- WhatsApp Form -->
                    <template v-if="isLoading || !contactInfo">
                        <div class="bg-primary rounded-2xl shadow-lg p-8 animate-pulse h-96">
                            <div class="h-6 w-1/2 bg-primary/30 rounded mb-4"></div>
                            <div class="space-y-4">
                                <div class="h-10 bg-primary/30 rounded"></div>
                                <div class="h-24 bg-primary/30 rounded"></div>
                                <div class="h-12 bg-primary/30 rounded"></div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl shadow-lg overflow-hidden">
                            <div class="p-6 md:p-7 bg-primary">
                                <h3 class="text-xl md:text-2xl font-epilogue font-bold text-white mb-2">
                                    Hubungi Kami
                                </h3>
                                <p class="text-white/80 text-sm md:text-base mb-5">
                                    Chat via WhatsApp
                                </p>

                                <form @submit.prevent="sendWhatsAppMessage" class="space-y-4">
                                    <div>
                                        <label for="name"
                                            class="block text-xs md:text-sm font-semibold text-white mb-1.5">
                                            Nama <span class="text-yellow-300">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-user text-white/70 text-sm"></i>
                                            </div>
                                            <input v-model="formData.name" type="text" id="name" required
                                                class="w-full pl-10 pr-3 py-2 text-sm bg-white/20 border-2 border-white/30 rounded-lg text-white placeholder-white/60 focus:ring-2 focus:ring-white focus:border-white transition-all duration-300"
                                                placeholder="Nama Anda" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="message"
                                            class="block text-xs md:text-sm font-semibold text-white mb-1.5">
                                            Pesan <span class="text-yellow-300">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute top-2 left-0 pl-3 pointer-events-none">
                                                <i class="fa-solid fa-comment-dots text-white/70 text-sm"></i>
                                            </div>
                                            <textarea v-model="formData.message" id="message" required rows="3"
                                                class="w-full pl-10 pr-3 py-2 text-sm bg-white/20 border-2 border-white/30 rounded-lg text-white placeholder-white/60 focus:ring-2 focus:ring-white focus:border-white transition-all duration-300 resize-none"
                                                placeholder="Pesan Anda"></textarea>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-white text-primary font-bold py-3 px-5 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group text-sm md:text-base">
                                        <i
                                            class="fa-brands fa-whatsapp text-lg group-hover:scale-110 transition-transform"></i>
                                        <span>Chat</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>

                    <!-- Map Section -->
                    <template v-if="isLoading || !contactInfo">
                        <div class="w-full h-96 bg-gray-200 rounded-2xl shadow-lg animate-pulse"></div>
                    </template>
                    <template v-else>
                        <div class="w-full h-96">
                            <GoogleMapEmbed :map-input="contactInfo.map_url || '-7.7828701,110.283376'"
                                :api-key="googleMapsApiKey" />
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { computed, reactive } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'
import SectionTitle from './SectionTitle.vue'
import GoogleMapEmbed from './GoogleMapEmbed.vue'

const { data: landingPageData, isLoading } = useLandingPageData()

const googleMapsApiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY || 'AIzaSyDkaKfuO9fUzqNfGgMQKnJHChnsid-4VY8'

const formData = reactive({
    name: '',
    message: '',
})

const contactInfo = computed(() => {
    return landingPageData.value?.contact || null
})

const siteSettings = computed(() => {
    return landingPageData.value?.siteSettings || null
})

const whatsappUrl = computed(() => {
    if (contactInfo.value?.phone) {
        const phoneNumber = contactInfo.value.phone.replace(/[^\d+]/g, '')
        let formattedNumber = phoneNumber
        if (phoneNumber.startsWith('0')) {
            formattedNumber = '62' + phoneNumber.substring(1)
        } else if (phoneNumber.startsWith('8')) {
            formattedNumber = '62' + phoneNumber
        }
        const message = encodeURIComponent('Halo, saya ingin bertanya lebih lanjut.')
        return `https://wa.me/${formattedNumber}?text=${message}`
    }
    return '#'
})

const sendWhatsAppMessage = () => {
    if (!formData.name.trim() || !formData.message.trim()) {
        return
    }

    if (contactInfo.value?.phone) {
        const phoneNumber = contactInfo.value.phone.replace(/[^\d+]/g, '')
        let formattedNumber = phoneNumber
        if (phoneNumber.startsWith('0')) {
            formattedNumber = '62' + phoneNumber.substring(1)
        } else if (phoneNumber.startsWith('8')) {
            formattedNumber = '62' + phoneNumber
        }

        const message = `Halo, nama saya *${formData.name}*\n\n${formData.message}`
        const encodedMessage = encodeURIComponent(message)
        const url = `https://wa.me/${formattedNumber}?text=${encodedMessage}`

        window.open(url, '_blank')

        formData.name = ''
        formData.message = ''
    }
}
</script>
