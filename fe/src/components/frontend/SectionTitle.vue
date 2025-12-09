<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="text-center" :class="marginBottom">
        <!-- Label Badge -->
        <div class="inline-flex items-center gap-2 md:gap-3 mb-6 md:mb-8 lg:mb-10 px-6 md:px-8 lg:px-10 py-2 md:py-2.5 lg:py-3 rounded-lg"
            :class="[labelVariant === 'inverted' ? 'bg-white text-primary' : 'bg-primary text-white']">
            <span class="text-sm md:text-base lg:text-lg xl:text-base font-bold uppercase">
                {{ label }}
            </span>
        </div>

        <!-- Title -->
        <h2 v-html="title" :class="[
            'text-2xl md:text-3xl lg:text-4xl xl:text-4xl 2xl:text-5xl font-epilogue font-bold leading-tight uppercase',
            titleVariant === 'white' ? 'text-white' : 'text-primary',
            'mb-8 md:mb-10 lg:mb-12',
        ]"></h2>
    </div>
</template>

<script setup lang="ts">
interface Props {
    label?: string
    title?: string
    labelVariant?: 'default' | 'inverted'
    titleVariant?: 'default' | 'white'
    marginBottom?: string
}

withDefaults(defineProps<Props>(), {
    label: '',
    title: '',
    labelVariant: 'default',
    titleVariant: 'default',
    marginBottom: 'mb-16 md:mb-20 lg:mb-24',
})
</script>

