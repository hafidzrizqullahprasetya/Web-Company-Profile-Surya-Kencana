import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

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
    // Network error - cannot connect to backend
    if (error.code === 'ERR_NETWORK' || error.code === 'ECONNABORTED' || !error.response) {
      console.error('Network Error: Cannot connect to backend')

      // Determine if we're in admin panel or frontend
      const isAdmin = window.location.pathname.startsWith('/admin')

      // Redirect to appropriate error page
      if (isAdmin && !window.location.pathname.includes('/admin/error')) {
        window.location.href = '/admin/error?type=connection'
      } else if (!isAdmin && !window.location.pathname.includes('/error')) {
        window.location.href = '/error?type=connection'
      }

      return Promise.reject(error)
    }

    // Response error (4xx, 5xx)
    if (error.response) {
      console.error('Response Error:', error.response.data)

      // Handle 401 Unauthorized
      if (error.response.status === 401) {
        localStorage.removeItem('token')
        localStorage.removeItem('user')

        const isAdmin = window.location.pathname.startsWith('/admin')
        if (isAdmin && !window.location.pathname.includes('/admin/login')) {
          window.location.href = '/admin/login'
        }
      }

      // Handle 404 Not Found
      if (error.response.status === 404) {
        const isAdmin = window.location.pathname.startsWith('/admin')

        if (isAdmin && !window.location.pathname.includes('/admin/error')) {
          window.location.href = '/admin/error?type=404'
        } else if (!isAdmin && !window.location.pathname.includes('/error')) {
          window.location.href = '/error?type=404'
        }
      }
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
  username: string
  email?: string
  created_at?: string
  updated_at?: string
  password?: string
}

export interface Product {
  id: number
  name: string
  description: string
  image_path: string
  image_url: string
  price: number
  client_id: number
  images: string[]
  image_urls: string[]
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
  address?: string
  phone?: string
  email?: string
  map_url?: string
}

export interface Hero {
  id: number
  background: string
  background_url: string
  backgrounds: string[]
  background_urls: string[]
  location: string
  title: string
  machines: number
  clients: number
  customers: number
  experience_years: number
  trust_years: number
}

export interface CompanyHistory {
  id: number
  tahun: number
  judul: string
  deskripsi: string
  image_path: string | null
  image_url: string | null
  images: string[]
  image_urls: string[]
}

export interface SiteSetting {
  id: number
  company_name: string
  company_logo: string | null
  company_logo_url: string | null
  hero_title: string
  hero_subtitle: string
  visi_misi_label: string
  visi_misi_title: string
  produk_label: string
  produk_title: string
  clients_label: string
  clients_title: string
  riwayat_label: string
  riwayat_title: string
  testimoni_label: string
  testimoni_title: string
  kontak_label: string
  kontak_title: string
}

// New interface for combined landing page data
export interface LandingPageData {
  cacheVersion?: number
  lastUpdated?: string
  hero: Hero | null
  visionMission: VisionMission[]
  products: Product[]
  companyHistory: CompanyHistory[]
  testimonials: Testimonial[]
  clients: OurClient[]
  contact: Contact | null
  siteSettings: SiteSetting | null
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
    role?: string
  }
}

