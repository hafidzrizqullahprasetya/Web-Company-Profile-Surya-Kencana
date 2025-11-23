<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <div class="mb-6 sm:mb-8">
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Testimoni</h1>
      <p class="text-sm sm:text-base text-gray-600 mt-2">Kelola testimoni dari pelanggan perusahaan Anda</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="w-full sm:w-auto">
          <input
            type="text"
            v-model="searchQuery"
            placeholder="Cari testimoni..."
            class="w-full sm:w-80 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
          />
        </div>
        <button
          @click="openAddModal"
          class="w-full sm:w-auto flex items-center justify-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed transition"
        >
          <svg
            class="w-5 h-5 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"
            ></path>
          </svg>
          Tambah Testimoni
        </button>
      </div>

      <!-- Daftar Testimoni -->
      <!-- Desktop Table View -->
      <div class="hidden lg:block overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Klien</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instansi</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umpan Balik</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="testimonial in filteredTestimonials" :key="testimonial.id" class="hover:bg-gray-50 transition">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ testimonial.id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ testimonial.client_name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ testimonial.institution }}</td>
              <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ testimonial.feedback }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(testimonial.date) }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button @click="openEditModal(testimonial)" class="text-primary hover:text-primary/80 mr-3 transition">
                  <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Edit
                </button>
                <button @click="confirmDelete(testimonial)" class="text-red-600 hover:text-red-800 transition">
                  <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Mobile Card View -->
      <div class="lg:hidden space-y-4">
        <div v-for="testimonial in filteredTestimonials" :key="testimonial.id" class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
          <div class="flex justify-between items-start mb-3">
            <div>
              <h3 class="font-semibold text-gray-900">{{ testimonial.client_name }}</h3>
              <p class="text-sm text-gray-500">{{ testimonial.institution }}</p>
            </div>
            <span class="text-xs text-gray-400">#{{ testimonial.id }}</span>
          </div>
          <p class="text-sm text-gray-700 mb-3 line-clamp-2">{{ testimonial.feedback }}</p>
          <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
            <span>{{ formatDate(testimonial.date) }}</span>
          </div>
          <div class="flex gap-2">
            <button @click="openEditModal(testimonial)" class="flex-1 px-3 py-2 text-sm bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Edit
            </button>
            <button @click="confirmDelete(testimonial)" class="flex-1 px-3 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Hapus
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-700">
          Menampilkan
          {{ Math.min((currentPage - 1) * itemsPerPage + 1, testimonials.length) }} hingga
          {{ Math.min(currentPage * itemsPerPage, testimonials.length) }} dari
          {{ testimonials.length }} data
        </div>
        <div class="flex space-x-2">
          <button
            @click="currentPage = Math.max(1, currentPage - 1)"
            :disabled="currentPage === 1"
            class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            Sebelumnya
          </button>
          <button
            @click="currentPage = Math.min(totalPages, currentPage + 1)"
            :disabled="currentPage === totalPages"
            class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            Berikutnya
          </button>
        </div>
      </div>
    </div>

    <!-- Preview Slider Section -->
    <div class="mt-12 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-6">Pratinjau Testimoni</h2>

      <!-- Testimonial Preview Grid with Pagination -->
      <div>
        <!-- Testimonial Grid (max 4 per page) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <div
            v-for="testimonial in currentPagePreviewTestimonials"
            :key="testimonial.id"
            class="bg-gray-50 rounded-lg p-6 border border-gray-200"
          >
            <div class="flex items-center mb-4">
              <div
                class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold mr-3"
              >
                {{ testimonial.client_name.charAt(0).toUpperCase() }}
              </div>
              <div>
                <h4 class="font-semibold text-gray-900 text-sm">{{ testimonial.client_name }}</h4>
                <p class="text-xs text-gray-600">{{ testimonial.institution }}</p>
              </div>
            </div>
            <p class="text-gray-700 italic mb-4 text-sm line-clamp-3">
              "{{ testimonial.feedback }}"
            </p>
            <div class="flex items-center text-gray-500 text-xs">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                />
              </svg>
              <span>{{ formatDate(testimonial.date) }}</span>
            </div>
          </div>

          <!-- Empty state if no testimonials -->
          <div
            v-if="testimonials.length === 0"
            class="col-span-full bg-gray-50 rounded-lg p-6 border border-gray-200 flex items-center justify-center"
          >
            <div class="text-center text-gray-500">
              <svg
                class="w-12 h-12 mx-auto mb-3"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                />
              </svg>
              <p>Belum ada testimoni</p>
              <p class="text-sm">Tambahkan testimoni pertama</p>
            </div>
          </div>
        </div>

        <!-- Pagination Controls for Preview -->
        <div v-if="testimonials.length > 0" class="flex flex-col items-center gap-4">
          <!-- Page Dots -->
          <div class="flex items-center gap-3">
            <button
              v-for="page in visiblePreviewPageDots"
              :key="page"
              @click="goToPreviewPage(page)"
              class="transition-all duration-300"
              :class="
                currentPreviewPage === page
                  ? 'w-12 h-3 bg-primary rounded-full'
                  : 'w-3 h-3 bg-gray-300 rounded-full hover:bg-gray-400'
              "
            />
          </div>

          <!-- Navigation Buttons -->
          <div class="flex items-center gap-6">
            <button
              @click="prevPreviewPage"
              :disabled="currentPreviewPage === 0"
              class="w-10 h-10 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 19l-7-7 7-7"
                />
              </svg>
            </button>

            <div class="text-gray-600 text-sm font-medium">
              Page {{ currentPreviewPage + 1 }} of {{ totalPreviewPages }}
            </div>

            <button
              @click="nextPreviewPage"
              :disabled="currentPreviewPage === totalPreviewPages - 1"
              class="w-10 h-10 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Testimoni -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
    >
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-900">
              {{ isEditing ? 'Edit Testimoni' : 'Tambah Testimoni' }}
            </h3>
            <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
              <svg
                class="h-6 w-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                ></path>
              </svg>
            </button>
          </div>

          <form @submit.prevent="submitTestimonial" class="space-y-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Nama Klien</label>
              <input
                v-model="formData.client_name"
                type="text"
                required
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                placeholder="Nama klien"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Instansi</label>
              <input
                v-model="formData.institution"
                type="text"
                required
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                placeholder="Instansi"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Umpan Balik</label>
              <textarea
                v-model="formData.feedback"
                required
                rows="4"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                placeholder="Isi testimoni"
              ></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
              <input
                v-model="formData.date"
                type="date"
                required
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
              />
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
              <button
                type="button"
                @click="closeModal"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition"
              >
                Batal
              </button>
              <button
                type="submit"
                :disabled="isSubmitting"
                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed transition"
              >
                <span v-if="!isSubmitting">{{
                  isEditing ? 'Perbarui Testimoni' : 'Tambah Testimoni'
                }}</span>
                <span v-else class="flex items-center">
                  <svg
                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                  >
                    <circle
                      class="opacity-25"
                      cx="12"
                      cy="12"
                      r="10"
                      stroke="currentColor"
                      stroke-width="4"
                    ></circle>
                    <path
                      class="opacity-75"
                      fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                  </svg>
                  Menyimpan...
                </span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      v-if="showDeleteModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
      @click.self="showDeleteModal = false"
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
        <div class="text-center">
          <div
            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4"
          >
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
              />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Testimoni?</h3>
          <p class="text-sm text-gray-500 mb-6">
            Apakah Anda yakin ingin menghapus testimoni dari
            <strong>{{ testimonialToDelete?.client_name }}</strong
            >? Tindakan ini tidak dapat dibatalkan.
          </p>
          <div class="flex gap-3">
            <button
              @click="showDeleteModal = false"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
            >
              Batal
            </button>
            <button
              @click="deleteTestimonial"
              :disabled="isDeleting"
              class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 transition"
            >
              {{ isDeleting ? 'Menghapus...' : 'Ya, Hapus' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import api, { type Testimonial } from '@/services/api'
import { useToast } from '@/composables/useToast'

const toast = useToast()

// State
const testimonials = ref<Testimonial[]>([])
const showModal = ref(false)
const isEditing = ref(false)
const isSubmitting = ref(false)
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)
const showDeleteModal = ref(false)
const testimonialToDelete = ref<Testimonial | null>(null)
const isDeleting = ref(false)

// Preview pagination state
const currentPreviewPage = ref(0)
const previewItemsPerPage = 4

// Form data
const formData = ref<Testimonial>({
  id: 0,
  client_name: '',
  institution: '',
  feedback: '',
  date: '',
})

// Computed
const filteredTestimonials = computed(() => {
  let result = testimonials.value

  // Apply search filter
  if (searchQuery.value) {
    result = result.filter(
      (testimonial) =>
        testimonial.client_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        testimonial.feedback.toLowerCase().includes(searchQuery.value.toLowerCase()),
    )
  }

  // Apply pagination
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return result.slice(start, end)
})

const totalPages = computed(() => {
  return Math.ceil(testimonials.value.length / itemsPerPage.value)
})

// Preview pagination computed
const totalPreviewPages = computed(() => {
  return Math.ceil(testimonials.value.length / previewItemsPerPage)
})

const currentPagePreviewTestimonials = computed(() => {
  const start = currentPreviewPage.value * previewItemsPerPage
  const end = start + previewItemsPerPage
  return testimonials.value.slice(start, end)
})

const visiblePreviewPageDots = computed(() => {
  const total = totalPreviewPages.value
  if (total <= 4) {
    return Array.from({ length: total }, (_, i) => i)
  }

  const current = currentPreviewPage.value
  const maxDots = 4

  let start = Math.max(0, current - Math.floor(maxDots / 2))
  const end = Math.min(total, start + maxDots)

  if (end === total) {
    start = Math.max(0, end - maxDots)
  }

  return Array.from({ length: end - start }, (_, i) => start + i)
})

// Helper functions
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
  })
}

