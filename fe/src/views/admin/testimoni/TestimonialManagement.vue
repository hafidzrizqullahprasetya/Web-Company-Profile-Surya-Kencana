<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="pt-5 sm:pt-24 md:pt-5 px-4 sm:px-6 lg:px-2">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Testimoni</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-2">Kelola testimoni dari pelanggan Anda - Drag & drop untuk
                mengubah urutan</p>
        </div>

        <!-- Action Bar -->
        <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex-1 sm:max-w-md relative">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input v-model="searchQuery" type="text" placeholder="Cari testimoni..."
                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" />
            </div>
            <button @click="openModal()"
                class="px-4 sm:px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-plus text-sm"></i>
                <span class="hidden sm:inline">Tambah Testimoni</span>
                <span class="sm:hidden">Tambah</span>
            </button>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <SkeletonLoader type="table" :rows="10" :columns="4" />
        </div>

        <!-- Testimonials Grid with Drag and Drop -->
        <div v-else-if="filteredTestimonials.length > 0"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 min-h-[600px] items-start">
            <div v-for="(testimonial, index) in paginatedTestimonials" :key="testimonial.id" draggable="true"
                @dragstart="handleDragStart(index, $event)" @dragover="handleDragOver($event)"
                @dragenter="handleDragEnter(index)" @dragleave="handleDragLeave" @drop="handleDrop(index, $event)"
                @dragend="handleDragEnd" :class="[
                    'bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group cursor-move flex flex-col h-[280px]',
                    draggedIndex === index ? 'opacity-50 scale-95' : '',
                    dragOverIndex === index && draggedIndex !== index ? 'ring-2 ring-primary scale-105' : ''
                ]">
                <!-- Drag Handle -->
                <div
                    class="absolute top-2 sm:top-3 left-1/2 -translate-x-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                    <div
                        class="bg-primary text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg flex items-center gap-1">
                        <i class="fa-solid fa-grip-vertical"></i>
                        <span>Drag</span>
                    </div>
                </div>

                <!-- Order Badge -->
                <div class="absolute top-2 right-2 z-20">
                    <span class="px-2.5 py-1 bg-primary text-white text-xs font-bold rounded-lg shadow-md">
                        #{{ (currentPage - 1) * itemsPerPage + index + 1 }}
                    </span>
                </div>

                <!-- Card Content -->
                <div class="p-5 pb-6 flex flex-col h-full">
                    <!-- Avatar & Client Info -->
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-primary to-primary/80 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                            {{ testimonial.client_name.charAt(0).toUpperCase() }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-gray-900 font-bold text-base leading-tight mb-0.5">
                                {{ testimonial.client_name }}
                            </h3>
                            <p class="text-gray-600 text-xs leading-tight">
                                {{ testimonial.institution }}
                            </p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-100 mb-4"></div>

                    <!-- Feedback with Quote -->
                    <div class="flex-1 mb-4">
                        <div class="relative">
                            <i class="fa-solid fa-quote-left text-primary/50 text-2xl absolute -top-2 -left-1"></i>
                            <p class="text-gray-700 text-sm leading-relaxed pl-6 pr-3 line-clamp-4 italic">
                                {{ testimonial.feedback }}
                            </p>
                        </div>
                    </div>

                    <!-- Date Footer with Action Buttons -->
                    <div class="flex items-center justify-between gap-3 pt-2 border-t border-gray-50">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <i class="fa-solid fa-calendar-days text-primary"></i>
                            <span class="font-medium">{{ formatDate(testimonial.date) }}</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <button @click="openModal(testimonial)"
                                class="p-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition shadow-md"
                                title="Edit">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </button>
                            <button @click="confirmDelete(testimonial)"
                                class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-md"
                                title="Hapus">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="!isLoading && filteredTestimonials.length > 0"
            class="flex justify-center items-center gap-2 mt-6 mb-8">
            <button @click="currentPage = currentPage - 1" :disabled="currentPage === 1"
                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <button v-for="page in totalPages" :key="page" @click="currentPage = page" :class="[
                'px-4 py-2 rounded-lg transition',
                currentPage === page
                    ? 'bg-primary text-white'
                    : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'
            ]">
                {{ page }}
            </button>

            <button @click="currentPage = currentPage + 1" :disabled="currentPage === totalPages"
                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <!-- Empty State -->
        <div v-else-if="!isLoading && filteredTestimonials.length === 0" class="text-center py-12 sm:py-20">
            <i class="fa-solid fa-comments text-gray-400 mx-auto mb-4 text-4xl sm:text-5xl"></i>
            <p class="text-gray-600 text-base sm:text-lg">Belum ada testimoni</p>
            <button @click="openModal()"
                class="mt-4 px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                Tambah Testimoni Pertama
            </button>
        </div>

        <!-- Modal Form -->
        <div v-if="showModal"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 overflow-y-auto"
            @click.self="closeModal">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full my-8">
                <div
                    class="sticky top-0 bg-white border-b px-4 sm:px-6 py-4 flex justify-between items-center rounded-t-xl">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                        {{ editMode ? 'Edit Testimoni' : 'Tambah Testimoni Baru' }}
                    </h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form @submit.prevent="handleSubmit"
                    class="p-4 sm:p-6 space-y-5 max-h-[calc(90vh-100px)] overflow-y-auto">
                    <!-- Nama Client -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Client <span class="text-red-500">*</span>
                        </label>
                        <input v-model="formData.client_name" type="text" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Nama lengkap client" />
                    </div>

                    <!-- Institusi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Institusi <span class="text-red-500">*</span>
                        </label>
                        <input v-model="formData.institution" type="text" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Nama institusi atau perusahaan" />
                    </div>

                    <!-- Feedback -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Testimoni <span class="text-red-500">*</span>
                        </label>
                        <textarea v-model="formData.feedback" required rows="5"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Tulis testimoni dari client..."></textarea>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input v-model="formData.date" type="date" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" />
                    </div>

                    <!-- Error Message -->
                    <div v-if="errorMessage"
                        class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        {{ errorMessage }}
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="closeModal"
                            class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" :disabled="isSubmitting"
                            class="flex-1 px-4 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            <span v-if="!isSubmitting">{{
                                editMode ? 'Simpan Perubahan' : 'Tambah Testimoni'
                            }}</span>
                            <span v-else class="flex items-center justify-center gap-2">
                                <i class="fa-solid fa-spinner animate-spin"></i>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { testimonialsApi } from '@/services'
