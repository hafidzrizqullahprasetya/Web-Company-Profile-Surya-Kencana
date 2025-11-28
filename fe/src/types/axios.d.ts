import 'axios'

declare module 'axios' {
  export interface AxiosRequestConfig {
    metadata?: {
      retryCount?: number
    }
    _retry?: boolean
  }
}
