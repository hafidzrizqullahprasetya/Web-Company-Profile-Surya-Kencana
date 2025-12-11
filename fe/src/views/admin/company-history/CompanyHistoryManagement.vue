<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="pt-5 sm:pt-24 md:pt-5 px-4 sm:px-6 lg:px-2">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Riwayat Perusahaan</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-2">Kelola riwayat perusahaan Anda - Drag & drop untuk
                mengubah urutan</p>
        </div>

        <!-- Action Bar -->
        <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex-1 sm:max-w-md relative">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input v-model="searchQuery" type="text" placeholder="Cari riwayat..."
                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" />
            </div>
            <button @click="openModal()"
                class="px-4 sm:px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-plus text-sm"></i>
                <span class="hidden sm:inline">Tambah Riwayat</span>
                <span class="sm:hidden">Tambah</span>
            </button>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <SkeletonLoader type="table" :rows="10" :columns="5" />
        </div>

        <!-- Histories Grid with Drag and Drop -->
        <div v-else-if="filteredHistories.length > 0"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 min-h-[580px] items-start">
            <template v-for="(history, index) in paginatedHistories" :key="history.id">
                <!-- History Card -->
                <div draggable="true" @dragstart="handleDragStart(index, $event)" @dragover="handleDragOver($event)"
                    @dragenter="handleDragEnter(index)" @dragleave="handleDragLeave" @drop="handleDrop(index, $event)"
                    @dragend="handleDragEnd"
                    class="group relative bg-white rounded-xl shadow-sm hover:shadow-lg overflow-hidden cursor-move transition-shadow duration-200 h-[270px] flex flex-col"
                    :class="{
                        'ring-2 ring-primary': dragOverIndex === index && draggedIndex !== null && draggedIndex !== index
                    }">

                    <!-- History Image - Fixed Height -->
                    <div class="relative h-40 bg-gray-200 overflow-hidden flex-shrink-0">
                        <img :src="history.image_url || 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'"
                            :alt="history.judul"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            @error="handleImageError" />
                        <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex gap-2 z-20">
                            <button @click="openModal(history)"
                                class="p-1.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition shadow-lg"
                                title="Edit">
                                <i class="fa-solid fa-pen text-sm"></i>
                            </button>
                            <button @click="confirmDelete(history)"
                                class="p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-lg"
                                title="Hapus">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                        </div>
                        <!-- Order Badge -->
                        <div class="absolute top-2 sm:top-3 left-2 sm:left-3 z-20">
                            <span class="px-2 py-1 bg-primary text-white text-xs font-bold rounded-lg shadow-lg">
                                #{{ (currentPage - 1) * itemsPerPage + index + 1 }}
                            </span>
                        </div>
                        <!-- Year Badge -->
                        <div class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3 z-20">
                            <span class="px-3 py-1 bg-white text-primary text-sm font-bold rounded-lg shadow-lg">
                                {{ history.tahun }}
                            </span>
                        </div>
                    </div>

                    <!-- History Info -->
                    <div class="p-4 sm:p-5">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ history.judul }}
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 line-clamp-2">{{ history.deskripsi }}</p>
                    </div>
                </div>
            </template>
        </div>

        <!-- Pagination -->
        <div v-if="!isLoading && filteredHistories.length > 0" class="flex justify-center items-center gap-2 mt-6 mb-8">
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
        <div v-else-if="!isLoading && filteredHistories.length === 0" class="text-center py-12 sm:py-20">
            <i class="fa-solid fa-clock-rotate-left text-gray-400 mx-auto mb-4 text-4xl sm:text-5xl"></i>
            <p class="text-gray-600 text-base sm:text-lg">Belum ada riwayat</p>
            <button @click="openModal()"
                class="mt-4 px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                Tambah Riwayat Pertama
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
                        {{ editMode ? 'Edit Riwayat' : 'Tambah Riwayat Baru' }}
                    </h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form @submit.prevent="handleSubmit"
                    class="p-4 sm:p-6 space-y-5 max-h-[calc(90vh-100px)] overflow-y-auto">
                    <!-- Tahun -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun <span class="text-red-500">*</span>
                        </label>
                        <input v-model.number="formData.tahun" type="number" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="2024" />
                    </div>

                    <!-- Manual Order Input (Mobile Only) -->
                    <div class="md:hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan Riwayat <span class="text-red-500">*</span>
                        </label>
                        <input v-model.number="formData.order" type="number"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="1, 2, 3, dst..." />
                        <p class="text-xs text-gray-500 mt-1">Masukkan nomor urutan riwayat (1 = paling depan)</p>
                    </div>

                    <!-- Judul -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input v-model="formData.judul" type="text" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Contoh: Peluncuran Produk Baru" />
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea v-model="formData.deskripsi" required rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Deskripsikan riwayat perusahaan..."></textarea>
                    </div>

                    <!-- Gambar Utama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Utama {{ !editMode ? '*' : '' }}
                        </label>
                        <ImageUpload v-model="imageFile" label="Upload Gambar" accept="image/*" :max-size="104857600"
                            :current-image-url="currentImageUrl || undefined" />
                    </div>

                    <!-- Gambar Album -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Album (Opsional)
                        </label>

                        <!-- Existing Images -->
                        <div v-if="existingImages.length > 0" class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Gambar yang sudah ada:</p>
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                <div v-for="(img, index) in existingImages" :key="index" class="relative group">
                                    <img :src="img"
                                        class="w-full aspect-square object-cover rounded-lg border-2 border-gray-200" />
                                    <button type="button" @click="removeExistingImage(index)"
                                        class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- New Images Upload -->
                        <div>
                            <input type="file" ref="multipleImagesInput" multiple accept="image/*"
                                @change="handleMultipleImagesSelect" class="hidden" />
                            <button type="button" @click="($refs.multipleImagesInput as any).click()"
                                class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-primary/5 transition text-gray-600 hover:text-primary">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl mx-auto mb-1"></i>
                                <p class="text-sm">Upload Gambar Album</p>
                            </button>
                            <p class="text-xs text-gray-500 mt-1">Maks. 100MB per gambar</p>

                            <!-- Preview New Images -->
                            <div v-if="newImageFiles.length > 0" class="mt-3 grid grid-cols-3 sm:grid-cols-4 gap-2">
                                <div v-for="(file, index) in newImageFiles" :key="index" class="relative group">
                                    <img :src="getPreviewUrl(file)"
                                        class="w-full aspect-square object-cover rounded-lg border-2 border-primary" />
                                    <button type="button" @click="removeNewImage(index)"
                                        class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
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
                                editMode ? 'Simpan Perubahan' : 'Tambah Riwayat'
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
import { companyHistoryApi } from '@/services'
import type { CompanyHistory } from '@/types/models'
import ImageUpload from '@/components/common/ImageUpload.vue'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
import { useImageHandling } from '@/composables'
import { showToast, showDeleteConfirm, showLoading, closeLoading } from '@/utils/sweetalert'

