import { apiClient } from './api-client'
import type { Hero } from '../types/models'

export const heroApi = {
  async getHero(): Promise<Hero[]> {
    try {
      const response = await apiClient.get<Hero[]>('/hero')
      return response.data
    } catch (error) {
      console.error('Error fetching hero:', error)
      throw error
    }
  },

  async updateHero(data: FormData | Partial<Hero>): Promise<Hero> {
    try {
      const config =
        data instanceof FormData
          ? {
              headers: {
                'Content-Type': 'multipart/form-data',
              },
            }
          : {}

      // Use POST for FormData (multipart), PUT for JSON
      const response =
        data instanceof FormData
          ? await apiClient.post<Hero>('/hero', data, config)
          : await apiClient.put<Hero>('/hero', data)

      return response.data
    } catch (error) {
      console.error('Error updating hero:', error)
      throw error
    }
  }
}
