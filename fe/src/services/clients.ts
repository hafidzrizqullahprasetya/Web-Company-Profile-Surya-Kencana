import type { OurClient } from '../types/models'
import { apiClient } from './api-client'

export const clientsApi = {
  async getClients(): Promise<OurClient[]> {
    try {
      const response = await apiClient.get<OurClient[]>('/our-client')
      return response.data
    } catch (error) {
      console.error('Error fetching clients:', error)
      throw error
    }
  },

  async getClientById(id: number): Promise<OurClient> {
    try {
      const response = await apiClient.get<OurClient>('/our-client/' + id)
      return response.data
    } catch (error) {
      console.error('Error fetching client by id:', error)
      throw error
    }
  },

  async createClient(data: FormData): Promise<OurClient> {
    try {
      const response = await apiClient.post<OurClient>('/our-client', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      return response.data
    } catch (error) {
      console.error('Error creating client:', error)
      throw error
    }
  },

  async updateClient(id: number, data: FormData): Promise<OurClient> {
    try {
      const response = await apiClient.post<OurClient>('/our-client/' + id, data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      return response.data
    } catch (error) {
      console.error('Error updating client:', error)
      throw error
    }
  },

  async deleteClient(id: number): Promise<void> {
    try {
      await apiClient.delete('/our-client/' + id)
    } catch (error) {
      console.error('Error deleting client:', error)
      throw error
    }
  },

  async reorderClients(clients: Array<{ id: number; order: number }>): Promise<void> {
    try {
      await apiClient.post('/our-client/reorder', { clients })
    } catch (error) {
      console.error('Error reordering clients:', error)
      throw error
    }
  }
}
