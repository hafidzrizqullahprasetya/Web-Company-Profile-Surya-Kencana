import { apiClient } from './api-client'
import type { VisionMission } from '../types/models'

export const visionMissionApi = {
  async getVisionMission(): Promise<VisionMission[]> {
    try {
      const response = await apiClient.get<VisionMission[]>('/vision-mission')
      return response.data
    } catch (error) {
      console.error('Error fetching vision mission:', error)
      throw error
    }
  },

  async updateVisionMission(data: Partial<VisionMission>): Promise<VisionMission> {
    try {
      const response = await apiClient.put<VisionMission>('/vision-mission', data)
      return response.data
    } catch (error) {
      console.error('Error updating vision mission:', error)
      throw error
    }
  }
}
