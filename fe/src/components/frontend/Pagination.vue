<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="flex flex-col items-center gap-6">
    <!-- Page Dots -->
    <div class="flex items-center gap-3">
      <button
        v-for="page in totalPages"
        :key="page"
        type="button"
        @click="handleGoto(page - 1)"
        class="transition-all duration-500 ease-in-out transform"
        :class="
          currentPage === page - 1
            ? variant === 'inverted'
              ? 'w-12 h-3 bg-primary rounded-full shadow-lg scale-110'
              : 'w-12 h-3 bg-white rounded-full shadow-lg scale-110'
            : variant === 'inverted'
              ? 'w-3 h-3 bg-primary/40 rounded-full hover:bg-primary/60 hover:scale-125'
              : 'w-3 h-3 bg-white/40 rounded-full hover:bg-white/60 hover:scale-125'
        "
        :aria-label="`Go to page ${page}`"
      />
    </div>

    <!-- Navigation Buttons -->
    <div class="flex items-center gap-6">
      <button
        type="button"
        @click="handlePrev"
        :disabled="currentPage === 0"
        :class="[
          'w-12 h-12 rounded-full transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed hover:shadow-xl disabled:hover:shadow-none flex items-center justify-center group transform',
          currentPage === 0 ? '' : 'hover:-translate-x-1 hover:scale-110',
          variant === 'inverted'
            ? 'bg-primary text-white hover:bg-secondary'
            : 'bg-white text-secondary hover:bg-cream',
        ]"
        aria-label="Previous page"
      >
        <i class="fa-solid fa-chevron-left w-6 h-6"></i>
      </button>

      <div
        :class="
          variant === 'inverted'
            ? 'text-primary text-sm font-semibold bg-primary/10 px-6 py-2 rounded-full backdrop-blur-sm'
            : 'text-white text-sm font-semibold bg-white/10 px-6 py-2 rounded-full backdrop-blur-sm'
        "
      >
        Page {{ currentPage + 1 }} of {{ totalPages }}
      </div>

      <button
        type="button"
        @click="handleNext"
        :disabled="currentPage === totalPages - 1"
        :class="[
          'w-12 h-12 rounded-full transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed hover:shadow-xl disabled:hover:shadow-none flex items-center justify-center group transform',
          currentPage === totalPages - 1 ? '' : 'hover:translate-x-1 hover:scale-110',
          variant === 'inverted'
            ? 'bg-primary text-white hover:bg-secondary'
            : 'bg-white text-secondary hover:bg-cream',
        ]"
        aria-label="Next page"
      >
        <i class="fa-solid fa-chevron-right w-6 h-6"></i>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  currentPage: number
  totalPages: number
  variant?: 'default' | 'inverted'
}

withDefaults(defineProps<Props>(), {
  variant: 'default',
})

const emit = defineEmits<{
  prev: []
  next: []
  goto: [page: number]
}>()

const handlePrev = () => {
  emit('prev')
}

const handleNext = () => {
  emit('next')
}

const handleGoto = (page: number) => {
  emit('goto', page)
}
</script>
