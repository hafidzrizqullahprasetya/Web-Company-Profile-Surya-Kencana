import { ref, computed, onMounted, readonly } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { authApi, authService } from '@/services'

// Reactive state
const token = ref<string | null>(null)
const user = ref<any>(null)
const userRole = ref<string | null>(null)
const isLoading = ref(false)
const error = ref<string | null>(null)

// Computed properties
const isAuthenticated = computed(() => !!token.value)
const isAdmin = computed(() => isAuthenticated.value && userRole.value === 'admin')
const isSuperAdmin = computed(() => isAuthenticated.value && userRole.value === 'superadmin')
const hasAdminPrivileges = computed(() => isAuthenticated.value && (isAdmin.value || isSuperAdmin.value))

// Helper functions
const loadAuthState = () => {
  token.value = localStorage.getItem('token')
  userRole.value = localStorage.getItem('userRole')

  const userStr = localStorage.getItem('user')
  if (userStr) {
    try {
      user.value = JSON.parse(userStr)
    } catch (err) {
      console.error('Error parsing user data:', err)
      user.value = null
    }
  }
}

const saveAuthState = (authData: { token: string; user: any; userRole: string }) => {
  token.value = authData.token
  user.value = authData.user
  userRole.value = authData.userRole

  localStorage.setItem('token', authData.token)
  localStorage.setItem('user', JSON.stringify(authData.user))
  localStorage.setItem('userRole', authData.userRole)
}

const clearAuthState = () => {
  token.value = null
  user.value = null
  userRole.value = null

  localStorage.removeItem('token')
  localStorage.removeItem('user')
  localStorage.removeItem('userRole')
}

export function useAuth() {
  const router = useRouter()
  const route = useRoute()

  // Initialize auth state on mount
  onMounted(() => {
    loadAuthState()
  })

  // Login function
  const login = async (credentials: { username: string; password: string }) => {
    try {
      isLoading.value = true
      error.value = null

      const response = await authApi.login(credentials)

      // Determine role based on credentials (temporary solution)
      let role = 'admin'
      if (credentials.username === 'superadmin' && credentials.password === 'superadmin123') {
        role = 'superadmin'
      } else if (credentials.username === 'admin' && credentials.password === 'admin123') {
        role = 'admin'
      }

      // Save auth state
      saveAuthState({
        token: response.token,
        user: response.admin,
        userRole: role
      })

      // Redirect to intended page or dashboard
      const redirectPath = (route.query.redirect as string) || '/admin/dashboard'
      router.push(redirectPath)

      return response
    } catch (err: any) {
      console.error('Login error:', err)
      error.value = err.response?.data?.message || 'Login failed. Please check your credentials.'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  // Logout function
  const logout = async () => {
    try {
      await authApi.logout()
    } catch (err) {
      console.error('Logout error:', err)
    } finally {
      clearAuthState()
      router.push('/login')
    }
  }

  // Check if user needs to be redirected (used in login page)
  const checkAuthRedirect = () => {
    if (isAuthenticated.value) {
      const redirectPath = hasAdminPrivileges.value ? '/admin/dashboard' : '/'
      router.push(redirectPath)
    }
  }

  // Refresh auth state (useful after token refresh)
  const refreshAuthState = () => {
    loadAuthState()
  }

  return {
    // State
    token: readonly(token),
    user: readonly(user),
    userRole: readonly(userRole),
    isLoading,
    error,

    // Computed
    isAuthenticated,
    isAdmin,
    isSuperAdmin,
    hasAdminPrivileges,

    // Methods
    login,
    logout,
    checkAuthRedirect,
    refreshAuthState,
  }
}
