<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="pt-5 sm:pt-24 md:pt-5 px-4 sm:px-6 lg:px-2">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Client</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-2">Kelola daftar client perusahaan Anda - Drag & drop untuk
                mengubah urutan</p>
        </div>

        <!-- Action Bar -->
        <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex-1 sm:max-w-md relative">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input v-model="searchQuery" type="text" placeholder="Cari client..."
                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" />
            </div>
            <button @click="openModal()"
                class="px-4 sm:px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-plus text-sm"></i>
                <span class="hidden sm:inline">Tambah Client</span>
                <span class="sm:hidden">Tambah</span>
            </button>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <SkeletonLoader type="table" :rows="10" :columns="3" />
        </div>

        <!-- Clients Grid with Drag and Drop -->
        <div v-else-if="filteredClients.length > 0"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 min-h-[520px] items-start">
            <template v-for="(client, index) in paginatedClients" :key="client.id">
                <!-- Client Card -->
                <div draggable="true" @dragstart="handleDragStart(index, $event)" @dragover="handleDragOver($event)"
                    @dragenter="handleDragEnter(index)" @dragleave="handleDragLeave" @drop="handleDrop(index, $event)"
                    @dragend="handleDragEnd"
                    class="group relative bg-white rounded-xl shadow-sm hover:shadow-lg overflow-hidden cursor-move transition-shadow duration-200 h-[240px] flex flex-col"
                    :class="{
                        'ring-2 ring-primary': dragOverIndex === index && draggedIndex !== null && draggedIndex !== index
                    }">

                    <!-- Client Logo -->
                    <div class="relative h-32 sm:h-40 bg-gray-100 overflow-hidden flex items-center justify-center p-4">
                        <img v-if="client.logo_url" :src="client.logo_url" :alt="client.client_name"
                            class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-300"
                            @error="handleImageError" />
                        <div v-else class="text-gray-400 text-xs sm:text-sm">Tidak ada logo</div>
                        <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex gap-2 z-20">
                            <button @click="openModal(client)"
                                class="p-1.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition shadow-lg"
                                title="Edit">
                                <i class="fa-solid fa-pen text-sm"></i>
                            </button>
                            <button @click="confirmDelete(client)"
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
                    </div>

                    <!-- Client Info -->
                    <div class="p-4 sm:p-5">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 line-clamp-1">
                            {{ client.client_name }}
                        </h3>
                    </div>
                </div>
            </template>
        </div>

        <!-- Pagination -->
        <div v-if="!isLoading && filteredClients.length > 0" class="flex justify-center items-center gap-2 mt-6 mb-8">
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
        <div v-else-if="!isLoading && filteredClients.length === 0" class="text-center py-12 sm:py-20">
            <i class="fa-solid fa-users text-gray-400 mx-auto mb-4 text-4xl sm:text-5xl"></i>
            <p class="text-gray-600 text-base sm:text-lg">Belum ada client</p>
            <button @click="openModal()"
                class="mt-4 px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                Tambah Client Pertama
            </button>
        </div>

        <!-- Modal Form -->
        <div v-if="showModal"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 overflow-y-auto"
            @click.self="closeModal">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg sm:max-w-2xl my-8">
                <div
                    class="sticky top-0 bg-white border-b px-4 sm:px-6 py-4 flex justify-between items-center rounded-t-xl">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                        {{ editMode ? 'Edit Client' : 'Tambah Client Baru' }}
                    </h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form @submit.prevent="handleSubmit" novalidate
                    class="p-4 sm:p-6 space-y-5 max-h-[calc(90vh-100px)] overflow-y-auto">
                    <!-- Nama Client -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Client <span class="text-red-500">*</span>
                        </label>
                        <input v-model="formData.client_name" type="text" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Contoh: PT Sejahtera Indonesia" />
                    </div>

                    <!-- Manual Order Input (Mobile Only) -->
                    <div class="md:hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan Client (Opsional)
                        </label>
                        <input v-model.number="formData.order" type="number"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="1, 2, 3, dst... (kosongkan untuk otomatis)" />
                        <p class="text-xs text-gray-500 mt-1">Kosongkan untuk menambahkan di urutan paling akhir</p>
                    </div>

                    <!-- Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Logo {{ !editMode ? '*' : '' }}
                        </label>
                        <ImageUpload v-model="logoFile" label="Upload Logo" accept="image/*" :max-size="104857600"
                            :current-image-url="currentLogoUrl || undefined" :responsive-preview="true" />
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
                                editMode ? 'Simpan Perubahan' : 'Tambah Client'
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
import { clientsApi } from '@/services'
import type { OurClient } from '@/types/models'
import ImageUpload from '@/components/common/ImageUpload.vue'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
import { showToast, showDeleteConfirm, showLoading, closeLoading } from '@/utils/sweetalert'

const clients = ref<OurClient[]>([])
const isLoading = ref(true)
const searchQuery = ref('')
const showModal = ref(false)
const editMode = ref(false)
const isSubmitting = ref(false)
const errorMessage = ref('')
const logoFile = ref<File | null>(null)
const currentLogoUrl = ref<string | null>(null)