import type { Testimonial } from '@/types/models'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
import { showToast, showDeleteConfirm, showLoading, closeLoading } from '@/utils/sweetalert'

const testimonials = ref<Testimonial[]>([])
const isLoading = ref(true)
const searchQuery = ref('')
const showModal = ref(false)
const editMode = ref(false)
const isSubmitting = ref(false)
const errorMessage = ref('')

const formData = ref({
    id: 0,
    client_name: '',
    institution: '',
    feedback: '',
    date: '',
})

const editingId = ref<number | null>(null)

// Drag and drop state
const draggedIndex = ref<number | null>(null)
const dragOverIndex = ref<number | null>(null)

// Pagination state
const currentPage = ref(1)
const itemsPerPage = ref(8)

const filteredTestimonials = computed(() => {
    if (!searchQuery.value) return testimonials.value
    const query = searchQuery.value.toLowerCase()
    return testimonials.value.filter(
        (t) =>
            t.client_name.toLowerCase().includes(query) ||
            (t.institution || '').toLowerCase().includes(query) ||
            t.feedback.toLowerCase().includes(query),
    )
})

const totalPages = computed(() => {
    return Math.ceil(filteredTestimonials.value.length / itemsPerPage.value)
})

const paginatedTestimonials = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    const end = start + itemsPerPage.value
    return filteredTestimonials.value.slice(start, end)
})

const formatDate = (dateString: string) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    })
}

const fetchTestimonials = async () => {
    try {
        isLoading.value = true
        const data = await testimonialsApi.getTestimonials()
        testimonials.value = data.sort((a, b) => (a.order || 0) - (b.order || 0))
    } catch (error) {
        console.error('Error fetching testimonials:', error)
        showToast.error('Gagal memuat data testimoni')
    } finally {
        isLoading.value = false
    }
}

// Drag and Drop Handlers
const handleDragStart = (index: number, event: DragEvent) => {
    draggedIndex.value = index
    if (event.dataTransfer) {
        event.dataTransfer.effectAllowed = 'move'
        event.dataTransfer.setData('text/html', event.target as any)
    }
}

const handleDragOver = (event: DragEvent) => {
    event.preventDefault()
    if (event.dataTransfer) {
        event.dataTransfer.dropEffect = 'move'
    }
}

const handleDragEnter = (index: number) => {
    dragOverIndex.value = index
}

const handleDragLeave = () => {
    // Optional: can be used for additional styling
}

