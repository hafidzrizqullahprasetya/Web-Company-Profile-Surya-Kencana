<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="home-page">
    <Header />
    <Hero />
    <VisiMisi />
    <Produk />
    <Riwayat />
    <OurClient />
    <Testimoni />
    <Kontak />
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { provide } from 'vue'
import Header from '@/components/frontend/Header.vue'
import Hero from '@/components/frontend/Hero.vue'
import VisiMisi from '@/components/frontend/VisiMisi.vue'
import Produk from '@/components/frontend/Produk.vue'
import Riwayat from '@/components/frontend/Riwayat.vue'
import OurClient from '@/components/frontend/OurClient.vue'
import Testimoni from '@/components/frontend/Testimoni.vue'
import Kontak from '@/components/frontend/Kontak.vue'
import Footer from '@/components/frontend/Footer.vue'

// Dummy Data untuk Testing
const dummyData = {
  visiMisi: {
    id: 1,
    judul: 'About Our Company',
    visi: 'To become the leading real estate company in providing quality properties and excellent service to our customers across Indonesia.',
    misi: `• Provide the best quality properties with modern design\n• Deliver excellent and professional customer service\n• Build long-term relationships with clients\n• Maintain integrity and transparency in every transaction\n• Continuously innovate and improve our services`,
    gambar: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600&h=800&fit=crop&q=80'
  },

  produk: [
    {
      id: 1,
      nama: 'Luxury Villa',
      deskripsi: 'Beautiful luxury villa with modern design and premium facilities in prime location with stunning mountain view',
      harga: 5500000000,
      gambar: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&h=400&fit=crop&q=80'
    },
    {
      id: 2,
      nama: 'Modern Apartment',
      deskripsi: 'Spacious modern apartment with stunning city views and complete amenities in the heart of Jakarta',
      harga: 2500000000,
      gambar: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=600&h=400&fit=crop&q=80'
    },
    {
      id: 3,
      nama: 'Beach House',
      deskripsi: 'Exclusive beach house with private access to white sand beach and beautiful ocean sunset views',
      harga: 7500000000,
      gambar: 'https://images.unsplash.com/photo-1499916078039-922301b0eb9b?w=600&h=400&fit=crop&q=80'
    },
    {
      id: 4,
      nama: 'City Townhouse',
      deskripsi: 'Strategic townhouse in the heart of the city with modern facilities and easy access to shopping centers',
      harga: 3200000000,
      gambar: 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600&h=400&fit=crop&q=80'
    },
    {
      id: 5,
      nama: 'Garden Residence',
      deskripsi: 'Peaceful residence surrounded by beautiful gardens and nature, perfect for family living',
      harga: 4800000000,
      gambar: 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=600&h=400&fit=crop&q=80'
    },
    {
      id: 6,
      nama: 'Penthouse Suite',
      deskripsi: 'Luxurious penthouse suite with panoramic city views and exclusive rooftop access',
      harga: 9500000000,
      gambar: 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=600&h=400&fit=crop&q=80'
    },
    {
      id: 7,
      nama: 'Country House',
      deskripsi: 'Charming country house with large backyard, perfect for weekend getaways and relaxation',
      harga: 3800000000,
      gambar: 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=600&h=400&fit=crop&q=80'
    },
    {
      id: 8,
      nama: 'Urban Loft',
      deskripsi: 'Contemporary urban loft with industrial design elements and high ceilings in trendy neighborhood',
      harga: 2800000000,
      gambar: 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=600&h=400&fit=crop&q=80'
    }
  ],

  riwayat: [
    {
      id: 1,
      tahun: 2015,
      judul: 'Company Founded',
      deskripsi: 'Started our journey in real estate industry with a vision to transform property business'
    },
    {
      id: 2,
      tahun: 2017,
      judul: 'First Milestone',
      deskripsi: 'Successfully completed 50+ projects and earned trust from hundreds of satisfied clients'
    },
    {
      id: 3,
      tahun: 2019,
      judul: 'National Expansion',
      deskripsi: 'Expanded operations to 10 major cities across Indonesia with 5 regional offices'
    },
    {
      id: 4,
      tahun: 2021,
      judul: 'Digital Transformation',
      deskripsi: 'Launched innovative digital platform for seamless property buying experience'
    },
    {
      id: 5,
      tahun: 2023,
      judul: 'Award Winner',
      deskripsi: 'Received Best Developer Award and recognition for excellence in customer service'
    },
    {
      id: 6,
      tahun: 2024,
      judul: 'Sustainability Focus',
      deskripsi: 'Committed to eco-friendly development with green building certifications'
    }
  ],

  clients: [
    {
      id: 1,
      client_name: 'ABC Corp',
      instansi: 'ABC Corporation',
      logo: 'https://placehold.co/150x80/F5F6E4/1C1817?text=ABC+Corp&font=raleway'
    },
    {
      id: 2,
      client_name: 'Tech Solutions',
      instansi: 'Tech Solutions Inc',
      logo: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Tech+Solutions&font=raleway'
    },
    {
      id: 3,
      client_name: 'Global Ventures',
      instansi: 'Global Ventures',
      logo: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Global+Ventures&font=raleway'
    },
    {
      id: 4,
      client_name: 'Prime Industries',
      instansi: 'Prime Industries',
      logo: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Prime+Industries&font=raleway'
    },
    {
      id: 5,
      client_name: 'Elite Group',
      instansi: 'Elite Group',
      logo: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Elite+Group&font=raleway'
    },
    {
      id: 6,
      client_name: 'Summit Holdings',
      instansi: 'Summit Holdings',
      logo: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Summit+Holdings&font=raleway'
    },
    {
      id: 7,
      client_name: 'Metro Bank',
      instansi: 'Metro Bank Indonesia',
      logo: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Metro+Bank&font=raleway'
    },
    {
      id: 8,
      client_name: 'Star Property',
      instansi: 'Star Property Group',
      logo: 'https://placehold.co/150x80/F5F6E4/1C1817?text=Star+Property&font=raleway'
    }
  ],

  testimoni: [
    {
      id: 1,
      client_name: 'Robert Johnson',
      instansi: 'Business Owner',
      isi: 'Excellent service and beautiful properties. The team was very professional and helped us find our dream home. Highly recommended! They went above and beyond to ensure we were satisfied.',
      tanggal: '2024-01-15'
    },
    {
      id: 2,
      client_name: 'Maria Garcia',
      instansi: 'Entrepreneur',
      isi: 'Outstanding experience from start to finish. They made the buying process smooth and stress-free. Very happy with our purchase! The attention to detail was impressive.',
      tanggal: '2024-02-10'
    },
    {
      id: 3,
      client_name: 'James Martinez',
      instansi: 'Investor',
      isi: 'Professional team with great attention to detail. They understood exactly what we were looking for and delivered beyond expectations. Best investment decision ever!',
      tanggal: '2024-03-05'
    },
    {
      id: 4,
      client_name: 'Lisa Anderson',
      instansi: 'Corporate Executive',
      isi: 'Best real estate company I have worked with. Transparent, honest, and truly cares about their clients. Will definitely work with them again for future investments.',
      tanggal: '2024-03-20'
    },
    {
      id: 5,
      client_name: 'Michael Chen',
      instansi: 'IT Consultant',
      isi: 'Amazing experience! The digital platform made everything so easy and convenient. The property quality exceeded our expectations. Highly professional team!',
      tanggal: '2024-04-12'
    },
    {
      id: 6,
      client_name: 'Sarah Williams',
      instansi: 'Doctor',
      isi: 'Found our perfect family home thanks to their dedicated team. They listened to our needs and provided excellent options. Very satisfied with the service!',
      tanggal: '2024-05-08'
    }
  ],

  kontak: {
    id: 1,
    alamat: 'Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta 10220, Indonesia',
    telepon: '+62 21 1234 5678',
    email: 'info@suqatestate.com',
    maps_link: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613!3d-6.1944491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1234567890'
  }
}

// Provide dummy data ke semua child components
provide('dummyVisiMisi', dummyData.visiMisi)
provide('dummyProduk', dummyData.produk)
provide('dummyRiwayat', dummyData.riwayat)
provide('dummyClients', dummyData.clients)
provide('dummyTestimoni', dummyData.testimoni)
provide('dummyKontak', dummyData.kontak)
</script>

<style scoped>
.home-page {
  overflow-x: hidden;
}
</style>
