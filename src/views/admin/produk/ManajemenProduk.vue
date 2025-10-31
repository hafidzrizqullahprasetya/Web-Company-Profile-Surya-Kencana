<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Manajemen Produk</h1>
      <p class="text-gray-600 mt-2">Kelola produk mesin industri Anda</p>
    </div>

    <!-- Action Bar -->
    <div class="mb-6 flex justify-between items-center">
      <div class="flex-1 max-w-md">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari produk..."
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
        />
      </div>
      <button
        @click="openModal()"
        class="ml-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center gap-2"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Produk
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="flex justify-center items-center py-20">
      <div class="w-12 h-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
    </div>

    <!-- Products Grid -->
    <div v-else-if="filteredProducts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="product in filteredProducts"
        :key="product.id"
        class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group"
      >
        <!-- Product Image -->
        <div class="relative h-48 bg-gray-200 overflow-hidden">
          <img
            :src="getImageUrl(product.image_path)"
            :alt="product.name"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
            @error="handleImageError"
          />
          <div class="absolute top-3 right-3 flex gap-2">
            <button
              @click="openModal(product)"
              class="p-2 bg-white/90 text-primary rounded-lg hover:bg-white transition shadow-sm"
              title="Edit"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </button>
            <button
              @click="confirmDelete(product)"
              class="p-2 bg-white/90 text-red-500 rounded-lg hover:bg-white transition shadow-sm"
              title="Hapus"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Product Info -->
        <div class="p-5">
          <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ product.name }}</h3>
          <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ product.description }}</p>
          <div class="flex items-center justify-between">
            <span class="text-2xl font-bold text-primary">{{ formatPrice(product.price) }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-20">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <p class="text-gray-600 text-lg">Belum ada produk</p>
      <button
        @click="openModal()"
        class="mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition"
      >
        Tambah Produk Pertama
      </button>
    </div>

    <!-- Modal Form -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
      @click.self="closeModal"
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
          <h2 class="text-2xl font-bold text-gray-900">
            {{ editMode ? 'Edit Produk' : 'Tambah Produk Baru' }}
          </h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="handleSubmit" class="p-6 space-y-5">
          <!-- Nama Produk -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Nama Produk <span class="text-red-500">*</span>
            </label>
            <input
              v-model="formData.name"
              type="text"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              placeholder="Contoh: Mesin CNC 5 Axis"
            />
          </div>

          <!-- Harga -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Harga (Rp) <span class="text-red-500">*</span>
            </label>
            <input
              v-model.number="formData.price"
              type="number"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              placeholder="250000000"
            />
          </div>

          <!-- Deskripsi -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea
              v-model="formData.description"
              required
              rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
              placeholder="Deskripsikan produk Anda..."
            ></textarea>
          </div>

          <!-- Gambar Produk -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Gambar Produk {{ !editMode ? '*' : '' }}
            </label>
            <ImageUpload
              v-model="imageFile"
              label="Upload Gambar"
              accept="image/*"
              :max-size="104857600"
              :current-image-url="currentImageUrl || undefined"
            />
          </div>

          <!-- Error Message -->
          <div v-if="errorMessage" class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            {{ errorMessage }}
          </div>

          <!-- Actions -->
          <div class="flex gap-3 pt-4">
            <button
              type="button"
              @click="closeModal"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
            >
              Batal
            </button>
            <button
              type="submit"
              :disabled="isSubmitting"
              class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed transition"
            >
              <span v-if="!isSubmitting">{{ editMode ? 'Simpan Perubahan' : 'Tambah Produk' }}</span>
              <span v-else class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
              </span>
            </button>
          </div>
        </form>
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
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Produk?</h3>
          <p class="text-sm text-gray-500 mb-6">
            Apakah Anda yakin ingin menghapus produk <strong>{{ productToDelete?.name }}</strong>?
            Tindakan ini tidak dapat dibatalkan.
          </p>
          <div class="flex gap-3">
            <button
              @click="showDeleteModal = false"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
            >
              Batal
            </button>
            <button
              @click="deleteProduct"
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
import api, { type Product } from '@/services/api'
import ImageUpload from '@/components/common/ImageUpload.vue'
import { useToast } from '@/composables/useToast'

const toast = useToast()

const products = ref<Product[]>([])
const isLoading = ref(true)
const searchQuery = ref('')
const showModal = ref(false)
const showDeleteModal = ref(false)
const editMode = ref(false)
const isSubmitting = ref(false)
const isDeleting = ref(false)
const errorMessage = ref('')
const imageFile = ref<File | null>(null)
const currentImageUrl = ref<string | null>(null)
const productToDelete = ref<Product | null>(null)

const formData = ref({
  client_id: 1, // Default client_id (hidden from user)
  name: '',
  price: 0,
  description: '',
})

const editingId = ref<number | null>(null)

const filteredProducts = computed(() => {
  if (!searchQuery.value) return products.value
  const query = searchQuery.value.toLowerCase()
  return products.value.filter(p =>
    p.name.toLowerCase().includes(query) ||
    p.description.toLowerCase().includes(query)
  )
})

const fetchProducts = async () => {
  try {
    isLoading.value = true
    const data = await api.getProducts()
    products.value = data
  } catch (error) {
    console.error('Error fetching products:', error)
    toast.error('Gagal memuat data produk')
  } finally {
    isLoading.value = false
  }
}

const openModal = (product?: Product) => {
  if (product) {
    editMode.value = true
    editingId.value = product.id
    formData.value = {
      client_id: product.client_id,
      name: product.name,
      price: product.price,
      description: product.description,
    }
    currentImageUrl.value = product.image_path ? getImageUrl(product.image_path) : null
  } else {
    editMode.value = false
    editingId.value = null
    formData.value = {
      client_id: 1, // Default client_id
      name: '',
      price: 0,
      description: '',
    }
    currentImageUrl.value = null
  }
  imageFile.value = null
  errorMessage.value = ''
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  imageFile.value = null
  currentImageUrl.value = null
}

const handleSubmit = async () => {
  try {
    isSubmitting.value = true
    errorMessage.value = ''

    const formDataToSend = new FormData()
    formDataToSend.append('client_id', String(formData.value.client_id))
    formDataToSend.append('name', formData.value.name)
    formDataToSend.append('price', String(formData.value.price))
    formDataToSend.append('description', formData.value.description)

    if (imageFile.value) {
      formDataToSend.append('image_path', imageFile.value)
    }

    if (editMode.value && editingId.value) {
      await api.updateProduct(editingId.value, formDataToSend)
      toast.success('Produk berhasil diperbarui!')
    } else {
      if (!imageFile.value) {
        errorMessage.value = 'Gambar produk wajib diisi'
        return
      }
      await api.createProduct(formDataToSend)
      toast.success('Produk berhasil ditambahkan!')
    }

    await fetchProducts()
    closeModal()
  } catch (error) {
    console.error('Error saving product:', error)
    const axiosError = error as { response?: { data?: { message?: string } } }
    const message = axiosError.response?.data?.message || 'Gagal menyimpan produk'
    errorMessage.value = message
    toast.error(message)
  } finally {
    isSubmitting.value = false
  }
}

const confirmDelete = (product: Product) => {
  productToDelete.value = product
  showDeleteModal.value = true
}

const deleteProduct = async () => {
  if (!productToDelete.value) return

  try {
    isDeleting.value = true
    await api.deleteProduct(productToDelete.value.id)
    toast.success('Produk berhasil dihapus!')
    await fetchProducts()
    showDeleteModal.value = false
    productToDelete.value = null
  } catch (error) {
    console.error('Error deleting product:', error)
    toast.error('Gagal menghapus produk')
  } finally {
    isDeleting.value = false
  }
}

const getImageUrl = (imagePath: string | undefined): string => {
  if (!imagePath) {
    return 'https://placehold.co/400x300/e5e7eb/6b7280?text=No+Image'
  }
  if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
    return imagePath
  }
  return `${import.meta.env.VITE_API_BASE_URL?.replace('/api', '') || 'http://127.0.0.1:8000'}/storage/${imagePath}`
}

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement
  target.src = 'https://placehold.co/400x300/e5e7eb/6b7280?text=No+Image'
}

const formatPrice = (price: number): string => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(price)
}

onMounted(() => {
  fetchProducts()
})
</script>
