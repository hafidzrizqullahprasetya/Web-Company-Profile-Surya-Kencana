import { showToast } from '@/utils/sweetalert'

export function useToast() {
  return {
    success: (message: string) => {
      showToast.success(message)
    },
    error: (message: string) => {
      showToast.error(message)
    },
    warning: (message: string) => {
      showToast.warning(message)
    },
    info: (message: string) => {
      showToast.info(message)
    },
  }
}
