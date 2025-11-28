<template>
  <div class="space-y-4 animate-pulse">
    <!-- Repeat for number of fields -->
    <div v-for="i in fields" :key="i" class="space-y-2">
      <!-- Label skeleton -->
      <div class="h-4 bg-gray-200 rounded w-24"></div>
      <!-- Input skeleton -->
      <div class="h-10 bg-gray-200 rounded w-full"></div>
    </div>

    <!-- Button skeleton -->
    <div class="flex gap-2 mt-6">
      <div v-for="i in buttons" :key="i" class="h-10 bg-gray-300 rounded w-24"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  fields?: number
  buttons?: number
}>()

withDefaults(defineProps<{
  fields?: number
  buttons?: number
}>(), {
  fields: 4,
  buttons: 2
})
</script>
