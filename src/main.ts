import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'

// Import custom styles if any
import './assets/main.css'

// Define dummy data types
interface OurClient {
  id: number
  client_name: string
  institution: string
  logo_path: string
  logo_url: string
}

interface Testimonial {
  id: number
  client_name: string
  instansi: string
  isi: string
  tanggal: string
}

// Dummy data
const dummyClients: OurClient[] = [
  {
    id: 1,
    client_name: 'ABC Corp',
    institution: 'ABC Corporation',
    logo_path: 'path/to/logo1.png',
    logo_url: 'https://placehold.co/150x80/F5F6E4/1C1817?text=ABC+Corp',
  },
  {
    id: 2,
    client_name: 'XYZ Inc',
    institution: 'XYZ Incorporated',
    logo_path: 'path/to/logo2.png',
    logo_url: 'https://placehold.co/150x80/F5F6E4/1C1817?text=XYZ+Inc',
  },
  {
    id: 3,
    client_name: 'Tech Solutions',
    institution: 'Technology Solutions Ltd',
    logo_path: 'path/to/logo3.png',
    logo_url: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Tech+Solutions',
  },
  {
    id: 4,
    client_name: 'Global Ventures',
    institution: 'Global Ventures Group',
    logo_path: 'path/to/logo4.png',
    logo_url: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Global+Ventures',
  },
  {
    id: 5,
    client_name: 'Prime Industries',
    institution: 'Prime Industries Co',
    logo_path: 'path/to/logo5.png',
    logo_url: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Prime+Industries',
  },
]

const dummyTestimonials: Testimonial[] = [
  {
    id: 1,
    client_name: 'Robert Johnson',
    instansi: 'Business Owner',
    isi: 'Excellent service and beautiful properties. The team was very professional and helped us find our dream home.',
    tanggal: '2024-01-15'
  },
  {
    id: 2,
    client_name: 'Maria Garcia',
    instansi: 'Entrepreneur',
    isi: 'Outstanding experience from start to finish. They made the buying process smooth and stress-free.',
    tanggal: '2024-02-10'
  },
  {
    id: 3,
    client_name: 'James Martinez',
    instansi: 'Investor',
    isi: 'Professional team with great attention to detail. They understood exactly what we were looking for.',
    tanggal: '2024-03-05'
  }
]

const app = createApp(App)

app.use(createPinia())
app.use(router)

// Provide dummy data globally
app.provide('dummyClients', dummyClients)
app.provide('dummyTestimonials', dummyTestimonials)

app.mount('#app')
