// Core Models
export interface Admin {
  id: number
  username: string
  password?: string
  role?: string
  created_at?: string
  updated_at?: string
}

export interface AdminPreferences {
  id?: number
  admin_id: number
  sidebar_state: 'open' | 'closed'
  menu_order: Record<string, number>
  created_at?: string
  updated_at?: string
}

export interface VisionMission {
  id: number
  vision: string
  mission: string
  created_at?: string
  updated_at?: string
}

export interface Contact {
  id: number
  email?: string
  phone?: string
  address?: string
  map_location_name?: string
  map_url?: string
  created_at?: string
  updated_at?: string
}

export interface Hero {
  id: number
  background: string | null
  backgrounds: string[]
  location: string | null
  title: string | null
  machines: number
  clients: number
  customers: number
  experience_years: number
  trust_years: number
  background_url?: string
  background_urls?: string[]
  created_at?: string
  updated_at?: string
}

export interface SiteSetting {
  id: number
  company_name: string
  company_logo: string | null
  company_logo_url?: string | null
  hero_title: string | null
  hero_subtitle: string | null
  visi_misi_label: string | null
  visi_misi_title: string | null
  produk_label: string | null
  produk_title: string | null
  clients_label: string | null
  clients_title: string | null
  riwayat_label: string | null
  riwayat_title: string | null
  testimoni_label: string | null
  testimoni_title: string | null
  kontak_label: string | null
  kontak_title: string | null
  created_at?: string
  updated_at?: string
}

export interface CompanyHistory {
  id: number
  tahun: number
  judul: string
  deskripsi: string
  image_path: string | null
  images: string[] | null
  order?: number
  image_url?: string
  image_urls?: string[]
  created_at?: string
  updated_at?: string
}

export interface OurClient {
  id: number
  client_name: string
  institution: string | null
  logo_path: string | null
  order?: number
  logo_url?: string
  created_at?: string
  updated_at?: string
}

export interface Product {
  id: number
  client_id: number | null
  name: string
  description: string | null
  image_path: string | null
  price: number
  hide_price: number | boolean
  images: string[] | null
  order?: number
  image_url?: string
  image_urls?: string[]
  client?: OurClient
  created_at?: string
  updated_at?: string
}

export interface Testimonial {
  id: number
  client_name: string
  institution: string | null
  feedback: string
  date: string
  order?: number
  created_at?: string
  updated_at?: string
}

// Auth Types
export interface LoginRequest {
  username?: string
  password?: string
}

export interface LoginResponse {
  token: string
  admin: Admin
}

// Landing Page Data
export interface LandingPageData {
  hero: Hero | null
  visionMission: VisionMission[] | null
  products: Product[]
  clients: OurClient[]
  testimonials: Testimonial[]
  contact: Contact | null
  companyHistory: CompanyHistory[]
  siteSettings: SiteSetting | null
}
