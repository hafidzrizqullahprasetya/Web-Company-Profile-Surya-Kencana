import api from './api'

export const authService = {
  isAuthenticated(): boolean {
    return !!localStorage.getItem('token')
  },
  getCurrentUser() {
    const token = localStorage.getItem('token')
    const userStr = localStorage.getItem('user')
    if (!token || !userStr) return null

    try {
      return JSON.parse(userStr)
    } catch (e) {
      console.error('Error parsing user data:', e)
      return null
    }
  },

  // Get the user role
  getUserRole(): string | null {
    return localStorage.getItem('userRole')
  },

  // Check if user is an admin (not superadmin)
  isAdmin(): boolean {
    return this.isAuthenticated() && this.getUserRole() === 'admin'
  },

  // Check if user is a super admin
  isSuperAdmin(): boolean {
    return this.isAuthenticated() && this.getUserRole() === 'superadmin'
  },

  // Check if user has admin privileges (admin or superadmin)
  hasAdminPrivileges(): boolean {
    return this.isAuthenticated() && (this.isAdmin() || this.isSuperAdmin())
  },

  // Clear authentication data
  logout(): Promise<void> {
    return api.logout()
  },

  // Get the current token
  getToken(): string | null {
    return localStorage.getItem('token')
  }
}
