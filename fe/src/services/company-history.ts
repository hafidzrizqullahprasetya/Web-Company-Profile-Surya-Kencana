import type { CompanyHistory } from '../types/models'
import { apiClient } from './api-client'

export const companyHistoryApi = {
  async getCompanyHistories(): Promise<CompanyHistory[]> {
    try {
      const response = await apiClient.get<CompanyHistory[]>('/company-history')
      return response.data
    } catch (error) {
      console.error('Error fetching company histories:', error)
      throw error
    }
  },

  async getCompanyHistoryById(id: number): Promise<CompanyHistory> {
    try {
      const response = await apiClient.get<CompanyHistory>('/company-history/' + id)
      return response.data
    } catch (error) {
      console.error('Error fetching company history by id:', error)
      throw error
    }
  },

  async createCompanyHistory(data: FormData): Promise<CompanyHistory> {
    try {
      const response = await apiClient.post<CompanyHistory>('/company-history', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      return response.data
    } catch (error) {
      console.error('Error creating company history:', error)
      throw error
    }
  },

  async updateCompanyHistory(id: number, data: FormData): Promise<CompanyHistory> {
    try {
      const response = await apiClient.post<CompanyHistory>('/company-history/' + id, data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      return response.data
    } catch (error) {
      console.error('Error updating company history:', error)
      throw error
    }
  },

  async deleteCompanyHistory(id: number): Promise<void> {
    try {
      await apiClient.delete('/company-history/' + id)
    } catch (error) {
      console.error('Error deleting company history:', error)
      throw error
    }
  },

  async reorderCompanyHistories(histories: Array<{ id: number; order: number }>): Promise<void> {
    try {
      await apiClient.post('/company-history/reorder', { histories })
    } catch (error) {
      console.error('Error reordering company histories:', error)
      throw error
    }
  }
}
