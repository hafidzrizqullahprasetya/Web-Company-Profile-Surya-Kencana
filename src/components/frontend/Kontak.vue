<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-white overflow-hidden" id="kontak">
    <div class="container mx-auto px-4">
      <div class="text-center mb-20">
        <div class="inline-block mb-6">
          <span
            class="bg-primary text-white px-6 py-3 text-xs font-semibold uppercase tracking-widest"
          >
            HUBUNGI KAMI
          </span>
        </div>
        <h2
          class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-epilogue font-bold text-secondary leading-tight uppercase tracking-wide mb-10"
        >
          JANGAN
          <span class="text-secondary relative"
            >RAGU
            <div class="absolute -bottom-1 left-0 w-full h-3 bg-primary -z-10"></div></span
          ><br />
          MENGHUBUNGI KAMI.
        </h2>
      </div>

      <div v-if="isLoading" class="flex flex-col items-center justify-center py-16 text-center">
        <div
          class="w-10 h-10 border-4 border-primary/30 border-t-primary rounded-full animate-spin mb-4"
        ></div>
        <p class="text-secondary text-base">Loading contact information...</p>
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

      <div v-else-if="contactInfo" class="flex flex-col gap-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
          <!-- Contact Information -->
          <div class="flex flex-col gap-8">
            <div
              class="bg-primary text-white p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 flex items-start gap-6"
            >
              <div
                class="w-12 h-12 bg-secondary/20 text-white rounded-lg flex items-center justify-center flex-shrink-0"
              >
                <i-lucide:map-pin class="w-6 h-6" />
              </div>
              <div class="flex flex-col gap-2">
                <h3 class="text-xl font-epilogue font-bold uppercase tracking-wide text-white">
                  Alamat
                </h3>
                <p class="text-white/90 text-base leading-relaxed">{{ contactInfo.address }}</p>
              </div>
            </div>

            <div
              class="bg-primary text-white p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 flex items-start gap-6"
            >
              <div
                class="w-12 h-12 bg-secondary/20 text-white rounded-lg flex items-center justify-center flex-shrink-0"
              >
                <i-lucide:phone class="w-6 h-6" />
              </div>
              <div class="flex flex-col gap-2">
                <h3 class="text-xl font-epilogue font-bold uppercase tracking-wide text-white">
                  Telepon
                </h3>
                <p class="text-white/90 text-base leading-relaxed">{{ contactInfo.phone }}</p>
              </div>
            </div>

            <div
              class="bg-primary text-white p-8 rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 flex items-start gap-6"
            >
              <div
                class="w-12 h-12 bg-secondary/20 text-white rounded-lg flex items-center justify-center flex-shrink-0"
              >
                <i-lucide:mail class="w-6 h-6" />
              </div>
              <div class="flex flex-col gap-2">
                <h3 class="text-xl font-epilogue font-bold uppercase tracking-wide text-white">
                  Email
                </h3>
                <p class="text-white/90 text-base leading-relaxed">{{ contactInfo.email }}</p>
              </div>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="bg-primary text-white p-8 rounded-xl shadow-xl">
            <h3
              class="text-2xl font-epilogue font-bold uppercase tracking-wide mb-8 text-white text-center"
            >
              Kirim Pesan
            </h3>
            <form @submit.prevent="handleSubmit" class="flex flex-col gap-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                  <label for="name" class="text-sm font-semibold uppercase tracking-wide text-white"
                    >Nama Lengkap</label
                  >
                  <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    placeholder="Masukkan nama Anda"
                    class="px-4 py-3 border border-white/20 rounded-lg focus:border-white focus:outline-none transition-colors bg-white/10 text-white placeholder-white/70"
                    required
                  />
                </div>

                <div class="flex flex-col gap-2">
                  <label
                    for="email"
                    class="text-sm font-semibold uppercase tracking-wide text-white"
                    >Email</label
                  >
                  <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    placeholder="Masukkan email Anda"
                    class="px-4 py-3 border border-white/20 rounded-lg focus:border-white focus:outline-none transition-colors bg-white/10 text-white placeholder-white/70"
                    required
                  />
                </div>
              </div>

              <div class="flex flex-col gap-2">
                <label
                  for="subject"
                  class="text-sm font-semibold uppercase tracking-wide text-white"
                  >Subjek</label
                >
                <input
                  id="subject"
                  v-model="form.subject"
                  type="text"
                  placeholder="Subjek pesan Anda"
                  class="px-4 py-3 border border-white/20 rounded-lg focus:border-white focus:outline-none transition-colors bg-white/10 text-white placeholder-white/70"
                  required
                />
              </div>

              <div class="flex flex-col gap-2">
                <label
                  for="message"
                  class="text-sm font-semibold uppercase tracking-wide text-white"
                  >Pesan</label
                >
                <textarea
                  id="message"
                  v-model="form.message"
                  rows="5"
                  placeholder="Tulis pesan Anda di sini..."
                  class="px-4 py-3 border border-white/20 rounded-lg focus:border-white focus:outline-none transition-colors bg-white/10 text-white placeholder-white/70 resize-vertical"
                  required
                ></textarea>
              </div>

              <button
                type="submit"
                :disabled="isSubmitting"
                class="bg-white text-primary px-6 py-4 text-sm font-semibold uppercase tracking-wide rounded-lg transition-all duration-300 hover:bg-white/90 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {{ isSubmitting ? 'Mengirim...' : 'Kirim Pesan' }}
              </button>

              <!-- Success/Error Message -->
              <div
                v-if="submitMessage"
                class="px-4 py-3 rounded-lg text-center text-sm font-medium"
                :class="submitSuccess ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
              >
                {{ submitMessage }}
              </div>
            </form>
          </div>
        </div>

        <!-- Map Section -->
        <div v-if="contactInfo.map_url" class="w-full max-w-4xl mx-auto">
          <div class="rounded-xl overflow-hidden shadow-xl">
            <iframe
              :src="contactInfo.map_url"
              width="100%"
              height="400"
              style="border: 0"
              allow="fullscreen"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/services/api'