// Methods
const loadTestimonials = async () => {
  try {
    const data = await api.getTestimonials()
    testimonials.value = data
  } catch (error: unknown) {
    console.error('Error fetching testimonials:', error)
    toast.error('Gagal memuat data testimoni')
  }
}

const openAddModal = () => {
  isEditing.value = false
  formData.value = {
    id: 0,
    client_name: '',
    institution: '',
    feedback: '',
    date: '',
  }
  showModal.value = true
}

const openEditModal = (testimonial: Testimonial) => {
  isEditing.value = true
  formData.value = { ...testimonial }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
}

const submitTestimonial = async () => {
  isSubmitting.value = true
  try {
    if (isEditing.value) {
      await api.updateTestimonial(formData.value.id, formData.value)
      toast.success('Testimoni berhasil diperbarui!')
    } else {
      await api.createTestimonial(formData.value)
      toast.success('Testimoni berhasil ditambahkan!')
    }
    await loadTestimonials()
    closeModal()
  } catch (error: unknown) {
    console.error('Error saving testimonial:', error)
    const axiosError = error as { response?: { data?: { message?: string } } }
    const message = axiosError.response?.data?.message || 'Gagal menyimpan testimoni'
    toast.error(message)
  } finally {
    isSubmitting.value = false
  }
}

