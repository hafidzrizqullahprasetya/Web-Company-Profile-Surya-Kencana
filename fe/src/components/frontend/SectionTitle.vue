<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="text-center" :class="marginBottom">
    <!-- Label Badge with Icon -->
    <div
      class="inline-flex items-center gap-3 mb-10 px-12 py-4 rounded-lg"
      :class="[labelVariant === 'inverted' ? 'bg-white text-primary' : 'bg-primary text-white']"
    >
      <i
        v-if="icon"
        :class="[
          Array.isArray(icon)
            ? (icon[0] === 'fab' ? 'fa-brands' : 'fa-solid') + ' fa-' + icon[1]
            : 'fa-solid fa-' + icon,
          'w-5 h-5',
        ]"
      ></i>
      <span class="text-xl font-bold uppercase">
        {{ label }}
      </span>
    </div>

    <!-- Title -->
    <h2
      v-html="title"
      :class="[
        'text-xl md:text-3xl lg:text-4xl xl:text-5xl font-epilogue font-bold leading-tight uppercase',
        titleVariant === 'white' ? 'text-white mb-10' : 'text-primary mb-10',
        marginBottom === 'mb-16' ? 'mb-10' : 'mb-10',
      ]"
    ></h2>
  </div>
</template>

<script setup lang="ts">
interface Props {
  label?: string
  title?: string
  icon?: string[] | string
  labelVariant?: 'default' | 'inverted'
  titleVariant?: 'default' | 'white'
  marginBottom?: string
}

withDefaults(defineProps<Props>(), {
  label: '',
  title: '',
  icon: undefined,
  labelVariant: 'default',
  titleVariant: 'default',
  marginBottom: 'mb-20',
})
</script>