interface ContactInfo {
  id: number
  address: string
  phone: string
  email: string
  map_url: string
}

const contactInfo = ref<ContactInfo | null>(null)
const isLoading = ref(true)
const error = ref<string | null>(null)
const isSubmitting = ref(false)
const submitMessage = ref('')
const submitSuccess = ref(false)

const form = ref({
  name: '',
  email: '',
  subject: '',
  message: '',
})

const fetchContact = async () => {
  try {
    isLoading.value = true
    error.value = null
    const data = await api.getContact()
    if (data.length > 0) {
      contactInfo.value = data[0]
    } else {
      error.value = 'Contact information not found'
    }
  } catch (err) {
    console.error('Error fetching contact:', err)
    const message =
      (err as { response?: { data?: { message?: string } } })?.response?.data?.message ||
      'Gagal memuat informasi kontak'
    error.value = message
  } finally {
    isLoading.value = false
  }
}

const retryFetch = () => {
  fetchContact()
}

const handleSubmit = async () => {
  isSubmitting.value = true
  submitMessage.value = ''

  try {
    await new Promise((resolve) => setTimeout(resolve, 1500))
    form.value = {
      name: '',
      email: '',
      subject: '',
      message: '',
    }

    submitSuccess.value = true
    submitMessage.value = 'Terima kasih! Pesan Anda telah terkirim dengan sukses.'

    setTimeout(() => {
      submitMessage.value = ''
    }, 5000)
  } catch (error) {
    console.error('Error submitting form:', error)
    submitSuccess.value = false
    submitMessage.value = 'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi.'
  } finally {
    isSubmitting.value = false
  }
}

onMounted(() => {
  fetchContact()
})
</script>