const handleDrop = async (dropIndex: number, event: DragEvent) => {
    event.preventDefault()

    if (draggedIndex.value === null || draggedIndex.value === dropIndex) {
        draggedIndex.value = null
        dragOverIndex.value = null
        return
    }

    try {
        // Calculate actual indices considering pagination
        const pageOffset = (currentPage.value - 1) * itemsPerPage.value
        const actualDraggedIndex = pageOffset + draggedIndex.value
        const actualDropIndex = pageOffset + dropIndex

        // Create a copy of the filtered testimonials array
        const reorderedTestimonials = [...filteredTestimonials.value]

        // Remove the dragged item
        const [draggedItem] = reorderedTestimonials.splice(actualDraggedIndex, 1)

        // Insert it at the new position
        if (draggedItem) reorderedTestimonials.splice(actualDropIndex, 0, draggedItem)

        // Update orders
        const updatedTestimonials = reorderedTestimonials.map((testimonial, index) => ({
            id: testimonial.id,
            order: index
        }))

        // Optimistically update UI
        testimonials.value = reorderedTestimonials

        // Send to backend
        await testimonialsApi.reorderTestimonials(updatedTestimonials)

        showToast.success('Urutan testimoni berhasil diubah')

        // Refresh to get latest data
        await fetchTestimonials()
    } catch (error) {
        console.error('Error reordering testimonials:', error)
        showToast.error('Gagal mengubah urutan testimoni')
        // Revert on error
        await fetchTestimonials()
    } finally {
        draggedIndex.value = null
        dragOverIndex.value = null
    }
}

const handleDragEnd = () => {
    draggedIndex.value = null
    dragOverIndex.value = null
}

const openModal = (testimonial?: Testimonial) => {
    if (testimonial) {
        editMode.value = true
        editingId.value = testimonial.id
        formData.value = {
            id: testimonial.id,
            client_name: testimonial.client_name,
            institution: testimonial.institution || '',
            feedback: testimonial.feedback,
            date: testimonial.date,
        }
    } else {
        editMode.value = false
        editingId.value = null
        formData.value = {
            id: 0,
            client_name: '',
            institution: '',
            feedback: '',
            date: new Date().toISOString().split('T')[0] || '',
        }
    }
    errorMessage.value = ''
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
}

const handleSubmit = async () => {
    try {
        isSubmitting.value = true
        errorMessage.value = ''

        showLoading('Menyimpan...')

        const dataToSend = {
            client_name: formData.value.client_name,
            institution: formData.value.institution,
            feedback: formData.value.feedback,
            date: formData.value.date,
        }

        if (editMode.value && editingId.value) {
            await testimonialsApi.updateTestimonial(editingId.value, dataToSend)
            showToast.success('Testimoni berhasil diperbarui!')
        } else {
            // Set order as the first position (0), existing items will shift
            const dataWithOrder = {
                ...dataToSend,
                order: 0
            }
            await testimonialsApi.createTestimonial(dataWithOrder as any)
            showToast.success('Testimoni berhasil ditambahkan!')
        }

        await fetchTestimonials()
        closeModal()
    } catch (error) {
        console.error('Error saving testimonial:', error)
        const axiosError = error as { response?: { data?: { message?: string } } }
        const message = axiosError.response?.data?.message || 'Gagal menyimpan testimoni'
        errorMessage.value = message
        showToast.error(message)
    } finally {
        isSubmitting.value = false
    }
}

const confirmDelete = async (testimonial: Testimonial) => {
    const result = await showDeleteConfirm('Yakin ingin menghapus testimoni ini?')
    if (result) {
        try {
            showLoading('Menghapus...')
            await testimonialsApi.deleteTestimonial(testimonial.id)
            closeLoading()
            showToast.success('Testimoni berhasil dihapus!')
            await fetchTestimonials()
        } catch (error) {
            console.error('Error deleting testimonial:', error)
            closeLoading()
            showToast.error('Gagal menghapus testimoni')
        }
    }
}

const deleteTestimonial = async (item: any) => {
    try {
        showLoading('Menghapus...')
        await testimonialsApi.deleteTestimonial(item.id)
        closeLoading()
        showToast.success('Data berhasil dihapus!')
        await fetchTestimonials()
    } catch (error) {
        console.error('Error deleting:', error)
        closeLoading()
        showToast.error('Gagal menghapus data')
    }
}

// Watch searchQuery to reset pagination
watch(searchQuery, () => {
    currentPage.value = 1
})

// Watch currentPage to scroll to top when pagination changes
watch(currentPage, () => {
    window.scrollTo({ top: 0, behavior: 'smooth' })
})

onMounted(() => {
    fetchTestimonials()
})
</script>

<style scoped>
[draggable="true"] {
    touch-action: none;
    user-select: none;
}
</style>
