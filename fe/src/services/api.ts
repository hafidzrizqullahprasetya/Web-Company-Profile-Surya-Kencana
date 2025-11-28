// Re-export all services for backward compatibility
import {
  apiClient,
  authApi,
  authService,
  visionMissionApi,
  productsApi,
  clientsApi,
  testimonialsApi,
  contactApi,
  heroApi,
  companyHistoryApi,
  siteSettingsApi,
  landingPageApi,
  adminApi,
} from './index'

export {
  apiClient,
  authApi,
  authService,
  visionMissionApi,
  productsApi,
  clientsApi,
  testimonialsApi,
  contactApi,
  heroApi,
  companyHistoryApi,
  siteSettingsApi,
  landingPageApi,
  adminApi,
}

// Re-export types for backward compatibility
export type {
  LoginRequest,
  LoginResponse,
  VisionMission,
  Product,
  OurClient,
  Testimonial,
  Contact,
  Hero,
  CompanyHistory,
  SiteSetting,
  LandingPageData,
  Admin,
} from './index'

// Legacy API object for backward compatibility
const api = {
  // Auth methods
  login: (credentials: any) => authApi.login(credentials),
  logout: () => authApi.logout(),

  // Vision Mission
  getVisionMission: () => visionMissionApi.getVisionMission(),
  updateVisionMission: (data: any) => visionMissionApi.updateVisionMission(data),

  // Products
  getProducts: () => productsApi.getProducts(),
  getProductById: (id: number) => productsApi.getProductById(id),
  createProduct: (data: FormData) => productsApi.createProduct(data),
  updateProduct: (id: number, data: FormData) => productsApi.updateProduct(id, data),
  deleteProduct: (id: number) => productsApi.deleteProduct(id),

  // Clients
  getClients: () => clientsApi.getClients(),
  getClientById: (id: number) => clientsApi.getClientById(id),
  createClient: (data: FormData) => clientsApi.createClient(data),
  updateClient: (id: number, data: FormData) => clientsApi.updateClient(id, data),
  deleteClient: (id: number) => clientsApi.deleteClient(id),

  // Testimonials
  getTestimonials: () => testimonialsApi.getTestimonials(),
  getTestimonialById: (id: number) => testimonialsApi.getTestimonialById(id),
  createTestimonial: (data: any) => testimonialsApi.createTestimonial(data),
  updateTestimonial: (id: number, data: any) => testimonialsApi.updateTestimonial(id, data),
  deleteTestimonial: (id: number) => testimonialsApi.deleteTestimonial(id),

  // Contact
  getContact: () => contactApi.getContact(),
  updateContact: (data: any) => contactApi.updateContact(data),

  // Hero
  getHero: () => heroApi.getHero(),
  updateHero: (data: any) => heroApi.updateHero(data),

  // Company History
  getCompanyHistories: () => companyHistoryApi.getCompanyHistories(),
  getCompanyHistoryById: (id: number) => companyHistoryApi.getCompanyHistoryById(id),
  createCompanyHistory: (data: FormData) => companyHistoryApi.createCompanyHistory(data),
  updateCompanyHistory: (id: number, data: FormData) =>
    companyHistoryApi.updateCompanyHistory(id, data),
  deleteCompanyHistory: (id: number) => companyHistoryApi.deleteCompanyHistory(id),

  // Site Settings
  getSiteSettings: () => siteSettingsApi.getSiteSettings(),
  updateSiteSettings: (data: any) => siteSettingsApi.updateSiteSettings(data),

  // Landing Page
  getLandingPageData: () => landingPageApi.getLandingPageData(),

  // Admin Management
  getAdmins: () => adminApi.getAdmins(),
  getAdminById: (id: number) => adminApi.getAdminById(id),
  createAdmin: (data: any) => adminApi.createAdmin(data),
  updateAdmin: (id: number, data: any) => adminApi.updateAdmin(id, data),
  deleteAdmin: (id: number) => adminApi.deleteAdmin(id),
}

export default api
