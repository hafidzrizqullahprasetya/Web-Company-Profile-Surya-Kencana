<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="pt-5 sm:pt-24 md:pt-5 px-4 sm:px-6 lg:px-2">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Produk</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-2">Kelola produk mesin industri Anda - Drag & drop untuk
                mengubah urutan</p>
        </div>

        <!-- Action Bar -->
        <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex-1 sm:max-w-md relative">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input v-model="searchQuery" type="text" placeholder="Cari produk..."
                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" />
            </div>
            <button @click="openModal()"
                class="px-4 sm:px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-plus text-sm"></i>
                <span class="hidden sm:inline">Tambah Produk</span>
                <span class="sm:hidden">Tambah</span>
            </button>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <SkeletonLoader type="table" :rows="10" :columns="5" />
        </div>

        <!-- Products Grid with Drag and Drop -->
        <div v-else-if="filteredProducts.length > 0"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            <template v-for="(product, index) in paginatedProducts" :key="product.id">
                <!-- Product Card with Drag & Drop -->
                <div draggable="true" @dragstart="handleDragStart(index, $event)" @dragover="handleDragOver($event)"
                    @dragenter="handleDragEnter(index)" @dragleave="handleDragLeave" @drop="handleDrop(index, $event)"
                    @dragend="handleDragEnd"
                    class="group relative bg-white rounded-xl shadow-sm hover:shadow-lg overflow-hidden cursor-move transition-shadow duration-200"
                    :class="{
                        'ring-2 ring-primary': dragOverIndex === index && draggedIndex !== null && draggedIndex !== index
                    }">

                    <!-- Product Image -->
                    <div class="relative h-48 sm:h-56 bg-gray-200 overflow-hidden">
                        <img :src="getImageUrl(product.image_path || '')" :alt="product.name"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            @error="handleImageError" />
                        <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex gap-2 z-20">
                            <button @click="openModal(product)"
                                class="p-1.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition shadow-lg"
                                title="Edit">
                                <i class="fa-solid fa-pen text-sm"></i>
                            </button>
                            <button @click="confirmDelete(product)"
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

                    <!-- Product Info -->
                    <div class="p-4 sm:p-5">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ product.name }}
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 line-clamp-2">{{ product.description }}</p>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-lg sm:text-xl font-bold text-primary">{{
                                    formatPrice(product.price) }}</span>
                            </div>
                            <div v-if="product.hide_price"
                                class="flex items-center gap-1.5 text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded">
                                <i class="fa-solid fa-eye-slash"></i>
                                <span>Harga disembunyikan di publik</span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Pagination -->
        <div v-if="!isLoading && filteredProducts.length > 0" class="flex justify-center items-center gap-2 mt-8 mb-8">
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
        <div v-else-if="!isLoading && filteredProducts.length === 0" class="text-center py-12 sm:py-20">
            <i class="fa-solid fa-box text-gray-400 mx-auto mb-4 text-4xl sm:text-5xl"></i>
            <p class="text-gray-600 text-base sm:text-lg">Belum ada produk</p>
            <button @click="openModal()"
                class="mt-4 px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                Tambah Produk Pertama
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
                        {{ editMode ? 'Edit Produk' : 'Tambah Produk Baru' }}
                    </h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form @submit.prevent="handleSubmit" novalidate
                    class="p-4 sm:p-6 space-y-5 max-h-[calc(90vh-100px)] overflow-y-auto">
                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input v-model="formData.name" type="text" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Contoh: Mesin CNC 5 Axis" />
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input v-model.number="formData.price" type="number" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="250000000" />

                        <!-- Checkbox Sembunyikan Harga -->
                        <div class="mt-3 flex items-center gap-2 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <input v-model="formData.hide_price" type="checkbox" id="hide_price"
                                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary flex-shrink-0" />
                            <label for="hide_price" class="text-sm text-gray-700 cursor-pointer">
                                <span class="font-medium">Sembunyikan harga</span>
                                <span class="text-gray-600"> - harga tidak akan ditampilkan di halaman publik</span>
                            </label>
                        </div>
                    </div>

                    <!-- Manual Order Input (Mobile Only) -->
                    <div class="md:hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan Produk (Opsional)
                        </label>
                        <input v-model.number="formData.order" type="number" min="1"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="1, 2, 3, dst... (kosongkan untuk otomatis)" />
                        <p class="text-xs text-gray-500 mt-1">Kosongkan untuk menambahkan di urutan paling akhir</p>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea v-model="formData.description" required rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Deskripsikan produk Anda..."></textarea>
                    </div>

                    <!-- Gambar Produk -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Produk {{ !editMode ? '*' : '' }}
                        </label>
                        <ImageUpload v-model="imageFile" label="Upload Gambar" accept="image/*" :max-size="104857600"
                            :current-image-url="currentImageUrl || undefined" />
                    </div>

                    <!-- Gambar Album (Multiple Images) -->
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
                            <button type="button" @click="($refs.multipleImagesInput as HTMLInputElement).click()"
                                class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-primary/5 transition text-gray-600 hover:text-primary">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl mx-auto mb-1"></i>
                                <p class="text-sm">Upload Gambar</p>
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
                                editMode ? 'Simpan Perubahan' : 'Tambah Produk'
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
import { productsApi } from '@/services'
import type { Product } from '@/types/models'
import ImageUpload from '@/components/common/ImageUpload.vue'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
import { useImageUrl, useFormatting, useImageHandling } from '@/composables'
import { showToast, showDeleteConfirm, showLoading, closeLoading } from '@/utils/sweetalert'

const { getImageUrl } = useImageUrl()
const { formatPrice } = useFormatting()
const { getPreviewUrl } = useImageHandling()

