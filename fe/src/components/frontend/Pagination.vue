<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="flex flex-col items-center gap-3 sm:gap-4 md:gap-5 lg:gap-6">
        <!-- Page Dots -->
        <div class="flex items-center gap-0.5 sm:gap-1 md:gap-1.5 flex-wrap justify-center px-2">
            <button v-for="page in totalPages" :key="page" type="button" @click="handleGoto(page - 1)"
                class="transition-all duration-500 ease-in-out transform rounded-full" :class="currentPage === page - 1
                    ? variant === 'inverted'
                        ? 'w-4 h-1.5 sm:w-5 sm:h-1.5 md:w-7 md:h-2 lg:w-9 lg:h-2.5 bg-primary shadow-sm md:shadow-md scale-100'
                        : 'w-4 h-1.5 sm:w-5 sm:h-1.5 md:w-7 md:h-2 lg:w-9 lg:h-2.5 bg-white shadow-sm md:shadow-md scale-100'
                    : variant === 'inverted'
                        ? 'w-1.5 sm:w-2 md:w-2.5 lg:w-3 h-1.5 sm:h-2 md:h-2.5 lg:h-3 bg-primary/30 hover:bg-primary/60 hover:scale-125 transition-all'
                        : 'w-1.5 sm:w-2 md:w-2.5 lg:w-3 h-1.5 sm:h-2 md:h-2.5 lg:h-3 bg-white/30 hover:bg-white/60 hover:scale-125 transition-all'
                    " :aria-label="`Go to page ${page}`" />
        </div>

        <!-- Navigation Buttons -->
        <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3 lg:gap-4">
            <button type="button" @click="handlePrev" :disabled="currentPage === 0" :class="[
                'rounded-full transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed hover:shadow-md disabled:hover:shadow-none flex items-center justify-center group transform',
                'w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 lg:w-11 lg:h-11',
                currentPage === 0 ? '' : 'hover:-translate-x-0.5 hover:scale-105 sm:hover:-translate-x-1 sm:hover:scale-110',
                variant === 'inverted'
                    ? 'bg-primary text-white hover:bg-secondary'
                    : 'bg-white text-secondary hover:bg-cream',
            ]" aria-label="Previous page">
                <i class="fa-solid fa-chevron-left w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4 lg:w-5 lg:h-5"></i>
            </button>

            <div :class="[
                'font-semibold rounded-full backdrop-blur-sm transition-all whitespace-nowrap',
                'text-xs sm:text-xs md:text-sm lg:text-base',
                'px-2 sm:px-3 md:px-4 lg:px-5',
                'py-0.5 sm:py-1 md:py-1.5 lg:py-2',
                variant === 'inverted'
                    ? 'text-primary bg-primary/10'
                    : 'text-white bg-white/10'
            ]">
                {{ currentPage + 1 }}/{{ totalPages }}
            </div>

            <button type="button" @click="handleNext" :disabled="currentPage === totalPages - 1" :class="[
                'rounded-full transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed hover:shadow-md disabled:hover:shadow-none flex items-center justify-center group transform',
                'w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 lg:w-11 lg:h-11',
                currentPage === totalPages - 1 ? '' : 'hover:translate-x-0.5 hover:scale-105 sm:hover:translate-x-1 sm:hover:scale-110',
                variant === 'inverted'
                    ? 'bg-primary text-white hover:bg-secondary'
                    : 'bg-white text-secondary hover:bg-cream',
            ]" aria-label="Next page">
                <i class="fa-solid fa-chevron-right w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4 lg:w-5 lg:h-5"></i>
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
