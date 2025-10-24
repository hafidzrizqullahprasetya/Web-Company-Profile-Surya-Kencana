<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section
    class="relative w-full min-h-screen flex flex-col justify-between overflow-hidden"
    id="home"
  >
    <div class="flex-1 flex items-center justify-start relative z-10">
      <div
        class="absolute inset-0 w-full h-full bg-cover bg-center"
        :style="{ backgroundImage: `url(${heroData.background})` }"
      ></div>
      <div class="absolute inset-0 bg-gradient-to-b from-secondary/60 to-secondary/80 z-10"></div>

      <div class="container mx-auto px-4 relative z-20">
        <div class="flex items-center justify-start min-h-[60vh]">
          <div class="max-w-[700px] text-white text-left">
            <div class="mb-6 animate-fade-in">
              <span
                class="text-white font-semibold text-sm py-2.5 px-6 bg-cream/20 backdrop-blur-md rounded-full inline-flex items-center gap-2 border border-cream/30 animate-slide-in-left"
              >
                <i-lucide:map-pin class="flex-shrink-0 text-primary w-3.5 h-3.5 !text-white" />
                {{ heroData.location }}
              </span>
            </div>

            <div class="my-6 animate-fade-in animation-delay-200">
              <h1
                class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-epilogue font-extrabold uppercase text-white leading-tight mb-6 tracking-wider drop-shadow-lg text-left"
              >
                {{ heroData.title }}
              </h1>
            </div>

            <div class="animate-fade-in animation-delay-400">
              <a
                href="#kontak"
                class="inline-flex items-center bg-primary text-white px-12 py-5 text-base font-semibold uppercase transition-all duration-300 no-underline tracking-wide rounded-lg shadow-soft hover:bg-primary-dark hover:-translate-y-0.5 hover:shadow-lg gap-3"
              >
                <span>Hubungi Kami</span>
                <i-lucide:arrow-up-right class="w-5 h-5 !text-white" />
              </a>
            </div>
          </div>
        </div>
      </div>

      <div
        class="absolute right-[5%] top-[30%] z-5 font-epilogue font-black opacity-[0.08] pointer-events-none flex flex-col items-end leading-none"
      >
        <span
          class="text-6xl md:text-7xl lg:text-8xl xl:text-9xl text-white font-black leading-none"
          >SU</span
        >
        <span
          class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl text-white font-black leading-none"
          >RYA</span
        >
        <span
          class="text-6xl md:text-7xl lg:text-8xl xl:text-9xl text-white font-black leading-none"
          >KEN</span
        >
        <span
          class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl text-white font-black leading-none"
          >CANA</span
        >
      </div>
    </div>

    <div class="relative z-20 bg-primary/95 backdrop-blur-md border-t border-cream/20">
      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 max-w-[1400px] mx-auto px-5 py-8"
      >
        <div
          v-for="(stat, idx) in stats"
          :key="idx"
          class="text-center flex-1 relative transition-transform duration-300 hover:-translate-y-1.25"
        >
          <div
            class="flex items-center justify-center w-20 h-20 bg-cream/10 rounded-full mx-auto mb-4 text-primary transition-all duration-300 border-2 border-cream/20 hover:bg-cream/20 hover:scale-110 hover:text-cream"
          >
            <component :is="stat.icon" class="w-8 h-8" />
          </div>
          <div
            class="text-4xl font-epilogue font-extrabold text-white mb-2 transition-all duration-300 hover:scale-110 hover:text-cream leading-tight"
          >
            {{ stat.value }}
          </div>
          <div class="text-xs font-semibold uppercase text-white tracking-wider">
            {{ stat.label }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

import ILucideSettings from '~icons/lucide/settings'
import ILucideBuilding from '~icons/lucide/building'
import ILucideUsers from '~icons/lucide/users'
import ILucideCalendar from '~icons/lucide/calendar'
import ILucideShieldCheck from '~icons/lucide/shield-check'

const heroData = ref({
  background:
    'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=1740&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  location: 'Jakarta, Indonesia',
  title: 'MESIN TERBAIK UNTUK INDUSTRI ANDA',
  machines: 500,
  clients: 200,
  customers: 5000,
  experienceYears: 15,
  trustYears: 20,
})

const stats = computed(() => [
  {
    icon: ILucideSettings,
    value: heroData.value.machines,
    label: 'MESIN DIPRODUKSI',
  },
  {
    icon: ILucideBuilding,
    value: heroData.value.clients,
    label: 'KLIEN',
  },
  {
    icon: ILucideUsers,
    value: heroData.value.customers,
    label: 'PELANGGAN',
  },
  {
    icon: ILucideCalendar,
    value: heroData.value.experienceYears,
    label: 'TAHUN PENGALAMAN',
  },
  {
    icon: ILucideShieldCheck,
    value: heroData.value.trustYears,
    label: 'TERPERCAYA',
  },
])
</script>
