<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div v-for="i in count" :key="i" class="bg-white rounded-lg shadow p-6 animate-pulse">
      <!-- Icon skeleton -->
      <div class="flex items-center justify-between mb-4">
        <div class="h-12 w-12 bg-gray-200 rounded-full"></div>
        <div class="h-4 w-16 bg-gray-100 rounded"></div>
      </div>

      <!-- Number skeleton -->
      <div class="h-8 bg-gray-200 rounded w-20 mb-2"></div>

      <!-- Label skeleton -->
      <div class="h-4 bg-gray-100 rounded w-24"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
withDefaults(defineProps<{
  count?: number
}>(), {
  count: 4
})
</script>
