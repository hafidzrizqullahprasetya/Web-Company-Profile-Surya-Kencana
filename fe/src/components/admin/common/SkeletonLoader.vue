<template>
  <!-- Stats Card Skeleton -->
  <template v-if="type === 'stats'">
    <div v-for="i in items" :key="i" class="bg-white rounded-2xl shadow-lg p-6 animate-pulse">
      <!-- Icon and badge skeleton -->
      <div class="flex items-center justify-between mb-4">
        <div class="h-12 w-12 bg-gray-200 rounded-full"></div>
        <div class="h-4 w-16 bg-gray-100 rounded"></div>
      </div>

      <!-- Number skeleton -->
      <div class="h-8 bg-gray-200 rounded w-20 mb-2"></div>

      <!-- Label skeleton -->
      <div class="h-4 bg-gray-100 rounded w-24 mb-4"></div>

      <!-- Footer skeleton -->
      <div class="pt-4 border-t border-gray-200">
        <div class="h-3 bg-gray-100 rounded w-32"></div>
      </div>
    </div>
  </template>

  <!-- List Skeleton -->
  <template v-else-if="type === 'list'">
    <div class="space-y-4">
      <div v-for="i in rows" :key="i" class="flex items-center p-4 bg-gray-50 rounded-lg animate-pulse">
        <!-- Icon skeleton -->
        <div class="flex-shrink-0 w-12 h-12 bg-gray-200 rounded-lg mr-4"></div>

        <!-- Content skeleton -->
        <div class="flex-1 space-y-2">
          <div class="h-4 bg-gray-200 rounded w-3/4"></div>
          <div class="h-3 bg-gray-100 rounded w-1/2"></div>
        </div>

        <!-- Right side skeleton -->
        <div class="text-right space-y-2">
          <div class="h-4 bg-gray-200 rounded w-20"></div>
        </div>
      </div>
    </div>
  </template>

  <!-- Table Skeleton -->
  <template v-else-if="type === 'table'">
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

  <!-- Form Skeleton -->
  <template v-else-if="type === 'form'">
    <div class="space-y-4 animate-pulse">
      <!-- Repeat for number of fields -->
      <div v-for="i in rows" :key="i" class="space-y-2">
        <!-- Label skeleton -->
        <div class="h-4 bg-gray-200 rounded w-24"></div>
        <!-- Input skeleton -->
        <div class="h-10 bg-gray-200 rounded w-full"></div>
      </div>

      <!-- Button skeleton -->
      <div class="flex gap-2 mt-6">
        <div v-for="i in 2" :key="i" class="h-10 bg-gray-300 rounded w-24"></div>
      </div>
    </div>
  </template>

  <!-- Card Skeleton -->
  <template v-else>
    <div class="bg-white rounded-lg shadow p-6 animate-pulse">
      <!-- Card title -->
      <div class="h-6 bg-gray-200 rounded w-3/4 mb-4"></div>

      <!-- Card content -->
      <div class="space-y-3">
        <div v-for="i in rows" :key="i" class="h-4 bg-gray-100 rounded" :class="i === rows ? 'w-2/3' : 'w-full'"></div>
      </div>
    </div>
  </template>
</template>

<script setup lang="ts">
withDefaults(
  defineProps<{
    type?: 'stats' | 'list' | 'table' | 'form' | 'card'
    items?: number
    rows?: number
    columns?: number
    gridCols?: number
  }>(),
  {
    type: 'card',
    items: 1,
    rows: 5,
    columns: 4,
    gridCols: 1,
  }
)
</script>
