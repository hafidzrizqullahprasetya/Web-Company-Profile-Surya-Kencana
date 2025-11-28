<template>
  <div class="animate-pulse">
    <!-- Table header skeleton -->
    <div class="bg-gray-50 border-b border-gray-200">
      <div class="flex gap-4 p-4">
        <div v-for="i in columns" :key="i" class="h-4 bg-gray-200 rounded flex-1"></div>
      </div>
    </div>

    <!-- Table rows skeleton -->
    <div v-for="i in rows" :key="i" class="border-b border-gray-200">
      <div class="flex gap-4 p-4">
        <div v-for="j in columns" :key="j" class="h-4 bg-gray-100 rounded flex-1"></div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
withDefaults(defineProps<{
  rows?: number
  columns?: number
}>(), {
  rows: 5,
  columns: 4
})
</script>
