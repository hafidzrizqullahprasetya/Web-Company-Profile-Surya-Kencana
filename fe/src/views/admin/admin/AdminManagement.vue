<template>
    <div class="pt-5 sm:pt-24 md:pt-5 px-4 sm:px-6 lg:px-2">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Admin</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-2">Kelola akun admin sistem</p>
        </div>

        <!-- Action Bar -->
        <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex-1 sm:max-w-md relative">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input v-model="searchQuery" type="text" placeholder="Cari admin..."
                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" />
            </div>
            <button @click="openModal()"
                class="px-4 sm:px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-plus text-sm"></i>
                <span class="hidden sm:inline">Tambah Admin</span>
                <span class="sm:hidden">Tambah</span>
            </button>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <SkeletonLoader type="table" :rows="10" :columns="4" />
        </div>

        <!-- Admins Grid -->
        <div v-else-if="filteredAdmins.length > 0"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div v-for="admin in filteredAdmins" :key="admin.id"
                class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="p-4 sm:p-6">
                    <div class="flex items-start justify-between mb-3 sm:mb-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-user text-base sm:text-lg text-primary"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 truncate">
                                    {{ admin.username || 'No Username' }}
                                </h3>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button @click="openModal(admin)"
                                class="p-2 text-primary hover:bg-yellow-50 rounded-lg transition flex-shrink-0"
                                title="Edit">
                                <i class="fa-solid fa-pen text-sm"></i>
                            </button>
                            <button @click="confirmDelete(admin)"
                                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition flex-shrink-0"
                                title="Hapus">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div v-if="admin.created_at" class="space-y-2 text-xs sm:text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fa-solid fa-clock text-sm mr-2"></i>
                            <span>Dibuat: {{ formatDate(admin.created_at) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12 sm:py-20">
            <i class="fa-solid fa-user-group text-gray-400 mx-auto mb-4 text-4xl sm:text-5xl"></i>
            <p class="text-sm sm:text-base text-gray-600 mb-4">Belum ada admin</p>
            <button @click="openModal()"
                class="px-4 sm:px-6 py-2 sm:py-2.5 text-sm sm:text-base bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                Tambah Admin Pertama
            </button>
        </div>

        <!-- Modal Form -->
        <div v-if="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
            @click.self="closeModal">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center">
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-900">
                        {{ editMode ? 'Edit Admin' : 'Tambah Admin Baru' }}
                    </h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form @submit.prevent="handleSubmit" class="p-4 sm:p-6 space-y-4 sm:space-y-5">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input v-model="formData.username" type="text" required
                            class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Username admin" />
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Password
                            <span v-if="!editMode" class="text-red-500">*</span>
                        </label>
                        
                        <!-- Info Alert for Edit Mode -->
                        <div v-if="editMode" class="mb-3 p-3 bg-blue-50 text-blue-700 rounded-lg text-xs flex gap-2 items-start">
                            <i class="fa-solid fa-circle-info mt-0.5"></i>
                            <p>Password lama tersembunyi demi keamanan. <b>Biarkan kosong</b> jika tidak ingin mengubah password. Isi hanya jika ingin menggantinya dengan yang baru.</p>
                        </div>

                        <div class="relative">
                            <input v-model="formData.password" :type="showPassword ? 'text' : 'password'"
                                :required="!editMode" minlength="6"
                                class="w-full px-3 py-2 pr-12 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                :placeholder="editMode ? 'Password tersimpan aman (isi jika ingin ubah)' : 'Minimal 6 karakter'" />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                                <i v-if="showPassword" class="fa-solid fa-eye text-sm"></i>
                                <i v-else class="fa-solid fa-eye-slash text-sm"></i>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
                    </div>

                    <div v-if="errorMessage"
                        class="p-3 sm:p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-xs sm:text-sm">
                        {{ errorMessage }}
                    </div>

                    <div class="flex gap-3 pt-2 sm:pt-4">
                        <button type="button" @click="closeModal"
                            class="flex-1 px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" :disabled="isSubmitting"
                            class="flex-1 px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            <span v-if="!isSubmitting">{{ editMode ? 'Simpan Perubahan' : 'Tambah Admin' }}</span>
                            <span v-else class="flex items-center justify-center gap-2">
                                <i class="fa-solid fa-spinner animate-spin text-sm"></i>
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
import { ref, computed, onMounted } from 'vue'
import api, { type Admin } from '@/services/api'
import SkeletonLoader from '@/components/admin/common/SkeletonLoader.vue'
import { showToast, showDeleteConfirm, showLoading, closeLoading } from '@/utils/sweetalert'

const admins = ref<Admin[]>([])
const isLoading = ref(true)
const searchQuery = ref('')
const showModal = ref(false)
const editMode = ref(false)
const isSubmitting = ref(false)
const errorMessage = ref('')

const formData = ref({
    username: '',
    password: '',
})

const showPassword = ref(false)
const editingId = ref<number | null>(null)

const filteredAdmins = computed(() => {
    if (!searchQuery.value) return admins.value
    const query = searchQuery.value.toLowerCase()
    return admins.value.filter((a) => a.username && a.username.toLowerCase().includes(query))
})

const fetchAdmins = async () => {
    try {
        isLoading.value = true
        const data = await api.getAdmins()
        admins.value = data
    } catch (error) {
        console.error('Error fetching admins:', error)
        showToast.error('Gagal memuat data admin')
    } finally {
        isLoading.value = false
    }
}

const openModal = (admin?: Admin) => {
    if (admin) {
        editMode.value = true
        editingId.value = admin.id
        formData.value = {
            username: admin.username || '',
            password: '',
        }
    } else {
        editMode.value = false
        editingId.value = null
        formData.value = {
            username: '',
            password: '',
        }
    }
    errorMessage.value = ''
    showPassword.value = false
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
    showPassword.value = false
}

const handleSubmit = async () => {
    try {
        isSubmitting.value = true
        errorMessage.value = ''

        showLoading('Menyimpan...')

        const dataToSend: Partial<Admin> = {
            username: formData.value.username,
        }

        if (formData.value.password) {
            dataToSend.password = formData.value.password
        }

        if (editMode.value && editingId.value) {
            await api.updateAdmin(editingId.value, dataToSend)
            showToast.success('Admin berhasil diperbarui!')
        } else {
            if (!formData.value.password) {
                closeLoading()
                errorMessage.value = 'Password wajib diisi untuk admin baru'
                isSubmitting.value = false
                return
            }
            dataToSend.password = formData.value.password
            await api.createAdmin(dataToSend as Omit<Admin, 'id'>)
            showToast.success('Admin berhasil ditambahkan!')
        }

        closeLoading()
        await fetchAdmins()
        closeModal()
    } catch (error) {
        console.error('Error saving admin:', error)
        closeLoading()
        const axiosError = error as { response?: { data?: { message?: string } } }
        const message = axiosError.response?.data?.message || 'Gagal menyimpan admin'
        errorMessage.value = message
        showToast.error(message)
    } finally {
        isSubmitting.value = false
    }
}

const confirmDelete = async (admin: Admin) => {
    const confirmed = await showDeleteConfirm(
        'Hapus Admin',
        `Apakah Anda yakin ingin menghapus admin "${admin.username}"?`
    )

    if (confirmed) {
        await deleteAdmin(admin)
    }
}

const deleteAdmin = async (admin: Admin) => {
    try {
        showLoading('Menghapus...')
        await api.deleteAdmin(admin.id)
        closeLoading()
        showToast.success('Admin berhasil dihapus!')
        await fetchAdmins()
    } catch (error) {
        console.error('Error deleting admin:', error)
        closeLoading()
        showToast.error('Gagal menghapus admin')
    }
}

const formatDate = (dateString: string) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })
}

onMounted(() => {
    fetchAdmins()
})
</script>