const formData = ref({
    client_name: '',
    order: 0,
})

const editingId = ref<number | null>(null)

// Drag and drop state
const draggedIndex = ref<number | null>(null)
const dragOverIndex = ref<number | null>(null)

// Pagination state
const currentPage = ref(1)
const itemsPerPage = ref(8)

const filteredClients = computed(() => {
    if (!searchQuery.value) return clients.value
    const query = searchQuery.value.toLowerCase()
    return clients.value.filter(
        (c) =>
            c.client_name.toLowerCase().includes(query) ||
            (c.institution && c.institution.toLowerCase().includes(query)),
    )
})

const totalPages = computed(() => {
    return Math.ceil(filteredClients.value.length / itemsPerPage.value)
})

const paginatedClients = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    const end = start + itemsPerPage.value
    return filteredClients.value.slice(start, end)
})

const fetchClients = async () => {
    try {
        isLoading.value = true
        const data = await clientsApi.getClients()
        clients.value = data.sort((a, b) => (a.order || 0) - (b.order || 0))
    } catch (error) {
        console.error('Error fetching clients:', error)
        showToast.error('Gagal memuat data client')
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
        const reordered = [...clients.value]
        const item = reordered.splice(actualDraggedIndex, 1)[0]
        if (item) reordered.splice(actualDropIndex, 0, item)

        clients.value = reordered

        const payload = reordered.map((client, index) => ({
            id: client.id,
            order: index + 1
        }))

        await clientsApi.reorderClients(payload)
        showToast.success('Urutan client berhasil diubah')
    } catch (error) {
        console.error('Error reordering clients:', error)
        showToast.error('Gagal mengubah urutan client')
        await fetchClients()
    } finally {
        draggedIndex.value = null
        dragOverIndex.value = null
    }
}

const handleDragEnd = () => {
    draggedIndex.value = null
    dragOverIndex.value = null
}

const openModal = (client?: OurClient) => {
    if (client) {
        editMode.value = true
        editingId.value = client.id
        formData.value = {
            client_name: client.client_name,
            order: client.order || 0,
        }
        currentLogoUrl.value = client.logo_url || null
    } else {
        editMode.value = false
        editingId.value = null
        formData.value = {
            client_name: '',
            order: 0,
        }
        currentLogoUrl.value = null
    }
    logoFile.value = null
    errorMessage.value = ''
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
    logoFile.value = null
    currentLogoUrl.value = null
}

const handleSubmit = async () => {
    try {
        isSubmitting.value = true
        errorMessage.value = ''

        // Manual validation for required fields
        if (!formData.value.client_name || !formData.value.client_name.trim()) {
            errorMessage.value = 'Nama client wajib diisi'
            isSubmitting.value = false
            return
        }

        const formDataToSend = new FormData()
        formDataToSend.append('client_name', formData.value.client_name)
        if (formData.value.order > 0) {
            formDataToSend.append('order', String(formData.value.order))
        }

        if (logoFile.value) {
            formDataToSend.append('logo_path', logoFile.value)
        }

        if (editMode.value && editingId.value) {
            showLoading('Menyimpan...')
            await clientsApi.updateClient(editingId.value, formDataToSend)
            showToast.success('Client berhasil diperbarui!')
        } else {
            if (!logoFile.value) {
                closeLoading()
                errorMessage.value = 'Logo wajib diisi'
                isSubmitting.value = false
                return
            }
            // Set order as the first position (0), existing items will shift
            formDataToSend.append('order', '0')
            showLoading('Menyimpan...')
            await clientsApi.createClient(formDataToSend)
            showToast.success('Client berhasil ditambahkan!')
        }

        await fetchClients()
        closeModal()
    } catch (error) {
        console.error('Error saving client:', error)
        const axiosError = error as { response?: { data?: { message?: string } } }
        const message = axiosError.response?.data?.message || 'Gagal menyimpan client'
        errorMessage.value = message
        showToast.error(message)
    } finally {
        isSubmitting.value = false
        closeLoading()
    }
}

const confirmDelete = async (client: OurClient) => {
    const result = await showDeleteConfirm('Yakin ingin menghapus client ini?')
    if (result) {
        try {
            showLoading('Menghapus...')
            await clientsApi.deleteClient(client.id)
            closeLoading()
            showToast.success('Data berhasil dihapus!')
            await fetchClients()
        } catch (error) {
            console.error('Error deleting client:', error)
            closeLoading()
            showToast.error('Gagal menghapus data')
        }
    }
}

const handleImageError = (event: Event) => {
    const target = event.target as HTMLImageElement
    target.src = 'https://placehold.co/400x200/e5e7eb/6b7280?text=No+Logo'
}

// Watch searchQuery to reset pagination
watch(searchQuery, () => {
    currentPage.value = 1
})

onMounted(() => {
    fetchClients()
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
    min-height: 240px;
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
