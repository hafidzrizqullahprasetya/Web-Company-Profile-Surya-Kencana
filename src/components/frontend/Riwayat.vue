<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-primary overflow-hidden" id="riwayat">
    <div class="container mx-auto px-4">
      <div class="text-center mb-20">
        <div class="inline-block mb-6">
          <span
            class="bg-white text-primary px-6 py-3 text-xs font-semibold uppercase tracking-widest"
          >
            RIWAYAT PERUSAHAAN
          </span>
        </div>
        <h2
          class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-epilogue font-bold text-white leading-tight uppercase tracking-wide mb-10"
        >
          PERJALANAN
          <span class="text-white relative"
            >KAMI
            <div class="absolute -bottom-1 left-0 w-full h-3 bg-primary -z-10"></div></span
          ><br />
          SELAMA INI.
        </h2>
      </div>

      <div v-if="isLoading" class="flex flex-col items-center justify-center py-16 text-center">
        <div
          class="w-10 h-10 border-4 border-primary/30 border-t-primary rounded-full animate-spin mb-4"
        ></div>
        <p class="text-white text-base">Loading company history...</p>
      </div>

      <div v-else-if="error" class="flex flex-col items-center justify-center py-16 text-center">
        <p class="text-red-500 text-base mb-4 font-medium">{{ error }}</p>
        <button
          @click="retryFetch"
          class="bg-primary text-secondary px-6 py-3 text-sm font-semibold rounded-md transition-all duration-300 hover:bg-primary-dark hover:-translate-y-0.5"
        >
          Coba Lagi
        </button>
      </div>

      <div v-else class="relative max-w-4xl mx-auto">
        <div
          class="absolute top-0 bottom-0 left-1/2 transform -translate-x-1/2 w-1 bg-white rounded-full hidden md:block"
        ></div>

        <div
          v-for="(item, index) in historyItems"
          :key="item.id"
          class="relative mb-16 md:w-1/2 md:pr-10 text-right md:text-right"
          :class="{ 'md:ml-auto md:pl-10 md:text-left': index % 2 !== 0 }"
        >
          <div class="relative">
            <div
              class="absolute top-8 -right-3 md:right-auto md:left-0 w-6 h-6 bg-primary border-4 border-secondary rounded-full z-10 hidden md:block"
            ></div>

            <div
              class="bg-white text-secondary p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
            >
              <div class="mb-4">
                <span
                  class="bg-secondary text-white px-4 py-2 text-sm font-bold uppercase tracking-wide rounded-full inline-block"
                >
                  {{ item.tahun }}
                </span>
              </div>
              <h3
                class="text-xl font-epilogue font-bold uppercase tracking-wide mb-3 text-secondary"
              >
                {{ item.judul }}
              </h3>
              <p class="text-secondary/90 text-base leading-relaxed">
                {{ item.deskripsi }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'

interface HistoryItem {
  id: number
  tahun: number
  judul: string
  deskripsi: string
}

const historyItems = ref<HistoryItem[]>([])
const isLoading = ref(true)
const error = ref<string | null>(null)

const fetchHistory = async () => {
  try {
    isLoading.value = true
    error.value = null
    historyItems.value = [
      {
        id: 1,
        tahun: 2010,
        judul: 'Berdiri',
        deskripsi:
          'SURYA KENCANA berdiri dengan komitmen untuk menyediakan hunian berkualitas bagi masyarakat Indonesia.',
      },
      {
        id: 2,
        tahun: 2013,
        judul: 'Ekspansi Pertama',
        deskripsi:
          'Melakukan ekspansi pertama dengan membangun perumahan di daerah Jakarta Selatan.',
      },
      {
        id: 3,
        tahun: 2016,
        judul: 'Pengembangan Wilayah',
        deskripsi:
          'Memperluas pengembangan ke wilayah Bekasi dan Tangerang dengan konsep hunian modern.',
      },
      {
        id: 4,
        tahun: 2019,
        judul: 'Teknologi Digital',
        deskripsi:
          'Mengimplementasikan teknologi digital dalam pelayanan dan pengembangan properti.',
      },
      {
        id: 5,
        tahun: 2022,
        judul: 'Sertifikasi Internasional',
        deskripsi:
          'Mendapatkan sertifikasi internasional untuk kualitas dan keberlanjutan dalam pembangunan.',
      },
      {
        id: 6,
        tahun: 2024,
        judul: 'Penghargaan Nasional',
        deskripsi:
          'Mendapatkan penghargaan nasional sebagai perusahaan properti terbaik tahun ini.',
      },
    ]

    console.log('History data:', historyItems.value)
  } catch (err) {
    console.error('Error fetching company history:', err)
    const message =
      (err as { response?: { data?: { message?: string } } })?.response?.data?.message ||
      'Gagal memuat riwayat perusahaan'
    error.value = message
  } finally {
    isLoading.value = false
  }
}

const retryFetch = () => {
  fetchHistory()
}

onMounted(() => {
  fetchHistory()
})
</script>
