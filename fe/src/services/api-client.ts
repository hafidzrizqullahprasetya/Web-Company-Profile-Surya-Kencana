import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
  timeout: 30000, // 30 seconds
})

if (!API_BASE_URL) {
  console.warn('⚠️ VITE_API_BASE_URL is not defined! API calls may fail or hit the wrong endpoint.')
} else {
  console.log(`🔌 API Client initialized with baseURL: ${API_BASE_URL}`)
}

// Retry configuration
const MAX_RETRIES = 0
const RETRY_DELAY = 0

// Helper function to delay
const delay = (ms: number) => new Promise((resolve) => setTimeout(resolve, ms))

// Helper function to determine if error is retryable
const isRetryableError = (error: any) => {
  // Don't retry if we got any response
  if (error.response) {
    return false
  }

  // Don't retry timeout errors
  if (error.code === 'ECONNABORTED' || error.code === 'ETIMEDOUT') {
    return false
  }

  // Don't retry 500 errors
  if (error.response?.status >= 500) {
    return false
  }

  // Only retry for pure network errors (no connection)
  return error.code === 'ERR_NETWORK'
}

apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }

    // Initialize retry count
    config.metadata = { retryCount: 0 }

    return config
  },
  (error) => {
    return Promise.reject(error)
  },
)

apiClient.interceptors.response.use(
  (response) => response,
  async (error) => {
    const config = error.config

    // Check if we should retry - only for network failures
    if (config && isRetryableError(error) && !config._retry) {
      config.metadata = config.metadata || { retryCount: 0 }

      if (config.metadata.retryCount < MAX_RETRIES) {
        config.metadata.retryCount++
        config._retry = true // Mark to prevent infinite loops

        console.warn(`⚠️ Network error, retrying (${config.metadata.retryCount}/${MAX_RETRIES})...`)

        // Wait before retrying
        await delay(RETRY_DELAY)

        // Retry the request
        return apiClient(config)
      } else {
        console.error('❌ Max retries reached, giving up')
      }
    }

    // Timeout error - don't redirect, just fail silently
    if (error.code === 'ECONNABORTED' || error.code === 'ETIMEDOUT') {
      console.warn('⏱️ Request timeout - data may still be loading')
      return Promise.reject(error)
    }

    if (error.code === 'ERR_NETWORK' || !error.response) {
      console.error('❌ Network Error: Cannot connect to backend')
      return Promise.reject(error)
    }

    // Response error (4xx, 5xx)
    if (error.response) {
      console.error('Response Error:', error.response.data)

      // Handle 401 Unauthorized
      if (error.response.status === 401) {
        localStorage.removeItem('token')
        localStorage.removeItem('user')

        const isAdmin = window.location.pathname.startsWith('/admin')
        if (isAdmin && !window.location.pathname.includes('/admin/login')) {
          window.location.href = '/admin/login'
        }
      }

      // Handle 404 Not Found
      if (error.response.status === 404) {
        console.warn('Resource not found (404)')
      }

      // Handle 500+ Server Errors - just log, don't redirect
      if (error.response.status >= 500) {
        console.error('Server error:', error.response.status)
      }
    }

    return Promise.reject(error)
  },
)

export { apiClient }
