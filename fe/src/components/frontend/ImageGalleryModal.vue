<template>
  <div
    v-if="show"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/70"
    @click.self="emit('close')"
  >
    <div class="bg-white rounded-2xl max-w-7xl w-full max-h-[95vh] overflow-hidden shadow-2xl">
      <!-- Modal Header -->
      <div
        class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center rounded-t-2xl z-10"
      >
        <div>
          <span
            v-if="badge"
            class="bg-primary text-white px-4 py-1.5 text-sm font-bold uppercase rounded-full"
          >
            {{ badge }}
          </span>
        </div>
        <button
          @click="emit('close')"
          class="text-gray-500 hover:text-gray-700 transition p-2 rounded-full hover:bg-gray-100"
          aria-label="Close modal"
        >
          <i class="fa-solid fa-times w-6 h-6"></i>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-8">
        <!-- Image Slider with Carousel -->
        <div v-if="images.length > 0">
          <div class="relative rounded-xl overflow-hidden bg-gray-100">
            <!-- Carousel Container -->
            <div class="relative overflow-hidden">
              <!-- Sliding Track -->
              <div
                class="flex transition-transform duration-700 ease-in-out"
                :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
              >
                <!-- Each Image is a Slide -->
                <div v-for="(img, index) in images" :key="index" class="w-full flex-shrink-0">
                  <div class="relative h-[70vh]">
                    <picture>
                      <source :srcset="getImageUrlForFormat(img, 'webp')" type="image/webp" />
                      <source :srcset="img" type="image/jpeg" />
                      <img
                        v-lazy="img"
                        :alt="`${title} - Image ${index + 1}`"
                        class="w-full h-full object-contain bg-gray-900"
                      />
                    </picture>
                  </div>
                </div>
              </div>

              <!-- Navigation Arrows (only show if multiple images) -->
              <template v-if="images.length > 1">
                <button
                  @click="prevImage"
                  class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-primary p-4 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
                  aria-label="Previous image"
                >
                  <i class="fa-solid fa-chevron-left w-6 h-6"></i>
                </button>
                <button
                  @click="nextImage"
                  class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-primary p-4 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
                  aria-label="Next image"
                >
                  <i class="fa-solid fa-chevron-right w-6 h-6"></i>
                </button>

                <!-- Image Counter -->
                <div
                  class="absolute bottom-4 right-4 bg-black/70 text-white px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm"
                >
                  {{ currentIndex + 1 }} / {{ images.length }}
                </div>
              </template>
            </div>

            <!-- Pagination Dots (only show if multiple images) -->
            <div
              v-if="images.length > 1"
              class="flex items-center justify-center gap-3 py-6 bg-white"
            >
              <button
                v-for="(img, index) in images"
                :key="index"
                @click="goToImage(index)"
                class="transition-all duration-500 ease-in-out transform"
                :class="
                  currentIndex === index
                    ? 'w-12 h-3 bg-primary rounded-full shadow-lg scale-110'
                    : 'w-3 h-3 bg-gray-400 rounded-full hover:bg-gray-600 hover:scale-125'
                "
                :aria-label="`Go to image ${index + 1}`"
              />
            </div>
          </div>
        </div>

        <!-- Fallback if no images -->
        <div
          v-else
          class="h-[70vh] bg-gradient-to-br from-primary/20 to-primary/40 rounded-xl flex items-center justify-center"
        >
          <div class="text-white/20 font-bold text-9xl">
            {{ badge || '?' }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'

interface Props {
  show: boolean
  images: string[]
  title: string
  description: string
  badge?: string
}

const props = defineProps<Props>()

const emit = defineEmits<{
  close: []
}>()

const currentIndex = ref(0)

// Reset index when modal opens
watch(
  () => props.show,
  (newVal) => {
    if (newVal) {
      currentIndex.value = 0
    }
  },
)

// Reset index when modal opens
watch(
  () => props.show,
  (newVal) => {
    if (newVal) {
      currentIndex.value = 0
    }
  },
)

const nextImage = () => {
  if (currentIndex.value < props.images.length - 1) {
    currentIndex.value++
  } else {
    currentIndex.value = 0 // Loop back to first
  }
}

const prevImage = () => {
  if (currentIndex.value > 0) {
    currentIndex.value--
  } else {
    currentIndex.value = props.images.length - 1 // Loop to last
  }
}

const goToImage = (index: number) => {
  currentIndex.value = index
}

const getImageUrlForFormat = (url: string | undefined, format: string = 'webp'): string => {
  if (!url) return ''

  if (
    url.includes('placehold.co') ||
    url.includes('ui-avatars.com') ||
    !url.match(/\.(jpg|jpeg|png)$/i)
  ) {
    return url
  }

  return url.replace(/\.(jpg|jpeg|png)$/i, `.${format}`)
}

// Keyboard navigation
const handleKeydown = (event: KeyboardEvent) => {
  if (!props.show) return

  if (event.key === 'ArrowLeft') {
    prevImage()
  } else if (event.key === 'ArrowRight') {
    nextImage()
  } else if (event.key === 'Escape') {
    emit('close')
  }
}

// Add keyboard listener
if (typeof window !== 'undefined') {
  window.addEventListener('keydown', handleKeydown)
}
</script>
