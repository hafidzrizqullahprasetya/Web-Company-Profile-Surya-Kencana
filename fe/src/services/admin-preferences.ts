import { apiClient } from './api-client'
import type { AdminPreferences } from '../types/models'

export const adminPreferencesApi = {
  async getPreferences(adminId: number): Promise<AdminPreferences> {
    try {
      const response = await apiClient.get<AdminPreferences>(`/admin/${adminId}/preferences`)
      return response.data
    } catch (error) {
      console.error('Error fetching admin preferences:', error)
      throw error
    }
  },

  async updatePreferences(adminId: number, data: Partial<AdminPreferences>): Promise<AdminPreferences> {
    try {
      const response = await apiClient.put<AdminPreferences>(`/admin/${adminId}/preferences`, data)
      return response.data
    } catch (error) {
      console.error('Error updating admin preferences:', error)
      throw error
    }
  },

  async updateSidebarState(adminId: number, state: 'open' | 'closed'): Promise<AdminPreferences> {
    try {
      const response = await apiClient.patch<AdminPreferences>(`/admin/${adminId}/preferences/sidebar-state`, { sidebar_state: state })
      return response.data
    } catch (error) {
      console.error('Error updating sidebar state:', error)
      throw error
    }
  },

  async updateMenuOrder(adminId: number, menuOrder: Record<string, number>): Promise<AdminPreferences> {
    try {
      const response = await apiClient.patch<AdminPreferences>(`/admin/${adminId}/preferences/menu-order`, { menu_order: menuOrder })
      return response.data
    } catch (error) {
      console.error('Error updating menu order:', error)
      throw error
    }
  }
}
