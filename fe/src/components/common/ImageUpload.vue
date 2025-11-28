<template>
  <div class="image-upload-container">
    <label :for="id" class="block text-sm font-medium text-gray-700 mb-2">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>

    <!-- Preview Area -->
    <div v-if="previewUrl" class="mb-4">
      <div class="relative inline-block">
        <img
          :src="previewUrl"
          :alt="label"
          class="max-w-full h-auto rounded-lg shadow-md"
          :class="previewClass"
          :style="{ maxHeight: maxPreviewHeight }"
        />
        <button
          type="button"
          @click="removeImage"
          class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition shadow-lg"
          title="Remove image"
        >
          <i class="fa-solid fa-xmark w-4 h-4"></i>
        </button>
      </div>
    </div>

    <!-- Upload Area -->
    <div
      v-if="!previewUrl"
      class="upload-area border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition"
      :class="dragOver ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary'"
      @click="triggerFileInput"
      @drop.prevent="handleDrop"
      @dragover.prevent="dragOver = true"
      @dragleave.prevent="dragOver = false"
    >
      <div class="flex flex-col items-center">
        <i class="fa-solid fa-cloud-arrow-up w-12 h-12 text-gray-400 mb-3 text-2xl"></i>
        <p class="text-sm text-gray-600 mb-1">
          <span class="font-medium text-primary">Click to upload</span> or drag and drop
        </p>
        <p class="text-xs text-gray-500">{{ acceptText }}</p>
        <p v-if="maxSize" class="text-xs text-gray-400 mt-1">Max size: {{ formatFileSize(maxSize) }}</p>
      </div>
    </div>

    <!-- Hidden File Input -->
    <input
      :id="id"
      ref="fileInput"
      type="file"
      :accept="accept"
      class="hidden"
      @change="handleFileChange"
    />

    <!-- Error Message -->
    <p v-if="error" class="text-red-500 text-sm mt-2">{{ error }}</p>

    <!-- Help Text -->
    <p v-if="helpText && !error" class="text-gray-500 text-sm mt-2">{{ helpText }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'

interface Props {
  modelValue?: File | null
  id?: string
  label?: string
  accept?: string
  maxSize?: number // in bytes
  required?: boolean
  previewClass?: string
  maxPreviewHeight?: string
  helpText?: string
  currentImageUrl?: string // For editing existing images
}

const props = withDefaults(defineProps<Props>(), {
  id: 'file-upload',
  label: 'Upload Image',
  accept: 'image/jpeg,image/png,image/jpg,image/gif,image/webp',
  maxSize: 104857600, // 100MB default
  required: false,
  previewClass: 'max-w-md',
  maxPreviewHeight: '300px',
  helpText: '',
  currentImageUrl: '',
})

const emit = defineEmits<{
  'update:modelValue': [value: File | null]
  'error': [message: string]
}>()

const fileInput = ref<HTMLInputElement | null>(null)
const previewUrl = ref<string>('')
const dragOver = ref(false)
const error = ref<string>('')

// Show current image on mount
watch(
  () => props.currentImageUrl,
  (newUrl) => {
    if (newUrl && !previewUrl.value) {
      previewUrl.value = newUrl
    }
  },
  { immediate: true }
)

const acceptText = computed(() => {
  const types = props.accept.split(',').map((type) => {
    const trimmed = type.trim()
    if (trimmed === 'image/*') {
      return 'All Images'
    } else if (trimmed.includes('*')) {
      return trimmed.toUpperCase()
    } else {
      return trimmed.split('/')[1]?.toUpperCase() || trimmed
    }
  })
  return types.join(', ')
})

const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}

const validateFile = (file: File): boolean => {
  error.value = ''

  // Check file type
  const acceptedTypes = props.accept.split(',').map((t) => t.trim())
  let isValidType = false

  for (const acceptedType of acceptedTypes) {
    if (acceptedType === 'image/*') {
      // If accepting all images, check if file type starts with 'image/'
      if (file.type.startsWith('image/')) {
        isValidType = true
        break
      }
    } else if (acceptedType.includes('*')) {
      // Handle wildcard patterns like 'image/*'
      const [typePrefix, subtypeSuffix] = acceptedType.split('/')
      if (typePrefix && subtypeSuffix) {
        const [actualType, actualSubtype] = file.type.split('/')
        if (typePrefix === actualType && 
            (subtypeSuffix === '*' || actualSubtype === subtypeSuffix)) {
          isValidType = true
          break
        }
      }
    } else {
      // Exact match
      if (file.type === acceptedType) {
        isValidType = true
        break
      }
    }
  }

  if (!isValidType) {
    error.value = `Invalid file type. Accepted: ${acceptText.value}`
    emit('error', error.value)
    return false
  }

  // Check file size
  if (props.maxSize && file.size > props.maxSize) {
    error.value = `File size exceeds ${formatFileSize(props.maxSize)}`
    emit('error', error.value)
    return false
  }

  return true
}

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]

  if (file) {
    processFile(file)
  }
}

const handleDrop = (event: DragEvent) => {
  dragOver.value = false
  const file = event.dataTransfer?.files[0]

  if (file) {
    processFile(file)
  }
}

const processFile = (file: File) => {
  if (!validateFile(file)) {
    return
  }

  // Create preview
  const reader = new FileReader()
  reader.onload = (e) => {
    previewUrl.value = e.target?.result as string
  }
  reader.readAsDataURL(file)

  // Emit file
  emit('update:modelValue', file)
}

const triggerFileInput = () => {
  fileInput.value?.click()
}

const removeImage = () => {
  previewUrl.value = ''
  error.value = ''
  if (fileInput.value) {
    fileInput.value.value = ''
  }
  emit('update:modelValue', null)
}
</script>

<style scoped>
.upload-area {
  transition: all 0.2s ease;
}
</style>
