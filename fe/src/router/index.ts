import Home from '@/views/frontend/Home.vue'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/admin/Login.vue'),
      meta: { requiresNoAuth: true },
    },

    {
      path: '/admin',
      name: 'admin',
      component: () => import('@/components/admin/layouts/AdminLayout.vue'),
      meta: { requiresAuth: true },
      children: [
        {
          path: 'dashboard',
          name: 'admin-dashboard',
          component: () => import('@/views/admin/Dashboard.vue'),
          meta: { requiresAuth: true },
        },
        {
          path: 'produk',
          name: 'admin-product',
          component: () => import('@/views/admin/produk/ManajemenProduk.vue'),
          meta: { requiresAuth: true },
        },
        {
          path: 'our-client',
          name: 'admin-client',
          component: () => import('@/views/admin/our-client/ClientManagement.vue'),
          meta: { requiresAuth: true },
        },
        {
          path: 'testimoni',
          name: 'admin-testimonial',
          component: () => import('@/views/admin/testimoni/TestimonialManagement.vue'),
          meta: { requiresAuth: true },
        },
        {
          path: 'visi-misi',
          name: 'admin-vision-mission',
          component: () => import('@/views/admin/visi-misi/VisionMission.vue'),
          meta: { requiresAuth: true },
        },
        {
          path: 'kontak',
          name: 'admin-contact',
          component: () => import('@/views/admin/kontak/Contact.vue'),
          meta: { requiresAuth: true },
        },
        {
          path: 'admin',
          name: 'admin-history',
          component: () => import('@/views/admin/admin/AdminManagement.vue'),
          meta: { requiresAuth: true, requiresSuperAdmin: true },
        },
        {
          path: 'hero',
          name: 'admin-hero',
          component: () => import('@/views/admin/hero/HeroManagement.vue'),
          meta: { requiresAuth: true },
        },
        {
          path: 'company-history',
          name: 'admin-company-history',
          component: () => import('@/views/admin/company-history/CompanyHistoryManagement.vue'),
          meta: { requiresAuth: true },
        },
        {
          path: 'settings',
          name: 'admin-settings',
          component: () => import('@/views/admin/settings/SiteSettings.vue'),
          meta: { requiresAuth: true },
        },
      ],
    },
    // Error Pages
    {
      path: '/error',
      name: 'error',
      component: () => import('@/views/ErrorPage.vue'),
    },
    {
      path: '/admin/error',
      name: 'admin-error',
      component: () => import('@/views/admin/ErrorPage.vue'),
    },
    {
      path: '/admin/login',
      name: 'admin-login',
      component: () => import('@/views/admin/Login.vue'),
      meta: { requiresNoAuth: true },
    },
    // Catch-all 404 route - must be last
    {
      path: '/:pathMatch(.*)*',
      redirect: (to) => {
        const isAdmin = to.path.startsWith('/admin')
        return isAdmin ? '/admin/error?type=404' : '/error?type=404'
      },
    },
  ],
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth',
      }
    } else if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0, behavior: 'smooth' }
    }
  },
})

// Route guard implementation
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth)
  const requiresSuperAdmin = to.matched.some((record) => record.meta.requiresSuperAdmin)

  if (requiresAuth && !token) {
    next({
      name: 'login',
      query: { redirect: to.fullPath },
    })
  } else if (requiresAuth && token) {
    const userRole = localStorage.getItem('userRole')
    if (requiresSuperAdmin && userRole !== 'superadmin') {
      next({ name: 'admin-dashboard' })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
