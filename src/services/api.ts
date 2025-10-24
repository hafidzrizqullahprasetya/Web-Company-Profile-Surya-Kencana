import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api'

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
  name: string
  description: string
  image_path: string
  price: number
  client_id: number
}

export interface OurClient {
  id: number
  client_name: string
  institution: string
  logo_path: string
  logo_url: string
}

export interface Testimonial {
  id: number
  client_name: string
  institution: string
  feedback: string
  date: string
}

export interface Contact {
  id: number
  address: string
  phone: string
  email: string
  map_url: string
}

export interface LoginRequest {
  username: string
  password: string
}

export interface LoginResponse {
  message: string
  token: string
  admin: {
    id: number
    username: string
  }
}

export default {
  async adminLogin(credentials: LoginRequest): Promise<LoginResponse> {
    try {
      const response = await apiClient.post<LoginResponse>('/admin/login', credentials)
      const data = response.data
      localStorage.setItem('token', data.token)
      localStorage.setItem('user', JSON.stringify(data.admin))
      return data
    } catch (error) {
      console.error('Error logging in as admin:', error)
      throw error
    }
  },

  async superAdminLogin(credentials: LoginRequest): Promise<LoginResponse> {
    try {
      const response = await apiClient.post<LoginResponse>('/superadmin/login', credentials)
      const data = response.data
      localStorage.setItem('token', data.token)
      localStorage.setItem('user', JSON.stringify(data.admin))
      return data
    } catch (error) {
      console.error('Error logging in as superadmin:', error)
      throw error
    }
  },

  async logout(): Promise<void> {
    try {
      await apiClient.post('/logout')
    } catch (error: unknown) {
      const axiosError = error as { response?: { status: number } }
      if (axiosError.response?.status === 401) {
        console.warn('Token expired or invalid during logout, removing token anyway.')
      } else {
        console.error('Error logging out:', error)
        throw error
      }
    } finally {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  },

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

  async deleteProduct(id: number): Promise<void> {
    try {
      await apiClient.delete(`/product/${id}`)
    } catch (error) {
      console.error('Error deleting product:', error)
      throw error
    }
  },

  // ===== CLIENT ===== (sesuai backend: /our-client)
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
      const response = await apiClient.get<OurClient>(`/our-client/${id}`)
      return response.data
    } catch (error) {
      console.error('Error fetching client by id:', error)
      throw error
    }
  },

  async createClient(data: Omit<OurClient, 'id'>): Promise<OurClient> {
    try {
      const response = await apiClient.post<OurClient>('/our-client', data)
      return response.data
    } catch (error) {
      console.error('Error creating client:', error)
      throw error
    }
  },

  async updateClient(id: number, data: Partial<OurClient>): Promise<OurClient> {
    try {
      const response = await apiClient.put<OurClient>(`/our-client/${id}`, data)
      return response.data
    } catch (error) {
      console.error('Error updating client:', error)
      throw error
    }
  },

  async deleteClient(id: number): Promise<void> {
    try {
      await apiClient.delete(`/our-client/${id}`)
    } catch (error) {
      console.error('Error deleting client:', error)
      throw error
    }
  },

  // ===== TESTIMONIAL ===== (sesuai backend: /testimonial)
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
      const response = await apiClient.get<Testimonial>(`/testimonial/${id}`)
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
      const response = await apiClient.put<Testimonial>(`/testimonial/${id}`, data)
      return response.data
    } catch (error) {
      console.error('Error updating testimonial:', error)
      throw error
    }
  },

  async deleteTestimonial(id: number): Promise<void> {
    try {
      await apiClient.delete(`/testimonial/${id}`)
    } catch (error) {
      console.error('Error deleting testimonial:', error)
      throw error
    }
  },

  // ===== CONTACT ===== (sesuai backend: /contact)
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
  },
}