const { getPreviewUrl } = useImageHandling()

const histories = ref<CompanyHistory[]>([])
const isLoading = ref(true)
const searchQuery = ref('')
const showModal = ref(false)
const editMode = ref(false)
const isSubmitting = ref(false)
const errorMessage = ref('')
const imageFile = ref<File | null>(null)
const currentImageUrl = ref<string | null>(null)

const newImageFiles = ref<File[]>([])
const existingImages = ref<string[]>([])
const imagesToDelete = ref<string[]>([])

const formData = ref({
    tahun: new Date().getFullYear(),
    judul: '',
    deskripsi: '',
    order: 0,
})

const editingId = ref<number | null>(null)

// Drag and drop state
const draggedIndex = ref<number | null>(null)
const dragOverIndex = ref<number | null>(null)

// Pagination state
const currentPage = ref(1)
const itemsPerPage = ref(8)

const filteredHistories = computed(() => {
    if (!searchQuery.value) return histories.value
    const query = searchQuery.value.toLowerCase()
    return histories.value.filter(
        (h) =>
            h.judul.toLowerCase().includes(query) ||
            h.deskripsi.toLowerCase().includes(query) ||
            h.tahun.toString().includes(query),
    )
})

const totalPages = computed(() => {
    return Math.ceil(filteredHistories.value.length / itemsPerPage.value)
})

