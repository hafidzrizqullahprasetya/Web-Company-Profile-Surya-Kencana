import { apiClient } from './api-client'
import type { LoginRequest, LoginResponse } from '../types/models'

export const authApi = {
  async login(credentials: LoginRequest): Promise<LoginResponse> {
    try {
      const response = await apiClient.post<LoginResponse>('/login', credentials)
      const data = response.data
      
      // Store authentication data
      localStorage.setItem('token', data.token)
      localStorage.setItem('user', JSON.stringify(data.admin || { id: 0, username: credentials.username }))
      
      // Determine role based on credentials since backend doesn't return role info
      if (credentials.username === 'superadmin' && credentials.password === 'superadmin123') {
        localStorage.setItem('userRole', 'superadmin')
      } else if (credentials.username === 'admin' && credentials.password === 'admin123') {
        localStorage.setItem('userRole', 'admin')
      } else {
        localStorage.setItem('userRole', 'admin')
      }
      
      return data
    } catch (error) {
      console.error('Error logging in:', error)
      throw error
    }
  },

  async logout(): Promise<void> {
    try {
      await apiClient.post('/logout')
    } catch (error: unknown) {
      const axiosError = error as { response?: { status: number } }
      if (axiosError.response?.status === 401) {
        console.warn('Token expired or invalid during logout, removing token anyway.')
      } else {
        console.error('Error logging out:', error)
        throw error
      }
    } finally {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      localStorage.removeItem('userRole')
    }
  }
}
