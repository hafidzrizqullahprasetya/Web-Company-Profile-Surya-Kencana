<template>
    <div v-if="contactInfo && contactInfo.phone"
        class="fixed right-4 bottom-4 md:right-6 md:bottom-6 z-[9999] flex flex-col items-end space-y-3">
        <!-- WhatsApp Button -->
        <a :href="whatsappUrl" target="_blank"
            class="w-12 h-12 md:w-14 md:h-14 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 transform hover:scale-110 flex-shrink-0"
            aria-label="Hubungi kami via WhatsApp">
            <i class="fa-brands fa-whatsapp text-2xl md:text-3xl text-white"></i>
        </a>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useLandingPageData } from '@/composables/useLandingPageData'

const { data: landingPageData } = useLandingPageData()

const contactInfo = computed(() => landingPageData.value?.contact || null)

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
        return `https://wa.me/${formattedNumber}`
    }
    return ''
})
</script>
