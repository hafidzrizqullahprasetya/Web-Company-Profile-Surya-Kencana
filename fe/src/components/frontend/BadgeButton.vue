<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <component :is="href ? 'a' : 'button'" :href="href" :target="target" :type="!href ? 'button' : undefined" :class="[
        'inline-flex items-center justify-center gap-2',
        size === 'sm' ? 'px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-xs' : size === 'md' ? 'px-5 md:px-6 py-2 md:py-2.5 text-sm md:text-sm' : 'px-8 md:px-10 lg:px-12 py-3 md:py-3 lg:py-3 text-base md:text-lg lg:text-lg',
        'font-bold uppercase tracking-wider rounded-lg',
        'transition-all duration-300',
        'hover:-translate-y-1 hover:shadow-lg',
        variant === 'inverted' ? 'bg-white text-primary hover:bg-gray-100' : 'bg-primary text-white hover:bg-primary/90'
    ]">
        <slot />
    </component>
</template>

<script setup lang="ts">
interface Props {
    href?: string
    target?: string
    variant?: 'default' | 'inverted'
    size?: 'sm' | 'md' | 'lg'
}

withDefaults(defineProps<Props>(), {
    href: undefined,
    target: undefined,
    variant: 'default',
    size: 'lg'
})
</script>
