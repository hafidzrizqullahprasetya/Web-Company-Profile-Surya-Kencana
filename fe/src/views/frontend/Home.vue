<template>
    <div class="home-page flex flex-col min-h-screen">
        <!-- Error Banner -->
        <div v-if="landingError" class="fixed top-0 left-0 right-0 z-50 bg-red-50 border-b border-red-200 shadow-sm">
            <div class="container mx-auto px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-exclamation-circle text-red-600 text-lg"></i>
                    <span class="text-red-800 text-sm md:text-base">{{ landingError }}</span>
                </div>
                <button @click="retryFetch"
                    class="ml-4 px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-refresh"></i>
                    <span>Retry</span>
                </button>
            </div>
        </div>

        <!-- Main content with top padding if error banner is shown -->
        <div :class="landingError ? 'pt-16 md:pt-14' : ''">
            <Header />

            <main class="flex-grow">
                <Hero />
                <VisiMisi />
                <Produk />
                <Riwayat />
                <OurClient />
                <Testimoni />
                <Kontak />
            </main>

            <Footer />

            <WhatsAppFloatingButton />
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import Header from '@/components/frontend/Header.vue'
import Hero from '@/components/frontend/Hero.vue'
import VisiMisi from '@/components/frontend/VisiMisi.vue'
import Produk from '@/components/frontend/Produk.vue'
import Riwayat from '@/components/frontend/Riwayat.vue'
import OurClient from '@/components/frontend/OurClient.vue'
import Testimoni from '@/components/frontend/Testimoni.vue'
import Kontak from '@/components/frontend/Kontak.vue'
import Footer from '@/components/frontend/Footer.vue'
import WhatsAppFloatingButton from '@/components/frontend/WhatsAppFloatingButton.vue'
import { useLandingPageData } from '@/composables'

const { error: landingError, refresh: retryFetch } = useLandingPageData()
</script>

<style scoped>
.home-page {
    overflow-x: hidden;
}
</style>