const confirmDelete = (testimonial: Testimonial) => {
  testimonialToDelete.value = testimonial
  showDeleteModal.value = true
}

const deleteTestimonial = async () => {
  if (!testimonialToDelete.value) return

  try {
    isDeleting.value = true
    await api.deleteTestimonial(testimonialToDelete.value.id)
    toast.success('Testimoni berhasil dihapus!')
    await loadTestimonials()
    showDeleteModal.value = false
    testimonialToDelete.value = null
  } catch (error: unknown) {
    console.error('Error deleting testimonial:', error)
    const axiosError = error as { response?: { data?: { message?: string } } }
    const message = axiosError.response?.data?.message || 'Gagal menghapus testimoni'
    toast.error(message)
  } finally {
    isDeleting.value = false
  }
}

// Preview pagination methods
const prevPreviewPage = () => {
  if (currentPreviewPage.value > 0) {
    currentPreviewPage.value--
  }
}

const nextPreviewPage = () => {
  if (currentPreviewPage.value < totalPreviewPages.value - 1) {
    currentPreviewPage.value++
  }
}

const goToPreviewPage = (page: number) => {
  if (page >= 0 && page < totalPreviewPages.value) {
    currentPreviewPage.value = page
  }
}

// Load data on component mount
onMounted(() => {
  loadTestimonials()
})
</script>
