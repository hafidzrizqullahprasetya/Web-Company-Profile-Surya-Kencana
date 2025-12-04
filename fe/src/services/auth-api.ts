import type { LoginRequest, LoginResponse } from '../types/models'
import { apiClient } from './api-client'

export const authApi = {
  async login(credentials: LoginRequest): Promise<LoginResponse> {
    try {
      const response = await apiClient.post<LoginResponse>('/login', credentials)
      const data = response.data

      // Store authentication data
      localStorage.setItem('token', data.token)

      // Store complete admin object including role
      const adminData = {
        id: data.admin?.id || 0,
        username: data.admin?.username || credentials.username,
        role: data.admin?.role || 'admin'
      }
      localStorage.setItem('user', JSON.stringify(adminData))
      localStorage.setItem('userRole', adminData.role)

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