export default {
  async login(credentials: LoginRequest): Promise<LoginResponse> {
    try {
      // Use the existing backend login endpoint
      const response = await apiClient.post<LoginResponse>('/login', credentials)
      const data = response.data
      localStorage.setItem('token', data.token)
      localStorage.setItem(
        'user',
        JSON.stringify(data.admin || { id: 0, username: credentials.username }),
      )
      // Role will be set in the Login component based on credentials
      return data
    } catch (error) {
      console.error('Error logging in:', error)
      throw error
    }
  },

  async loginSuperAdmin(credentials: LoginRequest): Promise<LoginResponse> {
    try {
      const response = await apiClient.post<LoginResponse>('/login', credentials)
      const data = response.data
      localStorage.setItem('token', data.token)
      localStorage.setItem(
        'user',
        JSON.stringify(data.admin || { id: 0, username: credentials.username }),
      )
      // Role will be set in the Login component
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
      const response = await apiClient.post<Product>(`/product/${id}`, data, {
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
      const response = await apiClient.post<OurClient>(`/our-client/${id}`, data, {
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

  // ===== HERO ===== (sesuai backend: /hero)
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
  },

  // ===== COMPANY HISTORY ===== (sesuai backend: /company-history)
  async getCompanyHistories(): Promise<CompanyHistory[]> {
    try {
      const response = await apiClient.get<CompanyHistory[]>('/company-history')
      return response.data
    } catch (error) {
      console.error('Error fetching company histories:', error)
      throw error
    }
  },

  async getCompanyHistoryById(id: number): Promise<CompanyHistory> {
    try {
      const response = await apiClient.get<CompanyHistory>(`/company-history/${id}`)
      return response.data
    } catch (error) {
      console.error('Error fetching company history by id:', error)
      throw error
    }
  },

  async createCompanyHistory(data: FormData): Promise<CompanyHistory> {
    try {
      const response = await apiClient.post<CompanyHistory>('/company-history', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      return response.data
    } catch (error) {
      console.error('Error creating company history:', error)
      throw error
    }
  },

  async updateCompanyHistory(id: number, data: FormData): Promise<CompanyHistory> {
    try {
      const response = await apiClient.post<CompanyHistory>(`/company-history/${id}`, data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      return response.data
    } catch (error) {
      console.error('Error updating company history:', error)
      throw error
    }
  },

  async deleteCompanyHistory(id: number): Promise<void> {
    try {
      await apiClient.delete(`/company-history/${id}`)
    } catch (error) {
      console.error('Error deleting company history:', error)
      throw error
    }
  },

  // ===== SITE SETTINGS ===== (sesuai backend: /site-settings)
  async getSiteSettings(): Promise<SiteSetting> {
    try {
      const response = await apiClient.get<SiteSetting>('/site-settings')
      return response.data
    } catch (error) {
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

  // ===== LANDING PAGE DATA (COMBINED) =====
  // New method to fetch all landing page data in one request
  async getLandingPageData(): Promise<LandingPageData> {
    try {
      const response = await apiClient.get<LandingPageData>('/landing-page')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page data:', error)
      throw error
    }
  },

  // ===== LANDING PAGE INDIVIDUAL ENDPOINTS =====
  // Individual landing page endpoints for frontend components
  async getLandingPageHero(): Promise<Hero[]> {
    try {
      const response = await apiClient.get<Hero[]>('/landing-page/hero')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page hero:', error)
      throw error
    }
  },

  async getLandingPageVisionMission(): Promise<VisionMission[]> {
    try {
      const response = await apiClient.get<VisionMission[]>('/landing-page/vision-mission')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page vision mission:', error)
      throw error
    }
  },

  async getLandingPageProducts(): Promise<Product[]> {
    try {
      const response = await apiClient.get<Product[]>('/landing-page/product')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page products:', error)
      throw error
    }
  },

  async getLandingPageCompanyHistory(): Promise<CompanyHistory[]> {
    try {
      const response = await apiClient.get<CompanyHistory[]>('/landing-page/company-history')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page company history:', error)
      throw error
    }
  },

  async getLandingPageTestimonials(): Promise<Testimonial[]> {
    try {
      const response = await apiClient.get<Testimonial[]>('/landing-page/testimonial')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page testimonials:', error)
      throw error
    }
  },

  async getLandingPageClients(): Promise<OurClient[]> {
    try {
      const response = await apiClient.get<OurClient[]>('/landing-page/our-client')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page clients:', error)
      throw error
    }
  },

  async getLandingPageContact(): Promise<Contact[]> {
    try {
      const response = await apiClient.get<Contact[]>('/landing-page/contact')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page contact:', error)
      throw error
    }
  },

  async getLandingPageSiteSettings(): Promise<SiteSetting> {
    try {
      const response = await apiClient.get<SiteSetting>('/landing-page/site-settings')
      return response.data
    } catch (error) {
      console.error('Error fetching landing page site settings:', error)
      throw error
    }
  },
}
