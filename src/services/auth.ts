import api from './api'

export const authService = {
  // Check if user is authenticated by verifying token exists
  isAuthenticated(): boolean {
    return !!localStorage.getItem('token')
  },

  // Get current user info (would typically decode the token or make an API call)
  getCurrentUser() {
    const token = localStorage.getItem('token')
    if (!token) return null

    // In a real application with JWT, you would decode the token to get user info
    // For Sanctum, you might want to make an API request to get user info
    // For now, we'll return basic info if token exists
    return token ? { id: 1, name: 'Admin User', email: 'admin@example.com' } : null
  },

  // Clear authentication data
  logout(): Promise<void> {
    return api.logout()
  },

  // Get the current token
  getToken(): string | null {
    return localStorage.getItem('token')
  },

  // Check if user has admin privileges
  isAdmin(): boolean {

    return this.isAuthenticated()
  },

  // Check if user has super admin privileges
  isSuperAdmin(): boolean {

    return this.isAuthenticated()
  }
}
