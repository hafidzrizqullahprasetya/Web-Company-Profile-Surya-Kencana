<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="py-24 bg-white" id="kontak">
    <div class="container mx-auto px-4">
      <div class="row mb-16">
        <div class="col-lg-12">
          <div class="text-center mb-16">
            <small class="inline-block px-8 py-1.5 bg-gray-100 text-gray-800 text-xs font-medium uppercase mb-8">
              Contact Us
            </small>
            <h2 class="text-5xl md:text-6xl lg:text-7xl font-medium uppercase text-gray-900 mb-5">
              Get In <span class="relative inline-block z-10">
                Touch
                <span class="absolute left-1 bottom-5 w-[96%] h-5 bg-yellow-400 -z-10"></span>
              </span>
            </h2>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12" v-if="kontak">
        <!-- Contact Info -->
        <div class="space-y-8">
          <div class="flex items-start space-x-6 p-6 bg-gray-50 rounded-lg hover:bg-yellow-50 transition-colors duration-300">
            <div class="flex-shrink-0">
              <div class="w-14 h-14 bg-yellow-400 rounded-full flex items-center justify-center">
                <i class="fi flaticon-placeholder text-gray-900 text-2xl"></i>
              </div>
            </div>
            <div>
              <h4 class="text-xl font-semibold text-gray-900 mb-2">Address</h4>
              <p class="text-gray-600">{{ kontak.alamat }}</p>
            </div>
          </div>

          <div class="flex items-start space-x-6 p-6 bg-gray-50 rounded-lg hover:bg-yellow-50 transition-colors duration-300">
            <div class="flex-shrink-0">
              <div class="w-14 h-14 bg-yellow-400 rounded-full flex items-center justify-center">
                <i class="fi flaticon-phone-call text-gray-900 text-2xl"></i>
              </div>
            </div>
            <div>
              <h4 class="text-xl font-semibold text-gray-900 mb-2">Phone</h4>
              <p class="text-gray-600">{{ kontak.telepon }}</p>
            </div>
          </div>

          <div class="flex items-start space-x-6 p-6 bg-gray-50 rounded-lg hover:bg-yellow-50 transition-colors duration-300">
            <div class="flex-shrink-0">
              <div class="w-14 h-14 bg-yellow-400 rounded-full flex items-center justify-center">
                <i class="fi flaticon-email text-gray-900 text-2xl"></i>
              </div>
            </div>
            <div>
              <h4 class="text-xl font-semibold text-gray-900 mb-2">Email</h4>
              <p class="text-gray-600">{{ kontak.email }}</p>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="bg-gray-50 p-8 rounded-lg mt-8">
            <h3 class="text-2xl font-semibold text-gray-900 mb-6">Send us a message</h3>
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <input
                    v-model="form.name"
                    type="text"
                    placeholder="Your Name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 outline-none transition-all duration-300"
                    required
                  >
                </div>
                <div>
                  <input
                    v-model="form.email"
                    type="email"
                    placeholder="Your Email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 outline-none transition-all duration-300"
                    required
                  >
                </div>
              </div>

              <div>
                <input
                  v-model="form.subject"
                  type="text"
                  placeholder="Subject"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 outline-none transition-all duration-300"
                  required
                >
              </div>

              <div>
                <textarea
                  v-model="form.message"
                  rows="5"
                  placeholder="Your Message"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-200 outline-none resize-none transition-all duration-300"
                  required
                ></textarea>
              </div>

              <div>
                <button
                  type="submit"
                  :disabled="isSubmitting"
                  class="w-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-9 py-4 uppercase transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ isSubmitting ? 'Sending...' : 'Send Message' }}
                </button>
              </div>

              <!-- Success/Error Message -->
              <div v-if="submitMessage" class="mt-4">
                <div
                  :class="submitSuccess ? 'bg-green-100 text-green-800 border-green-400' : 'bg-red-100 text-red-800 border-red-400'"
                  class="px-4 py-3 rounded border"
                >
                  {{ submitMessage }}
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Map Area -->
        <div class="map-area h-full min-h-[600px] lg:min-h-full" v-if="kontak.maps_link">
          <iframe
            :src="kontak.maps_link"
            width="100%"
            height="100%"
            style="border:0; min-height: 600px;"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            class="rounded-lg shadow-lg"
          ></iframe>
        </div>
      </div>

      <!-- Loading State -->
      <div v-else class="text-center py-20">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-yellow-400"></div>
        <p class="mt-4 text-gray-600">Loading contact information...</p>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, inject } from 'vue'
import api, { type Kontak } from '@/services/api'

const kontak = ref<Kontak | null>(null)
const isSubmitting = ref(false)
const submitMessage = ref('')
const submitSuccess = ref(false)

// Inject dummy data
const dummyKontak = inject<Kontak>('dummyKontak')

const form = ref({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const handleSubmit = async () => {
  isSubmitting.value = true
  submitMessage.value = ''

  try {
    await new Promise(resolve => setTimeout(resolve, 1500))

    form.value = {
      name: '',
      email: '',
      subject: '',
      message: ''
    }

    submitSuccess.value = true
    submitMessage.value = 'Thank you! Your message has been sent successfully.'

    setTimeout(() => {
      submitMessage.value = ''
    }, 5000)
  } catch (error) {
    console.error('Error submitting form:', error)
    submitSuccess.value = false
    submitMessage.value = 'Sorry, there was an error sending your message. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}

onMounted(async () => {
  try {
    // Use dummy data for testing
    if (dummyKontak) {
      kontak.value = dummyKontak
    } else {
      kontak.value = await api.getKontak()
    }
  } catch (error) {
    console.error('Error loading contact:', error)
    if (dummyKontak) {
      kontak.value = dummyKontak
    }
  }
})
</script>

<style scoped>
/* Custom styles if needed */
.map-area iframe {
  width: 100%;
  height: 100%;
}

/* Hover effect for contact items */
.contact-item {
  transition: all 0.3s ease;
}

.contact-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Animation for form inputs */
input:focus,
textarea:focus {
  transform: translateY(-2px);
}

/* Custom scrollbar for textarea */
textarea::-webkit-scrollbar {
  width: 8px;
}

textarea::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

textarea::-webkit-scrollbar-thumb {
  background: #E5F346;
  border-radius: 10px;
}

textarea::-webkit-scrollbar-thumb:hover {
  background: #dff01b;
}
</style>