const products = ref<Product[]>([])
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
    name: '',
    price: 0,
    description: '',
    hide_price: false,
    order: 0,
})

const editingId = ref<number | null>(null)

const draggedIndex = ref<number | null>(null)
const dragOverIndex = ref<number | null>(null)

const currentPage = ref(1)
const itemsPerPage = ref(8)

const filteredProducts = computed(() => {
    if (!searchQuery.value) return products.value
    const query = searchQuery.value.toLowerCase()
    return products.value.filter(
        (p) => p.name.toLowerCase().includes(query) || (p.description || '').toLowerCase().includes(query.toLowerCase()),
    )
})

const totalPages = computed(() => {
    return Math.ceil(filteredProducts.value.length / itemsPerPage.value)
})

const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    const end = start + itemsPerPage.value
    return filteredProducts.value.slice(start, end)
})

const fetchProducts = async () => {
    try {
        isLoading.value = true
        const data = await productsApi.getProducts()
        products.value = data.sort((a, b) => (a.order || 0) - (b.order || 0))
    } catch (error) {
        console.error('Error fetching products:', error)
        showToast.error('Gagal memuat data produk')
    } finally {
        isLoading.value = false
    }
}

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

        const reordered = [...products.value]
        const item = reordered.splice(actualDraggedIndex, 1)[0]
        if (item) reordered.splice(actualDropIndex, 0, item)

        products.value = reordered

        const payload = reordered.map((product, index) => ({
            id: product.id,
            order: index + 1
        }))

        await productsApi.reorderProducts(payload)
        showToast.success('Urutan produk berhasil diubah')
    } catch (error) {
        showToast.error('Gagal mengubah urutan produk')
        await fetchProducts()
    } finally {
        draggedIndex.value = null
        dragOverIndex.value = null
    }
}

const handleDragEnd = () => {
    draggedIndex.value = null
    dragOverIndex.value = null
}

const openModal = (product?: Product) => {
    if (product) {
        editMode.value = true
        editingId.value = product.id
        formData.value = {
            name: product.name,
            price: product.price,
            description: product.description || '',
            hide_price: !!product.hide_price,
            order: product.order || 0,
        }
        currentImageUrl.value = product.image_path ? getImageUrl(product.image_path) : null
        existingImages.value = product.image_urls || []
    } else {
        editMode.value = false
        editingId.value = null
        formData.value = {
            name: '',
            price: 0,
            description: '',
            hide_price: false,
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

        // Manual validation for required fields
        if (!formData.value.name || !formData.value.name.trim()) {
            errorMessage.value = 'Nama produk wajib diisi'
            isSubmitting.value = false
            return
        }

        // Skip price validation if hide_price is enabled
        if (!formData.value.hide_price && (!formData.value.price || formData.value.price < 0)) {
            errorMessage.value = 'Harga produk wajib diisi'
            isSubmitting.value = false
            return
        }

        if (!formData.value.description || !formData.value.description.trim()) {
            errorMessage.value = 'Deskripsi produk wajib diisi'
            isSubmitting.value = false
            return
        }

        showLoading('Menyimpan produk...')

        const formDataToSend = new FormData()
        formDataToSend.append('name', formData.value.name)
        formDataToSend.append('price', String(formData.value.price))
        formDataToSend.append('description', formData.value.description)
        formDataToSend.append('hide_price', formData.value.hide_price ? '1' : '0')
        if (formData.value.order > 0) {
            formDataToSend.append('order', String(formData.value.order))
        }

        if (imageFile.value) {
            formDataToSend.append('image_path', imageFile.value)
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
            await productsApi.updateProduct(editingId.value, formDataToSend)
            closeLoading()
            showToast.success('Produk berhasil diperbarui!')
        } else {
            if (!imageFile.value) {
                closeLoading()
                errorMessage.value = 'Gambar produk wajib diisi'
                showToast.error('Gambar produk wajib diisi')
                return
            }
            formDataToSend.append('order', String(products.value.length))
            await productsApi.createProduct(formDataToSend)
            closeLoading()
            showToast.success('Produk berhasil ditambahkan!')
        }

        await fetchProducts()
        closeModal()
    } catch (error) {
        console.error('Error saving product:', error)
        closeLoading()
        const axiosError = error as { response?: { data?: { message?: string } } }
        const message = axiosError.response?.data?.message || 'Gagal menyimpan produk'
        errorMessage.value = message
        showToast.error(message)
    } finally {
        isSubmitting.value = false
    }
}

const confirmDelete = async (product: Product) => {
    const confirmed = await showDeleteConfirm(product.name)
    if (confirmed) {
        await deleteProduct(product)
    }
}

const deleteProduct = async (product: Product) => {
    try {
        showLoading('Menghapus produk...')
        await productsApi.deleteProduct(product.id)
        closeLoading()
        showToast.success('Produk berhasil dihapus!')
        await fetchProducts()
    } catch (error) {
        console.error('Error deleting product:', error)
        closeLoading()
        showToast.error('Gagal menghapus produk')
    }
}

const handleImageError = (event: Event) => {
    const img = event.target as HTMLImageElement
    img.src = '/placeholder-image.jpg'
}

watch(searchQuery, () => {
    currentPage.value = 1
})

onMounted(() => {
    fetchProducts()
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

.placeholder-slot {
    min-height: 320px;
    position: relative;
}

.shadow-sm,
.shadow-lg,
.shadow-xl,
.shadow-2xl {
    transition: box-shadow 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.35), 0 0 30px 0 rgba(139, 69, 19, 0.1);
}

.group {
    transform: translateZ(0);
    backface-visibility: hidden;
}

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
