<template>
  <div class="bg-white rounded-lg shadow p-6 animate-pulse">
    <!-- Card title -->
    <div class="h-6 bg-gray-200 rounded w-3/4 mb-4"></div>

    <!-- Card content -->
    <div class="space-y-3">
      <div v-for="i in lines" :key="i" class="h-4 bg-gray-100 rounded" :class="i === lines ? 'w-2/3' : 'w-full'"></div>
    </div>

    <!-- Card footer if needed -->
    <div v-if="footer" class="mt-4 pt-4 border-t border-gray-200">
      <div class="h-8 bg-gray-200 rounded w-32"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
withDefaults(defineProps<{
  lines?: number
  footer?: boolean
}>(), {
  lines: 3,
  footer: false
})
</script>
