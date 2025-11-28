import { apiClient } from './api-client'
import type { LandingPageData } from '../types/models'

export const landingPageApi = {
  async getLandingPageData(): Promise<LandingPageData> {
    try {
      const response = await apiClient.get<LandingPageData>('/landing-page')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page data:', error)
      throw error
    }
  },
}
