import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api'

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
  timeout: 10000,
})

apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  },
)

apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response) {
      console.error('Response Error:', error.response.data)
      if (error.response.status === 401) {
        localStorage.removeItem('token')
      }
    } else if (error.request) {
      console.error('Request Error:', error.request)
    } else {
      console.error('Error:', error.message)
    }
    return Promise.reject(error)
  },
)

export interface VisionMission {
  id: number
  vision: string
  mission: string
}

export interface Admin {
  id: number
  name: string
  email: string
}

export interface Product {
  id: number
  nama: string
  deskripsi: string
  gambar: string
  harga: number
  client_id: number
}

export interface LoginRequest {
  email: string
  password: string
}

export interface LoginResponse {
  token: string
  user: {
    id: number
    name: string
    email: string
  }
}

export default {
  async login(credentials: LoginRequest): Promise<LoginResponse> {
    try {
      const response = await apiClient.post<LoginResponse>('/login', credentials)
      localStorage.setItem('token', response.data.token)
      return response.data
    } catch (error) {
      console.error('Error logging in:', error)
      throw error
    }
  },

  async logout(): Promise<void> {
    try {
      await apiClient.post('/logout')
      localStorage.removeItem('token')
    } catch (error) {
      console.error('Error logging out:', error)
      throw error
    }
  },

  async getVisionMission(): Promise<VisionMission> {
    try {
      const response = await apiClient.get<VisionMission[]>('/vision-mission')
      if (response.data.length === 0) {
        throw new Error('Data Visi Misi tidak ditemukan');
      }
      return response.data[0]!
    } catch (error) {
      console.error('Error fetching vision mission:', error)
      throw error
    }
  },

  async createVisionMission(data: Omit<VisionMission, 'id'>): Promise<VisionMission> {
    try {
      const response = await apiClient.post<VisionMission>('/vision-mission', data)
      return response.data
    } catch (error) {
      console.error('Error creating vision mission:', error)
      throw error
    }
  },

  async updateVisionMission(id: number, data: Partial<VisionMission>): Promise<VisionMission> {
    try {
      const response = await apiClient.put<VisionMission>(`/vision-mission/${id}`, data)
      return response.data
    } catch (error) {
      console.error('Error updating vision mission:', error)
      throw error
    }
  },

  async deleteVisionMission(id: number): Promise<void> {
    try {
      await apiClient.delete(`/vision-mission/${id}`)
    } catch (error) {
      console.error('Error deleting vision mission:', error)
      throw error
    }
  },

  // ===== ADMIN ===== (sesuai backend: /admin)
  async getAdmins(): Promise<Admin[]> {
    try {
      const response = await apiClient.get<Admin[]>('/admin')
      return response.data
    } catch (error) {
      console.error('Error fetching admins:', error)
      throw error
    }
  },

  async getAdminById(id: number): Promise<Admin> {
    try {
      const response = await apiClient.get<Admin>(`/admin/${id}`)
      return response.data
    } catch (error) {
      console.error('Error fetching admin by id:', error)
      throw error
    }
  },

  async createAdmin(data: Omit<Admin, 'id'>): Promise<Admin> {
    try {
      const response = await apiClient.post<Admin>('/admin', data)
      return response.data
    } catch (error) {
      console.error('Error creating admin:', error)
      throw error
    }
  },

  async updateAdmin(id: number, data: Partial<Admin>): Promise<Admin> {
    try {
      const response = await apiClient.put<Admin>(`/admin/${id}`, data)
      return response.data
    } catch (error) {
      console.error('Error updating admin:', error)
      throw error
    }
  },

  async deleteAdmin(id: number): Promise<void> {
    try {
      await apiClient.delete(`/admin/${id}`)
    } catch (error) {
      console.error('Error deleting admin:', error)
      throw error
    }
  },

  // ===== PRODUCT ===== (sesuai backend: /product)
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
      const response = await apiClient.get<Product>(`/product/${id}`)
      return response.data
    } catch (error) {
      console.error('Error fetching product by id:', error)
      throw error
    }
  },

  async createProduct(data: Omit<Product, 'id'>): Promise<Product> {
    try {
      const response = await apiClient.post<Product>('/product', data)
      return response.data
    } catch (error) {
      console.error('Error creating product:', error)
      throw error
    }
  },

  async updateProduct(id: number, data: Partial<Product>): Promise<Product> {
    try {
      const response = await apiClient.put<Product>(`/product/${id}`, data)
      return response.data
    } catch (error) {
      console.error('Error updating product:', error)
      throw error
    }
  },
}
