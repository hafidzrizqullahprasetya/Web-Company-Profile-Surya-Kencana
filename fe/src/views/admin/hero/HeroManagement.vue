<template>
    <div class="pt-5 sm:pt-24 md:pt-5 px-4 sm:px-6 lg:px-2">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Hero Section</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Kelola tampilan utama halaman depan website Anda
            </p>
        </div>

        <!-- Skeleton Loading -->
        <div v-if="isLoading" class="space-y-4 sm:space-y-6">
            <SkeletonLoader type="card" />
            <SkeletonLoader type="form" :rows="6" />
        </div>

        <div v-else class="space-y-4 sm:space-y-6">
            <!-- Background Images Slider Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Gambar Background Slider</h2>
                <p class="text-xs sm:text-sm text-gray-600 mb-4">
                    Upload beberapa gambar untuk slider hero section (Max 100MB per gambar)
                </p>

                <!-- Existing Backgrounds -->
                <div v-if="existingBackgrounds.length > 0" class="mb-4 sm:mb-6">
                    <h3 class="text-xs sm:text-sm font-medium text-gray-700 mb-2 sm:mb-3">Gambar Saat Ini:</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                        <div v-for="(bg, index) in existingBackgrounds" :key="index" class="relative group">
                            <img :src="getBackgroundUrl(bg)" :alt="`Background ${index + 1}`"
                                class="w-full h-24 sm:h-32 object-cover rounded-lg border border-gray-200" />
                            <button type="button" @click="removeExistingBackground(index)"
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 p-1 sm:p-1.5 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                                title="Hapus gambar">
                                <i class="fa-solid fa-xmark text-xs sm:text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Upload New Backgrounds -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2"> Tambah Gambar Baru </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 sm:p-6">
                        <input ref="fileInput" type="file" multiple accept="image/jpeg,image/png,image/jpg,image/webp"
                            @change="handleFileSelect" class="hidden" />
                        <button type="button" @click="($refs.fileInput as HTMLInputElement).click()"
                            class="w-full flex flex-col items-center justify-center text-gray-600 hover:text-primary transition">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl sm:text-4xl mb-2"></i>
                            <span class="text-xs sm:text-sm font-medium">Klik untuk upload gambar</span>
                            <span class="text-xs text-gray-500 mt-1">Maks. 100MB per gambar</span>
                        </button>
                    </div>

                    <!-- Preview New Uploads -->
                    <div v-if="newBackgroundFiles.length > 0" class="mt-4">
                        <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Preview Gambar Baru:</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                            <div v-for="(file, index) in newBackgroundFiles" :key="index" class="relative group">
                                <img :src="getPreviewUrl(file)" :alt="`Preview ${index + 1}`"
                                    class="w-full h-24 sm:h-32 object-cover rounded-lg border border-gray-200" />
                                <button type="button" @click="removeNewBackground(index)"
                                    class="absolute top-1 right-1 sm:top-2 sm:right-2 p-1 sm:p-1.5 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                                    title="Hapus gambar">
                                    <i class="fa-solid fa-xmark text-xs sm:text-sm"></i>
                                </button>
                                <span
                                    class="absolute bottom-1 left-1 sm:bottom-2 sm:left-2 text-xs bg-black/50 text-white px-1.5 py-0.5 sm:px-2 sm:py-1 rounded">
                                    {{ formatFileSize(file.size) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Content Form -->
            <form @submit.prevent="saveHero" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Konten Hero Section</h2>
                <p class="text-xs sm:text-sm text-gray-600 mb-4">
                    Semua field bersifat opsional. Isi hanya yang diperlukan.
                </p>

                <div class="space-y-3">
                    <!-- Lokasi -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Lokasi</label>
                        <input v-model="hero.location" type="text"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Jakarta, Indonesia" />
                    </div>

                    <!-- Judul -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Judul Utama</label>
                        <textarea v-model="hero.title" rows="2"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Mesin Custom untuk Kebutuhan Industri Anda"></textarea>
                    </div>

                    <!-- Statistik Section -->
                    <div class="pt-2 border-t border-gray-100">
                        <h3 class="text-sm sm:text-base font-semibold text-gray-900 mb-3">Statistik</h3>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <!-- Jumlah Mesin -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Jumlah
                                    Mesin</label>
                                <input v-model.number="hero.machines" type="number" min="0"
                                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="80" />
                            </div>

                            <!-- Jumlah Klien -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Jumlah
                                    Klien</label>
                                <input v-model.number="hero.clients" type="number" min="0"
                                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="100" />
                            </div>

                            <!-- Jumlah Pelanggan -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Jumlah
                                    Pelanggan</label>
                                <input v-model.number="hero.customers" type="number" min="0"
                                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="10" />
                            </div>

                            <!-- Tahun Pengalaman -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Tahun
                                    Pengalaman</label>
                                <input v-model.number="hero.experience_years" type="number" min="0"
                                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="10" />
                            </div>

                            <!-- Tahun Kepercayaan -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Tahun
                                    Kepercayaan</label>
                                <input v-model.number="hero.trust_years" type="number" min="0"
                                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="10" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div v-if="errorMessage"
                    class="mt-4 p-3 sm:p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-xs sm:text-sm">
                    {{ errorMessage }}
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-end mt-4">
                    <button type="submit" :disabled="isSaving"
                        class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 text-sm sm:text-base bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed transition font-medium">
                        <span v-if="!isSaving">Simpan Perubahan</span>
                        <span v-else class="flex items-center justify-center gap-2">
                            <i class="fa-solid fa-spinner animate-spin text-sm"></i>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
import api from '@/services/api'
import type { Hero } from '@/services/api'
import { showToast } from '@/utils/sweetalert'

const hero = ref<Partial<Hero>>({
    location: '',
    title: '',
    machines: 0,
    clients: 0,
    customers: 0,
    experience_years: 0,
    trust_years: 0,
})

const existingBackgrounds = ref<string[]>([])
const backgroundsToDelete = ref<string[]>([])
const newBackgroundFiles = ref<File[]>([])
const fileInput = ref()
const isLoading = ref(true)
const isSaving = ref(false)
const errorMessage = ref('')

const MAX_FILE_SIZE = 104857600 // 100MB in bytes

const loadHero = async () => {
    isLoading.value = true

    // Safety timeout to prevent infinite loading
    const timeoutId = setTimeout(() => {
        if (isLoading.value) {
            console.warn('⚠️ loadHero timed out')
            isLoading.value = false
            showToast.error('Koneksi lambat atau bermasalah. Silakan refresh.')
        }
    }, 15000)

    try {
        const data = await api.getHero()
        clearTimeout(timeoutId)

        if (Array.isArray(data) && data.length > 0) {
            hero.value = { ...data[0] }
            existingBackgrounds.value = data[0]?.backgrounds || []
        } else if (data && typeof data === 'object' && !Array.isArray(data)) {
            // Handle case where backend returns single object instead of array
            hero.value = data as Hero
            existingBackgrounds.value = (data as any).backgrounds || []
        }
    } catch (error) {
        clearTimeout(timeoutId)
        console.error('Error fetching hero:', error)
        showToast.error('Gagal memuat data hero section')
    } finally {
        isLoading.value = false
    }
}

const handleFileSelect = (event: Event) => {
    const target = event.target as HTMLInputElement
    const files = Array.from(target.files || [])

    // Validate file sizes
    const validFiles = files.filter((file) => {
        if (file.size > MAX_FILE_SIZE) {
            showToast.error(`File ${file.name} terlalu besar (maks. 100MB)`)
            return false
        }
        return true
    })

    newBackgroundFiles.value = [...newBackgroundFiles.value, ...validFiles]
}

const removeExistingBackground = (index: number) => {
    const pathToDelete = existingBackgrounds.value[index]
    if (pathToDelete) {
        backgroundsToDelete.value.push(pathToDelete)
    }
    existingBackgrounds.value.splice(index, 1)
}

const removeNewBackground = (index: number) => {
    newBackgroundFiles.value.splice(index, 1)
}

const getBackgroundUrl = (path: string): string => {
    if (path.startsWith('http://') || path.startsWith('https://')) {
        return path
    }
    const cdnUrl =
        import.meta.env.VITE_CDN_URL || 'https://pub-2fb44babc7a4420e8fa728891ac101ef.r2.dev'
    return `${cdnUrl}/${path}`
}

const getPreviewUrl = (file: File): string => {
    return URL.createObjectURL(file)
}

const formatFileSize = (bytes: number): string => {
    if (bytes === 0) return '0 Bytes'
    const k = 1024
    const sizes = ['Bytes', 'KB', 'MB', 'GB']
    const i = Math.floor(Math.log(bytes) / Math.log(k))
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i]
}

const saveHero = async () => {
    try {
        isSaving.value = true
        errorMessage.value = ''

        const formData = new FormData()

        // Add hero data (only if provided)
        if (hero.value.location) formData.append('location', hero.value.location)
        if (hero.value.title) formData.append('title', hero.value.title)
        if (hero.value.machines !== undefined) formData.append('machines', String(hero.value.machines))
        if (hero.value.clients !== undefined) formData.append('clients', String(hero.value.clients))
        if (hero.value.customers !== undefined)
            formData.append('customers', String(hero.value.customers))
        if (hero.value.experience_years !== undefined)
            formData.append('experience_years', String(hero.value.experience_years))
        if (hero.value.trust_years !== undefined)
            formData.append('trust_years', String(hero.value.trust_years))

        // Add new background images
        if (newBackgroundFiles.value.length > 0) {
            newBackgroundFiles.value.forEach((file) => {
                formData.append('backgrounds[]', file)
            })
        }

        // Add backgrounds to delete
        if (backgroundsToDelete.value.length > 0) {
            backgroundsToDelete.value.forEach((path) => {
                formData.append('deleted_backgrounds[]', path)
            })
        }

        await api.updateHero(formData)
        showToast.success('Hero section berhasil diperbarui!')

        // Reload data and reset
        await loadHero()
        newBackgroundFiles.value = []
        backgroundsToDelete.value = []
    } catch (error) {
        console.error('Error saving hero:', error)
        const axiosError = error as { response?: { data?: { message?: string } } }
        const message = axiosError.response?.data?.message || 'Gagal menyimpan hero section'
        errorMessage.value = message
        showToast.error(message)
    } finally {
        isSaving.value = false
    }
}

onMounted(() => {
    loadHero()
})
</script>
