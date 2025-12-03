import Swal from 'sweetalert2'

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer
    toast.onmouseleave = Swal.resumeTimer
  },
  customClass: {
    popup: 'colored-toast'
  }
})

export const showToast = {
  success: (message: string) => {
    return Toast.fire({
      icon: 'success',
      title: message,
      iconColor: '#10b981',
    })
  },

  error: (message: string) => {
    return Toast.fire({
      icon: 'error',
      title: message,
      iconColor: '#ef4444',
    })
  },

  warning: (message: string) => {
    return Toast.fire({
      icon: 'warning',
      title: message,
      iconColor: '#f59e0b',
    })
  },

  info: (message: string) => {
    return Toast.fire({
      icon: 'info',
      title: message,
      iconColor: '#3b82f6',
    })
  },
}

export const showConfirm = async (options: {
  title: string
  text?: string
  confirmButtonText?: string
  cancelButtonText?: string
  icon?: 'warning' | 'error' | 'question' | 'info'
}): Promise<boolean> => {
  const result = await Swal.fire({
    title: options.title,
    text: options.text || 'Apakah Anda yakin?',
    icon: options.icon || 'warning',
    showCancelButton: true,
    confirmButtonColor: '#4e240b',
    cancelButtonColor: '#6b7280',
    confirmButtonText: options.confirmButtonText || 'Ya, lanjutkan!',
    cancelButtonText: options.cancelButtonText || 'Batal',
    reverseButtons: true,
    customClass: {
      confirmButton: 'swal2-confirm-custom',
      cancelButton: 'swal2-cancel-custom',
    },
  })

  return result.isConfirmed
}

export const showDeleteConfirm = async (
  title?: string,
  message?: string
): Promise<boolean> => {
  const result = await Swal.fire({
    title: title || 'Hapus Data?',
    text: message || 'Data ini akan dihapus permanen!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal',
    reverseButtons: true,
    iconColor: '#f59e0b',
    customClass: {
      confirmButton: 'swal2-confirm-danger',
      cancelButton: 'swal2-cancel-custom',
    },
  })

  return result.isConfirmed
}

export const showAlert = {
  success: (title: string, text?: string) => {
    return Swal.fire({
      icon: 'success',
      title: title,
      text: text,
      confirmButtonColor: '#4e240b',
      iconColor: '#10b981',
      customClass: {
        confirmButton: 'swal2-confirm-custom',
      },
    })
  },

  error: (title: string, text?: string) => {
    return Swal.fire({
      icon: 'error',
      title: title,
      text: text || 'Terjadi kesalahan!',
      confirmButtonColor: '#4e240b',
      iconColor: '#ef4444',
      customClass: {
        confirmButton: 'swal2-confirm-custom',
      },
    })
  },

  warning: (title: string, text?: string) => {
    return Swal.fire({
      icon: 'warning',
      title: title,
      text: text,
      confirmButtonColor: '#4e240b',
      iconColor: '#f59e0b',
      customClass: {
        confirmButton: 'swal2-confirm-custom',
      },
    })
  },

  info: (title: string, text?: string) => {
    return Swal.fire({
      icon: 'info',
      title: title,
      text: text,
      confirmButtonColor: '#4e240b',
      iconColor: '#3b82f6',
      customClass: {
        confirmButton: 'swal2-confirm-custom',
      },
    })
  },
}

export const showLoading = (title: string = 'Memproses...') => {
  Swal.fire({
    title: title,
    allowOutsideClick: false,
    allowEscapeKey: false,
    showConfirmButton: false,
    didOpen: () => {
      Swal.showLoading()
    },
    customClass: {
      loader: 'swal2-loader-custom'
    }
  })
}

export const closeLoading = () => {
  Swal.close()
}

export default {
  showToast,
  showConfirm,
  showDeleteConfirm,
  showAlert,
  showLoading,
  closeLoading,
}
