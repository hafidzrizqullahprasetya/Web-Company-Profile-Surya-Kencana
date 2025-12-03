<template>
  <div class="relative flex flex-col items-center justify-center bg-gray-100 border-2 border-dashed border-gray-300 rounded-xl overflow-hidden"
    :class="[sizeClass, variant === 'logo' ? 'bg-white' : '']">
    <div class="flex flex-col items-center justify-center p-4 text-center">
      <i :class="iconClass" class="mb-2 text-gray-400"></i>
      <span class="text-xs sm:text-sm font-medium text-gray-500">{{ text }}</span>
    </div>
    <div v-if="variant === 'image'" class="absolute inset-0 flex items-center justify-center">
      <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="text-gray-300 text-xs text-center px-4">
          {{ altText }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  variant?: 'image' | 'logo' | 'avatar'
  size?: 'sm' | 'md' | 'lg' | 'xl'
  text?: string
  altText?: string
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'image',
  size: 'md',
  text: 'No Image',
  altText: 'Gambar tidak ditemukan'
})

const sizeClass = computed(() => {
  switch (props.size) {
    case 'sm':
      return 'w-16 h-16 text-xs'
    case 'lg':
      return 'w-48 h-48 text-sm'
    case 'xl':
      return 'w-64 h-64 text-base'
    case 'md':
    default:
      return 'w-32 h-32 text-sm'
  }
})

const iconClass = computed(() => {
  let baseClasses = 'w-6 h-6'

  switch (props.variant) {
    case 'logo':
      return `${baseClasses} fa-solid fa-copyright`
    case 'avatar':
      return `${baseClasses} fa-solid fa-user`
    case 'image':
    default:
      return `${baseClasses} fa-solid fa-image`
  }
})
</script>