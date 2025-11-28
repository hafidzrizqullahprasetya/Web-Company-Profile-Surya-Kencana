import { apiClient } from './api-client'
import type { Admin } from '../types/models'

export const adminApi = {
  async getAdmins(): Promise<Admin[]> {
    try {
      const response = await apiClient.get<Admin[]>('/admin')
      return response.data
    } catch (error) {
      console.error('Error fetching admins:', error)
      throw error
    }
  },

  async getAdminById(id: number): Promise<Admin> {
    try {
      const response = await apiClient.get<Admin>('/admin/' + id)
      return response.data
    } catch (error) {
      console.error('Error fetching admin by id:', error)
      throw error
    }
  },

  async createAdmin(data: Omit<Admin, 'id'>): Promise<Admin> {
    try {
      const response = await apiClient.post<Admin>('/admin', data)
      return response.data
    } catch (error) {
      console.error('Error creating admin:', error)
      throw error
    }
  },

  async updateAdmin(id: number, data: Partial<Admin>): Promise<Admin> {
    try {
      const response = await apiClient.put<Admin>('/admin/' + id, data)
      return response.data
    } catch (error) {
      console.error('Error updating admin:', error)
      throw error
    }
  },

  async deleteAdmin(id: number): Promise<void> {
    try {
      await apiClient.delete('/admin/' + id)
    } catch (error) {
      console.error('Error deleting admin:', error)
      throw error
    }
  }
}
