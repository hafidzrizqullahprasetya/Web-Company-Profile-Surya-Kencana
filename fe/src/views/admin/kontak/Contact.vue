<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="pt-5 sm:pt-24 md:pt-5 px-4 sm:px-6 lg:px-2">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Informasi Kontak</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Perbarui informasi kontak perusahaan Anda
            </p>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <SkeletonLoader type="form" :rows="5" />
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <SkeletonLoader type="card" :rows="6" />
            </div>
        </div>

        <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
            <!-- Form Section (Kiri) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 sm:mb-6">Form Edit</h2>

                <form @submit.prevent="saveContact" class="space-y-4 sm:space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input v-model="contact.email" type="email"
                            class="w-full px-3 py-2.5 sm:p-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            placeholder="kontak@perusahaan.com" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                        <input v-model="contact.phone" type="text"
                            class="w-full px-3 py-2.5 sm:p-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            placeholder="+62 812 3456 7890" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <input v-model="contact.address" type="text"
                            class="w-full px-3 py-2.5 sm:p-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            placeholder="Alamat perusahaan" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lokasi Maps</label>
                        <input v-model="contact.map_location_name" type="text"
                            class="w-full px-3 py-2.5 sm:p-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            placeholder="PT. Surya Kencana Gemilang Teknik" />
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Nama bisnis/tempat untuk pencarian Google Maps
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tautan Maps (Opsional)</label>
                        <input v-model="contact.map_url" type="url"
                            class="w-full px-3 py-2.5 sm:p-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            placeholder="https://maps.google.com/... atau https://maps.app.goo.gl/..." />
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Opsional: Gunakan Google Maps link jika ingin
                            lokasi spesifik</p>
                    </div>

                    <div class="flex justify-end pt-2 sm:pt-4">
                        <button type="submit" :disabled="isSaving"
                            class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base bg-primary text-white rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed transition font-medium">
                            <span v-if="!isSaving">Simpan Perubahan</span>
                            <span v-else class="flex items-center justify-center gap-2">
                                <i class="fa-solid fa-spinner animate-spin text-sm"></i>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview Section (Kanan) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 sm:mb-6">Pratinjau</h2>

                <div class="border border-gray-200 rounded-lg p-4 sm:p-6 bg-gray-50">
                    <div class="space-y-4 sm:space-y-6">
                        <div v-if="contact.email"
                            class="flex items-start p-3 sm:p-4 bg-white rounded-lg border border-gray-200">
                            <i class="fa-solid fa-envelope text-primary mr-3 mt-0.5 flex-shrink-0 text-lg"></i>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Email</h3>
                                <p class="text-sm sm:text-base text-gray-900 break-words">{{ contact.email }}</p>
                            </div>
                        </div>

                        <div v-if="contact.phone"
                            class="flex items-start p-3 sm:p-4 bg-white rounded-lg border border-gray-200">
                            <i class="fa-solid fa-phone text-primary mr-3 mt-0.5 flex-shrink-0 text-lg"></i>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Nomor WhatsApp</h3>
                                <p class="text-sm sm:text-base text-gray-900">{{ contact.phone }}</p>
                            </div>
                        </div>

                        <div v-if="contact.address"
                            class="flex items-start p-3 sm:p-4 bg-white rounded-lg border border-gray-200">
                            <i class="fa-solid fa-location-dot text-primary mr-3 mt-0.5 flex-shrink-0 text-lg"></i>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Alamat</h3>
                                <p class="text-sm sm:text-base text-gray-900 break-words">{{ contact.address }}</p>
                            </div>
                        </div>

                        <div v-if="contact.map_location_name"
                            class="flex items-start p-3 sm:p-4 bg-white rounded-lg border border-gray-200">
                            <i class="fa-solid fa-map-pin text-primary mr-3 mt-0.5 flex-shrink-0 text-lg"></i>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Nama Lokasi Maps</h3>
                                <p class="text-sm sm:text-base text-gray-900 break-words">{{ contact.map_location_name
                                }}</p>
                            </div>
                        </div>

                        <div v-if="contact.map_url"
                            class="flex items-start p-3 sm:p-4 bg-white rounded-lg border border-gray-200">
                            <i class="fa-solid fa-map text-primary mr-3 mt-0.5 flex-shrink-0 text-lg"></i>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Tautan Maps</h3>
                                <p class="text-sm sm:text-base text-gray-900 break-all">{{ contact.map_url }}</p>
                            </div>
                        </div>

                        <!-- Empty state if no data -->
                        <div v-if="!contact.email && !contact.phone && !contact.address && !contact.map_url && !contact.map_location_name"
                            class="text-center py-8 sm:py-12">
                            <i class="fa-solid fa-location-dot text-gray-300 mb-4 mx-auto text-4xl sm:text-5xl"></i>
                            <p class="text-sm sm:text-base text-gray-500">Belum ada informasi kontak</p>
                            <p class="text-xs sm:text-sm text-gray-400 mt-1">
                                Lengkapi form di sisi kiri untuk melihat pratinjau
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import type { Contact } from '@/services/api'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
import { showToast, showLoading, closeLoading } from '@/utils/sweetalert'

// State
const isLoading = ref(true)
const contact = ref<Partial<Contact>>({
    id: 0,
    address: '',
    phone: '',
    email: '',
    map_url: '',
    map_location_name: '',
})
const isSaving = ref(false)

// Methods
const loadContact = async () => {
    isLoading.value = true

    const timeoutId = setTimeout(() => {
        if (isLoading.value) {
            isLoading.value = false
            showToast.error('Koneksi lambat.')
        }
    }, 15000)

    try {
        const data = await api.getContact()
        clearTimeout(timeoutId)

        if (Array.isArray(data) && data.length > 0) {
            contact.value = { ...data[0] }
        } else if (data && typeof data === 'object' && !Array.isArray(data)) {
            contact.value = data as Contact
        }
    } catch (error: unknown) {
        clearTimeout(timeoutId)
        console.error('Error fetching contact:', error)
        showToast.error('Gagal memuat data kontak')
    } finally {
        isLoading.value = false
    }
}

const saveContact = async () => {
    isSaving.value = true
    showLoading('Menyimpan...')
    try {
        // Hapus nilai kosong untuk map_url jika tidak diisi
        const contactData = { ...contact.value }
        if (!contactData.map_url?.trim()) {
            delete contactData.map_url
        }
        if (!contactData.map_location_name?.trim()) {
            delete contactData.map_location_name
        }
        if (!contactData.email?.trim()) {
            delete contactData.email
        }
        if (!contactData.phone?.trim()) {
            delete contactData.phone
        }
        if (!contactData.address?.trim()) {
            delete contactData.address
        }

        await api.updateContact(contactData as Partial<Contact>)
        closeLoading()
        showToast.success('Kontak berhasil diperbarui!')
    } catch (error: unknown) {
        console.error('Error saving contact:', error)
        closeLoading()
        const axiosError = error as { response?: { data?: { message?: string } } }
        const message = axiosError.response?.data?.message || 'Gagal menyimpan kontak'
        showToast.error(message)
    } finally {
        isSaving.value = false
    }
}

// Load data on component mount
onMounted(() => {
    loadContact()
})
</script>
