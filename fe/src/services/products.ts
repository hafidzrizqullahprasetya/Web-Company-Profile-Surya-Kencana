import type { Product } from '../types/models'
import { apiClient } from './api-client'

export const productsApi = {
  async getProducts(): Promise<Product[]> {
    try {
      const response = await apiClient.get<Product[]>('/product')
      return response.data
    } catch (error) {
      console.error('Error fetching products:', error)
      throw error
    }
  },

  async getProductById(id: number): Promise<Product> {
    try {
      const response = await apiClient.get<Product>('/product/' + id)
      return response.data
    } catch (error) {
      console.error('Error fetching product by id:', error)
      throw error
    }
  },

  async createProduct(data: FormData): Promise<Product> {
    try {
      const response = await apiClient.post<Product>('/product', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      return response.data
    } catch (error) {
      console.error('Error creating product:', error)
      throw error
    }
  },

  async updateProduct(id: number, data: FormData): Promise<Product> {
    try {
      const response = await apiClient.post<Product>('/product/' + id, data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      return response.data
    } catch (error) {
      console.error('Error updating product:', error)
      throw error
    }
  },

  async deleteProduct(id: number): Promise<void> {
    try {
      await apiClient.delete('/product/' + id)
    } catch (error) {
      console.error('Error deleting product:', error)
      throw error
    }
  },

  async reorderProducts(products: Array<{ id: number; order: number }>): Promise<{ data?: Product[] }> {
    try {
      const response = await apiClient.post<{ message: string; data: Product[] }>('/product/reorder', { products })
      return response.data
    } catch (error) {
      console.error('Error reordering products:', error)
      throw error
    }
  }
}
