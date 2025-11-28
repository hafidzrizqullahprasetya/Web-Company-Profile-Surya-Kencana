export { apiClient } from './api-client'
export { authApi } from './auth-api'
export { authService } from './auth'
export { visionMissionApi } from './vision-mission'
export { productsApi } from './products'
export { clientsApi } from './clients'
export { testimonialsApi } from './testimonials'
export { contactApi } from './contact'
export { heroApi } from './hero'
export { companyHistoryApi } from './company-history'
export { siteSettingsApi } from './site-settings'
export { landingPageApi } from './landing-page'
export { adminApi } from './admin'
export { legacyApi } from './legacy-api'

// Export types
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
} from './types'
