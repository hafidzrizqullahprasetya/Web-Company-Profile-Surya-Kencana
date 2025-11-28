import { apiClient } from './api-client'
import type { Contact } from '../types/models'

export const contactApi = {
  async getContact(): Promise<Contact[]> {
    try {
      const response = await apiClient.get<Contact[]>('/contact')
      return response.data
    } catch (error) {
      console.error('Error fetching contact:', error)
      throw error
    }
  },

  async updateContact(data: Partial<Contact>): Promise<Contact> {
    try {
      const response = await apiClient.put<Contact>('/contact', data)
      return response.data
    } catch (error) {
      console.error('Error updating contact:', error)
      throw error
    }
  }
}
