<template>
  <Teleport to="body">
    <div class="fixed top-4 right-4 z-[9999] flex flex-col gap-3 max-w-md">
      <TransitionGroup name="toast">
        <div
          v-for="toast in toasts"
          :key="toast.id"
          :class="[
            'flex items-start gap-3 p-4 rounded-lg shadow-lg backdrop-blur-sm',
            'border transition-all duration-300 min-w-[320px]',
            toast.type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : '',
            toast.type === 'error' ? 'bg-red-50 border-red-200 text-red-800' : '',
            toast.type === 'warning' ? 'bg-yellow-50 border-yellow-200 text-yellow-800' : '',
            toast.type === 'info' ? 'bg-blue-50 border-blue-200 text-blue-800' : '',
          ]"
        >
          <!-- Icon -->
          <div class="flex-shrink-0 pt-0.5">
            <!-- Success Icon -->
            <i
              v-if="toast.type === 'success'"
              class="fa-solid fa-check-circle w-5 h-5 text-green-600"
            ></i>
            <!-- Error Icon -->
            <i
              v-else-if="toast.type === 'error'"
              class="fa-solid fa-times-circle w-5 h-5 text-red-600"
            ></i>
            <!-- Warning Icon -->
            <i
              v-else-if="toast.type === 'warning'"
              class="fa-solid fa-exclamation-triangle w-5 h-5 text-yellow-600"
            ></i>
            <!-- Info Icon -->
            <i
              v-else
              class="fa-solid fa-info-circle w-5 h-5 text-blue-600"
            ></i>
          </div>

          <!-- Content -->
          <div class="flex-1 min-w-0">
            <p class="font-medium text-sm">{{ toast.message }}</p>
          </div>

          <!-- Close Button -->
          <button
            @click="removeToast(toast.id)"
            class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition"
          >
            <i class="fa-solid fa-xmark w-4 h-4"></i>
          </button>
        </div>
      </TransitionGroup>
    </div>
  </Teleport>
</template>

<script setup lang="ts">
import { ref } from 'vue'

export interface Toast {
  id: number
  message: string
  type: 'success' | 'error' | 'warning' | 'info'
  duration?: number
}

const toasts = ref<Toast[]>([])
let nextId = 1

const addToast = (message: string, type: Toast['type'] = 'info', duration = 4000) => {
  const id = nextId++
  toasts.value.push({ id, message, type, duration })

  if (duration > 0) {
    setTimeout(() => {
      removeToast(id)
    }, duration)
  }
}

const removeToast = (id: number) => {
  const index = toasts.value.findIndex((t) => t.id === id)
  if (index > -1) {
    toasts.value.splice(index, 1)
  }
}

defineExpose({
  addToast,
  removeToast,
})
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: all 0.3s ease;
}

.toast-enter-from {
  opacity: 0;
  transform: translateX(100%);
}

.toast-leave-to {
  opacity: 0;
  transform: translateX(100%);
}
</style>
