import type { Toast } from '@/components/common/ToastNotification.vue'

let toastInstance: {
  addToast: (message: string, type: Toast['type'], duration?: number) => void
  removeToast: (id: number) => void
} | null = null

export function useToast() {
  const setToastInstance = (instance: any) => {
    toastInstance = instance
  }

  const showToast = (message: string, type: Toast['type'] = 'info', duration = 4000) => {
    if (toastInstance) {
      toastInstance.addToast(message, type, duration)
    } else {
      console.warn('Toast instance not initialized')
    }
  }

  const success = (message: string, duration = 4000) => {
    showToast(message, 'success', duration)
  }

  const error = (message: string, duration = 4000) => {
    showToast(message, 'error', duration)
  }

  const warning = (message: string, duration = 4000) => {
    showToast(message, 'warning', duration)
  }

  const info = (message: string, duration = 4000) => {
    showToast(message, 'info', duration)
  }

  return {
    setToastInstance,
    showToast,
    success,
    error,
    warning,
    info,
  }
}
