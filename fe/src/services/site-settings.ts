import { apiClient } from './api-client'
import type { SiteSetting } from '../types/models'

export const siteSettingsApi = {
  async getSiteSettings(): Promise<SiteSetting> {
    try {
      const response = await apiClient.get<SiteSetting>('/site-settings')
      return response.data
    } catch (error: any) {
      console.error('Error fetching site settings:', error)
      throw error
    }
  },

  async updateSiteSettings(data: FormData | Partial<SiteSetting>): Promise<SiteSetting> {
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
          ? await apiClient.post<SiteSetting>('/site-settings', data, config)
          : await apiClient.put<SiteSetting>('/site-settings', data)

      return response.data
    } catch (error) {
      console.error('Error updating site settings:', error)
      throw error
    }
  },
}
