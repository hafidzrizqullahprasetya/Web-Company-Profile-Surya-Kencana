<template>
    <div class="pt-5 sm:pt-24 md:pt-5 px-4 sm:px-6 lg:px-2">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Visi & Misi</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Perbarui pernyataan visi dan misi perusahaan Anda
            </p>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <SkeletonLoader type="form" :rows="6" />
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <SkeletonLoader type="card" :rows="8" />
            </div>
        </div>

        <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
            <!-- Form Section (Kiri) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 sm:mb-6">Form Edit</h2>

                <form @submit.prevent="saveVisionMission" class="space-y-4 sm:space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Visi</label>
                        <textarea v-model="visionMission.vision" rows="5"
                            class="w-full px-3 py-2.5 sm:p-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            placeholder="Masukkan visi perusahaan..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Misi</label>
                        <div class="space-y-2 sm:space-y-3">
                            <div v-for="(item, index) in missionItems" :key="index"
                                class="flex items-center gap-2 overflow-hidden">
                                <input v-model="missionItems[index]" type="text"
                                    class="flex-1 px-3 py-2.5 sm:p-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition min-w-0"
                                    :placeholder="`Poin misi ${index + 1}...`" />
                                <button type="button" @click="removeMissionItem(index)"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition flex-shrink-0"
                                    :disabled="missionItems.length === 1">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </div>
                            <button type="button" @click="addMissionItem"
                                class="w-full px-3 py-2.5 sm:p-3 border-2 border-dashed border-gray-300 rounded-lg text-sm sm:text-base text-gray-600 hover:border-primary hover:text-primary transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span>Tambah Poin Misi</span>
                            </button>
                        </div>
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

                <div class="space-y-4 sm:space-y-6">
                    <div class="p-4 sm:p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <div
                                class="w-10 h-10 rounded-full bg-primary flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fa-solid fa-eye text-sm text-white"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-semibold text-primary">Visi Kami</h3>
                        </div>
                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed" v-if="visionMission.vision">
                            {{ visionMission.vision }}
                        </p>
                        <p class="text-xs sm:text-sm text-gray-400 italic" v-else>
                            Belum ada pernyataan visi. Masukkan pernyataan visi di atas untuk melihatnya di sini.
                        </p>
                    </div>

                    <div class="p-4 sm:p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <div
                                class="w-10 h-10 rounded-full bg-primary flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fa-solid fa-arrow-right text-sm text-white"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-semibold text-primary">Misi Kami</h3>
                        </div>
                        <ul class="space-y-2 sm:space-y-2.5" v-if="missionItems.length > 0 && missionItems[0]">
                            <li v-for="(item, index) in missionItems" :key="index"
                                class="flex items-start gap-2 sm:gap-3 text-sm sm:text-base text-gray-700 leading-relaxed">
                                <span class="flex-shrink-0 w-2 h-2 bg-primary rounded-full mt-1.5 sm:mt-2"></span>
                                <span>{{ item }}</span>
                            </li>
                        </ul>
                        <p class="text-xs sm:text-sm text-gray-400 italic" v-else>
                            Belum ada pernyataan misi. Masukkan poin-poin misi di atas untuk melihatnya di sini.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import type { VisionMission } from '@/services/api'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
import { showToast, showLoading, closeLoading } from '@/utils/sweetalert'

// State
const isLoading = ref(true)
const visionMission = ref<VisionMission>({
    id: 0,
    vision: '',
    mission: '',
})
const isSaving = ref(false)
const missionItems = ref<string[]>([''])

// Methods
const addMissionItem = () => {
    missionItems.value.push('')
}

const removeMissionItem = (index: number) => {
    if (missionItems.value.length > 1) {
        missionItems.value.splice(index, 1)
    }
}

const loadVisionMission = async () => {
    isLoading.value = true

    // Safety timeout
    const timeoutId = setTimeout(() => {
        if (isLoading.value) {
            isLoading.value = false
            showToast.error('Koneksi lambat. Silakan coba lagi.')
        }
    }, 15000)

    try {
        const data = await api.getVisionMission()
        clearTimeout(timeoutId)

        let targetData: VisionMission | null = null

        if (Array.isArray(data) && data.length > 0) {
            targetData = data[0] || null
        } else if (data && typeof data === 'object' && !Array.isArray(data)) {
            targetData = data as VisionMission
        }

        if (targetData) {
            visionMission.value = targetData

            // Parse mission as JSON array if possible
            try {
                const parsed = JSON.parse(targetData.mission)
                if (Array.isArray(parsed) && parsed.length > 0) {
                    missionItems.value = parsed
                } else {
                    missionItems.value = [targetData.mission]
                }
            } catch {
                // If not JSON, treat as single item
                missionItems.value = [targetData.mission]
            }
        }
    } catch (error: unknown) {
        clearTimeout(timeoutId)
        console.error('Error fetching vision mission:', error)
        showToast.error('Gagal memuat data visi & misi')
    } finally {
        isLoading.value = false
    }
}

const saveVisionMission = async () => {
    isSaving.value = true
    showLoading('Menyimpan...')
    try {
        // Filter out empty items and convert to JSON
        const filteredItems = missionItems.value.filter((item) => item.trim() !== '')
        const missionJson = JSON.stringify(filteredItems)

        await api.updateVisionMission({
            vision: visionMission.value.vision,
            mission: missionJson,
        })
        closeLoading()
        showToast.success('Visi & Misi berhasil diperbarui!')
    } catch (error: unknown) {
        console.error('Error saving vision mission:', error)
        closeLoading()
        const axiosError = error as { response?: { data?: { message?: string } } }
        const message = axiosError.response?.data?.message || 'Gagal menyimpan visi & misi'
        showToast.error(message)
    } finally {
        isSaving.value = false
    }
}

// Load data on component mount
onMounted(() => {
    loadVisionMission()
})
</script>
