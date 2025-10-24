import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/views/frontend/Home.vue'

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
          component: () => import('@/views/admin/produk/ProductManagement.vue'),
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
          path: 'riwayat',
          name: 'admin-history',
          component: () => import('@/views/admin/riwayat/AdminManagement.vue'),
          meta: { requiresAuth: true, requiresSuperAdmin: true },
        },
      ],
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
  } else if (requiresSuperAdmin && token) {
    next()
  } else {
    next()
  }
})

export default router
