<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="home-page">
    <Header />
    <Hero />
    <VisiMisi />
    <Produk />
    <Riwayat />
    <OurClient />
    <Testimoni />
    <Kontak />
    <Footer />
    <WhatsAppFloatingButton />
  </div>
</template>

<script setup lang="ts">
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

</script>

<style scoped>
.home-page {
  overflow-x: hidden;
}
</style>
