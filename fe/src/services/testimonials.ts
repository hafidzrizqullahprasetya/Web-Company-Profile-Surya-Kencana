import type { Testimonial } from '../types/models'
import { apiClient } from './api-client'

export const testimonialsApi = {
  async getTestimonials(): Promise<Testimonial[]> {
    try {
      const response = await apiClient.get<Testimonial[]>('/testimonial')
      return response.data
    } catch (error) {
      console.error('Error fetching testimonials:', error)
      throw error
    }
  },

  async getTestimonialById(id: number): Promise<Testimonial> {
    try {
      const response = await apiClient.get<Testimonial>('/testimonial/' + id)
      return response.data
    } catch (error) {
      console.error('Error fetching testimonial by id:', error)
      throw error
    }
  },

  async createTestimonial(data: Omit<Testimonial, 'id'>): Promise<Testimonial> {
    try {
      const response = await apiClient.post<Testimonial>('/testimonial', data)
      return response.data
    } catch (error) {
      console.error('Error creating testimonial:', error)
      throw error
    }
  },

  async updateTestimonial(id: number, data: Partial<Testimonial>): Promise<Testimonial> {
    try {
      const response = await apiClient.put<Testimonial>('/testimonial/' + id, data)
      return response.data
    } catch (error) {
      console.error('Error updating testimonial:', error)
      throw error
    }
  },

  async deleteTestimonial(id: number): Promise<void> {
    try {
      await apiClient.delete('/testimonial/' + id)
    } catch (error) {
      console.error('Error deleting testimonial:', error)
      throw error
    }
  },

  async reorderTestimonials(testimonials: Array<{ id: number; order: number }>): Promise<void> {
    try {
      await apiClient.post('/testimonial/reorder', { testimonials })
    } catch (error) {
      console.error('Error reordering testimonials:', error)
      throw error
    }
  }
}
