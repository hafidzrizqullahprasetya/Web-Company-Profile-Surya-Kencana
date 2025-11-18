<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <component
    :is="href ? 'a' : 'button'"
    :href="href"
    :target="target"
    :type="!href ? 'button' : undefined"
    :class="[
      'inline-flex items-center justify-center gap-2',
      size === 'sm' ? 'px-4 py-2 text-xs' : size === 'md' ? 'px-6 py-3 text-sm' : 'px-12 py-4 text-lg',
      'font-bold uppercase tracking-wider rounded-lg',
      'transition-all duration-300',
      'hover:-translate-y-1 hover:shadow-lg',
      variant === 'inverted' ? 'bg-white text-primary hover:bg-gray-100' : 'bg-primary text-white hover:bg-primary/90'
    ]"
  >
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