const paginatedHistories = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    const end = start + itemsPerPage.value
    return filteredHistories.value.slice(start, end)
})

const fetchHistories = async () => {
    try {
        isLoading.value = true
        const data = await companyHistoryApi.getCompanyHistories()
        histories.value = data.sort((a, b) => (a.order || 0) - (b.order || 0))
    } catch (error) {
        console.error('Error fetching histories:', error)
        showToast.error('Gagal memuat data riwayat')
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
    if (draggedIndex.value !== null && draggedIndex.value !== index) {
        dragOverIndex.value = index
    }
}

const handleDragLeave = () => {
    dragOverIndex.value = null
}

const handleDrop = async (dropIndex: number, event: DragEvent) => {
    event.preventDefault()

    if (draggedIndex.value === null || draggedIndex.value === dropIndex) {
        draggedIndex.value = null
        dragOverIndex.value = null
        return
    }

    try {
        const dragIdx = draggedIndex.value
        const dropIdx = dropIndex
        const pageOffset = (currentPage.value - 1) * itemsPerPage.value
        const actualDraggedIndex = pageOffset + dragIdx
        const actualDropIndex = pageOffset + dropIdx

        // Simple swap
        const reordered = [...histories.value]
        const [item] = reordered.splice(actualDraggedIndex, 1)
        if (item) {
            reordered.splice(actualDropIndex, 0, item)
        }

        histories.value = reordered

        const payload = reordered.map((history, index) => ({
            id: history.id,
            order: index + 1
        }))

        await companyHistoryApi.reorderCompanyHistories(payload)
        showToast.success('Urutan riwayat berhasil diubah')
    } catch (error) {
        console.error('Error reordering histories:', error)
        showToast.error('Gagal mengubah urutan riwayat')
        await fetchHistories()
    } finally {
        draggedIndex.value = null
        dragOverIndex.value = null
    }
}

const handleDragEnd = () => {
    draggedIndex.value = null
    dragOverIndex.value = null
}

const openModal = (history?: CompanyHistory) => {
    if (history) {
        editMode.value = true
        editingId.value = history.id
        formData.value = {
            tahun: history.tahun,
            judul: history.judul,
            deskripsi: history.deskripsi,
            order: history.order || 0,
        }
        currentImageUrl.value = history.image_url || null
        existingImages.value = history.image_urls || []
    } else {
        editMode.value = false
        editingId.value = null
        formData.value = {
            tahun: new Date().getFullYear(),
            judul: '',
            deskripsi: '',
            order: 0,
        }
        currentImageUrl.value = null
        existingImages.value = []
    }
    imageFile.value = null
    newImageFiles.value = []
    imagesToDelete.value = []
    errorMessage.value = ''
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
    imageFile.value = null
    currentImageUrl.value = null
    newImageFiles.value = []
    existingImages.value = []
    imagesToDelete.value = []
}

const handleMultipleImagesSelect = (event: Event) => {
    const target = event.target as HTMLInputElement
    if (target.files) {
        const files = Array.from(target.files)
        const MAX_SIZE = 104857600

        const validFiles = files.filter((file) => {
            if (file.size > MAX_SIZE) {
                showToast.error(`File ${file.name} terlalu besar (maks. 100MB)`)
                return false
            }
            return true
        })

        newImageFiles.value = [...newImageFiles.value, ...validFiles]
    }
    target.value = ''
}

const removeNewImage = (index: number) => {
    newImageFiles.value = newImageFiles.value.filter((_, i) => i !== index)
}

const removeExistingImage = (index: number) => {
    const imageUrl = existingImages.value[index]
    if (imageUrl) {
        const pathMatch = imageUrl.match(/\/storage\/(.+)$/)
        if (pathMatch && pathMatch[1]) {
            imagesToDelete.value.push(pathMatch[1])
        }
    }
    existingImages.value = existingImages.value.filter((_, i) => i !== index)
}

const handleSubmit = async () => {
    try {
        isSubmitting.value = true
        errorMessage.value = ''

        showLoading('Menyimpan...')

        const formDataToSend = new FormData()
        formDataToSend.append('tahun', String(formData.value.tahun))
        formDataToSend.append('judul', formData.value.judul)
        formDataToSend.append('deskripsi', formData.value.deskripsi)
        formDataToSend.append('order', String(formData.value.order))

        if (imageFile.value) {
            formDataToSend.append('image', imageFile.value)
        }

        if (newImageFiles.value.length > 0) {
            newImageFiles.value.forEach((file) => {
                formDataToSend.append('images[]', file)
            })
        }

        if (imagesToDelete.value.length > 0) {
            imagesToDelete.value.forEach((path) => {
                formDataToSend.append('deleted_images[]', path)
            })
        }

        if (editMode.value && editingId.value) {
            formDataToSend.append('_method', 'PUT')
            await companyHistoryApi.updateCompanyHistory(editingId.value, formDataToSend)
            showToast.success('Riwayat berhasil diperbarui!')
        } else {
            if (!imageFile.value) {
                errorMessage.value = 'Gambar utama wajib diisi'
                return
            }
            // Set order as the first position (0), existing items will shift
            formDataToSend.append('order', '0')
            await companyHistoryApi.createCompanyHistory(formDataToSend)
            showToast.success('Riwayat berhasil ditambahkan!')
        }

        await fetchHistories()
        closeModal()
    } catch (error) {
        console.error('Error saving history:', error)
        const axiosError = error as { response?: { data?: { message?: string } } }
        const message = axiosError.response?.data?.message || 'Gagal menyimpan riwayat'
        errorMessage.value = message
        showToast.error(message)
    } finally {
        isSubmitting.value = false
    }
}

const confirmDelete = async (history: CompanyHistory) => {
    const confirmed = await showDeleteConfirm(
        'Hapus Riwayat',
        `Apakah Anda yakin ingin menghapus riwayat tahun ${history.tahun}?`
    )

    if (confirmed) {
        await deleteHistory(history)
    }
}

const deleteHistory = async (history: CompanyHistory) => {
    try {
        showLoading('Menghapus...')
        await companyHistoryApi.deleteCompanyHistory(history.id)
        closeLoading()
        showToast.success('Data berhasil dihapus!')
        await fetchHistories()
    } catch (error) {
        console.error('Error deleting:', error)
        closeLoading()
        showToast.error('Gagal menghapus data')
    }
}

const handleImageError = (event: Event) => {
    const target = event.target as HTMLImageElement
    target.src = 'https://placehold.co/800x600/e5e7eb/6b7280?text=No+Image'
}

// Watch searchQuery to reset pagination
watch(searchQuery, () => {
    currentPage.value = 1
})

onMounted(() => {
    fetchHistories()
})
</script>

<style scoped>
[draggable="true"] {
    touch-action: none;
    user-select: none;
    cursor: grab;
    will-change: transform, opacity;
}

[draggable="true"]:active {
    cursor: grabbing !important;
}

/* Placeholder slot styling */
.placeholder-slot {
    min-height: 320px;
    position: relative;
    overflow: hidden;
}

.placeholder-slot::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg,
            transparent,
            rgba(139, 69, 19, 0.1),
            transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% {
        left: -100%;
    }

    100% {
        left: 100%;
    }
}

/* Pulse animation for placeholder */
@keyframes pulse-slow {

    0%,
    100% {
        opacity: 1;
        transform: scale(1);
    }

    50% {
        opacity: 0.8;
        transform: scale(0.98);
    }
}

.animate-pulse-slow {
    animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Bounce subtle animation for drag handle */
@keyframes bounce-subtle {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-3px);
    }
}

.animate-bounce-subtle {
    animation: bounce-subtle 2s ease-in-out infinite;
}

/* Enhanced shadow transitions */
.shadow-sm,
.shadow-lg,
.shadow-xl,
.shadow-2xl {
    transition: box-shadow 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.35), 0 0 30px 0 rgba(139, 69, 19, 0.1);
}

/* GPU acceleration for smoother animations */
.group {
    transform: translateZ(0);
    backface-visibility: hidden;
}

/* Smooth gradient animation */
@keyframes gradient-shift {

    0%,
    100% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }
}

.bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}
</style>
