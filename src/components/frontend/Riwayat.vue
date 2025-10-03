<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="gallery-section" id="riwayat">
    <div class="container">
      <div class="section-header">
        <div class="header-content">
          <div class="section-badge">
            <span class="badge-text">GALLERY PROJECTS</span>
          </div>
          <h2 class="section-title">
            DISCOVER OUR <span class="highlight">MACHINE</span><br />
            PROJECTS.
          </h2>
        </div>

        <div class="nav-arrows">
          <button @click="previousSlide" class="nav-btn prev-btn" :disabled="currentIndex === 0">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <button @click="nextSlide" class="nav-btn next-btn" :disabled="currentIndex >= Math.max(0, propertyList.length - itemsPerPage)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>
      </div>

      <div class="properties-wrapper">
        <div class="properties-container">
          <div class="properties-slider" :style="{ transform: `translateX(-${currentIndex * slideWidth}%)` }">
            <div v-for="property in propertyList" :key="property.id" class="property-card">
              <!-- Property Image -->
              <div class="property-image">
                <img :src="property.image" :alt="property.title" class="main-image" />
                <div class="image-overlay">
                  <div class="overlay-content">
                    <button class="view-btn" @click="viewProperty(property)">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/>
                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                      </svg>
                      <span>View Details</span>
                    </button>
                  </div>
                </div>
              </div>

              <div class="property-info">
                <div class="project-category">{{ property.category }}</div>
                <h3 class="property-title">{{ property.title }}</h3>
                <div class="property-location">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M21 10C21 17 12 23 12 23S3 17 3 10C3 5.02944 7.02944 1 12 1C16.9706 1 21 5.02944 21 10Z" stroke="currentColor" stroke-width="2"/>
                    <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/>
                  </svg>
                  <span>{{ property.location }}</span>
                </div>

                <div class="project-details">
                  <div class="detail-item">
                    <div class="detail-icon">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M8 2V6M16 2V6M3 10H21M5 4H19C20.1046 4 21 4.89543 21 6V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V6C3 4.89543 3.89543 4 5 4Z" stroke="currentColor" stroke-width="2"/>
                      </svg>
                    </div>
                    <div class="detail-info">
                      <span class="detail-value">{{ property.year }}</span>
                      <span class="detail-label">Year</span>
                    </div>
                  </div>

                  <div class="detail-item">
                    <div class="detail-icon">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89317 18.7122 8.75608 18.1676 9.45768C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="2"/>
                      </svg>
                    </div>
                    <div class="detail-info">
                      <span class="detail-value">{{ property.client }}</span>
                      <span class="detail-label">Client</span>
                    </div>
                  </div>

                  <div class="detail-item">
                    <div class="detail-icon">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2"/>
                      </svg>
                    </div>
                    <div class="detail-info">
                      <span class="detail-value">{{ property.capacity }}</span>
                      <span class="detail-label">Capacity</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dots-indicator">
        <button
          v-for="(dot, index) in Math.ceil(propertyList.length / itemsPerPage)"
          :key="index"
          @click="goToSlide(index)"
          class="dot"
          :class="{ active: Math.floor(currentIndex / itemsPerPage) === index }"
        ></button>
      </div>
    </div>

    <div v-if="selectedProperty" class="property-modal" @click="closeModal">
      <div class="modal-content" @click.stop>
        <button class="close-btn" @click="closeModal">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
        <div class="modal-image">
          <img :src="selectedProperty.image" :alt="selectedProperty.title" />
        </div>
        <div class="modal-info">
          <div class="modal-category">{{ selectedProperty.category }}</div>
          <h3>{{ selectedProperty.title }}</h3>
          <div class="modal-location">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
              <path d="M21 10C21 17 12 23 12 23S3 17 3 10C3 5.02944 7.02944 1 12 1C16.9706 1 21 5.02944 21 10Z" stroke="currentColor" stroke-width="2"/>
              <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/>
            </svg>
            <span>{{ selectedProperty.location }}</span>
          </div>
          <p>{{ selectedProperty.description }}</p>

          <div class="modal-specs">
            <div class="spec-item">
              <strong>Year:</strong> {{ selectedProperty.year }}
            </div>
            <div class="spec-item">
              <strong>Client:</strong> {{ selectedProperty.client }}
            </div>
            <div class="spec-item">
              <strong>Capacity:</strong> {{ selectedProperty.capacity }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'

interface Property {
  id: number
  title: string
  location: string
  image: string
  category: string
  year: number
  client: string
  capacity: string
  description: string
}

const propertyList = ref<Property[]>([])
const currentIndex = ref(0)
const itemsPerPage = ref(3)
const selectedProperty = ref<Property | null>(null)

const dummyProperties: Property[] = [
  {
    id: 1,
    title: 'MESIN CONVEYOR BELT SYSTEM',
    location: 'PT. Indofood, Jakarta',
    image: 'https://images.unsplash.com/photo-1564182895991-eb97e9673aef?q=80&w=930&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    category: 'Conveyor',
    year: 2023,
    client: 'PT. Indofood',
    capacity: '500kg/h',
    description: 'Sistem conveyor belt otomatis untuk proses packaging makanan dengan kapasitas produksi tinggi dan kontrol kualitas terjamin.'
  },
  {
    id: 2,
    title: 'MESIN PACKAGING OTOMATIS',
    location: 'PT. Unilever, Surabaya',
    image: 'https://images.unsplash.com/photo-1564182895991-eb97e9673aef?q=80&w=930&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    category: 'Packaging',
    year: 2023,
    client: 'PT. Unilever',
    capacity: '1200pcs/h',
    description: 'Mesin packaging otomatis dengan sistem PLC untuk produk consumer goods dengan efisiensi tinggi dan minim waste.'
  },
  {
    id: 3,
    title: 'SISTEM SORTING OTOMATIS',
    location: 'PT. Astra International, Karawang',
    image: 'https://images.unsplash.com/photo-1564182895991-eb97e9673aef?q=80&w=930&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    category: 'Sorting',
    year: 2022,
    client: 'PT. Astra International',
    capacity: '800pcs/h',
    description: 'Sistem sorting otomatis menggunakan teknologi AI dan sensor untuk klasifikasi komponen otomotif dengan akurasi tinggi.'
  },
  {
    id: 4,
    title: 'MESIN CUTTING CNC PRECISION',
    location: 'PT. Krakatau Steel, Cilegon',
    image: 'https://images.unsplash.com/photo-1564182895991-eb97e9673aef?q=80&w=930&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    category: 'CNC Cutting',
    year: 2022,
    client: 'PT. Krakatau Steel',
    capacity: '50mm',
    description: 'Mesin CNC cutting precision untuk pemotongan material steel dengan toleransi ketat dan finishing berkualitas tinggi.'
  },
  {
    id: 5,
    title: 'ROBOTIC WELDING SYSTEM',
    location: 'PT. Toyota Motor, Karawang',
    image: 'https://images.unsplash.com/photo-1564182895991-eb97e9673aef?q=80&w=930&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    category: 'Robotic',
    year: 2024,
    client: 'PT. Toyota Motor',
    capacity: '6-Axis',
    description: 'Sistem robotic welding 6-axis untuk proses pengelasan body kendaraan dengan presisi tinggi dan konsistensi kualitas.'
  },
  {
    id: 6,
    title: 'HEAT TREATMENT FURNACE',
    location: 'PT. Trakindo Utama, Cileungsi',
    image: 'https://images.unsplash.com/photo-1564182895991-eb97e9673aef?q=80&w=930&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    category: 'Furnace',
    year: 2023,
    client: 'PT. Trakindo Utama',
    capacity: '1200°C',
    description: 'Tungku heat treatment untuk proses hardening komponen heavy equipment dengan kontrol suhu presisi dan efisiensi energi.'
  }
]

const slideWidth = computed(() => {
  return 100 / itemsPerPage.value
})

const nextSlide = () => {
  if (currentIndex.value < propertyList.value.length - itemsPerPage.value) {
    currentIndex.value++
  }
}

const previousSlide = () => {
  if (currentIndex.value > 0) {
    currentIndex.value--
  }
}

const goToSlide = (index: number) => {
  currentIndex.value = index * itemsPerPage.value
}

const viewProperty = (property: Property) => {
  selectedProperty.value = property
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  selectedProperty.value = null
  document.body.style.overflow = ''
}

onMounted(() => {
  propertyList.value = dummyProperties

  // Handle responsive items per page
  const handleResize = () => {
    if (window.innerWidth <= 768) {
      itemsPerPage.value = 1
    } else if (window.innerWidth <= 1024) {
      itemsPerPage.value = 2
    } else {
      itemsPerPage.value = 3
    }
    currentIndex.value = 0
  }

  handleResize()
  window.addEventListener('resize', handleResize)
})
</script>

<style scoped>
.gallery-section {
  position: relative;
  padding: 120px 0;
  background: rgb(var(--bg-primary));
  overflow: hidden;
}

/* Section Header */
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 80px;
}

.header-content {
  flex: 1;
}

.section-badge {
  display: inline-block;
  margin-bottom: 24px;
}

.badge-text {
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  padding: 12px 24px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  display: inline-block;
}

.section-title {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 700;
  color: rgb(var(--secondary));
  line-height: 1.1;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-family: 'Epilogue', sans-serif;
}

.highlight {
  color: rgb(var(--secondary));
  position: relative;
  z-index: 1;
}

.highlight::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 8px;
  width: 100%;
  height: 20px;
  background: rgb(var(--primary));
  opacity: 1;
  z-index: -1;
}

/* Navigation Arrows */
.nav-arrows {
  display: flex;
  gap: 12px;
}

.nav-btn {
  width: 50px;
  height: 50px;
  background: rgb(var(--text-white));
  border: 1px solid rgba(28, 24, 23, 0.2);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  color: rgb(var(--secondary));
}

.nav-btn:hover:not(:disabled) {
  background: rgb(var(--primary));
  border-color: rgb(var(--primary));
  color: rgb(var(--secondary));
  transform: translateY(-2px);
}

.nav-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Properties Wrapper dengan jarak atas bawah */
.properties-wrapper {
  margin-bottom: 60px;
}

.properties-container {
  padding: 40px 0; /* Jarak atas bawah */
  overflow: hidden;
}

.properties-slider {
  display: flex;
  transition: transform 0.5s ease;
  gap: 30px;
  padding: 0 20px;
}

.property-card {
  flex: 0 0 calc(33.333% - 20px);
  background: rgb(var(--primary));
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.property-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
  border-color: rgb(var(--primary));
}

/* Property Image */
.property-image {
  position: relative;
  height: 280px;
  overflow: hidden;
}

.main-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.property-card:hover .main-image {
  transform: scale(1.05);
}

.image-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: all 0.3s ease;
}

.property-card:hover .image-overlay {
  opacity: 1;
}

.view-btn {
  background: rgb(var(--bg-primary));
  color: rgb(var(--secondary));
  border: none;
  padding: 14px 28px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.view-btn:hover {
  background: rgb(255, 255, 255);
  transform: scale(1.05);
}

/* Property Info */
.property-info {
  padding: 28px;
}

.project-category {
  background: rgba(255, 255, 251, 0.884);
  color: rgb(var(--secondary));
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  display: inline-block;
  margin-bottom: 16px;
}

.property-title {
  font-size: 18px;
  font-weight: 700;
  color: rgb(var(--secondary));
  margin-bottom: 12px;
  text-transform: uppercase;
  font-family: 'Epilogue', sans-serif;
  line-height: 1.3;
}

.property-location {
  display: flex;
  align-items: center;
  gap: 8px;
  color: rgb(var(--text-gray));
  font-size: 14px;
  margin-bottom: 20px;
  font-weight: 500;
}

/* Project Details */
.project-details {
  display: grid;
  grid-template-columns: 1fr;
  gap: 18px;
  padding-top: 20px;
  border-top: 1px solid rgba(28, 24, 23, 0.1);
}

.detail-item {
  display: flex;
  align-items: center;
  gap: 14px;
}

.detail-icon {
  width: 40px;
  height: 40px;
  background: rgba(229, 243, 70, 0.2);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgb(var(--secondary));
  flex-shrink: 0;
}

.detail-info {
  flex: 1;
}

.detail-value {
  display: block;
  font-size: 16px;
  font-weight: 700;
  color: rgb(var(--secondary));
  font-family: 'Epilogue', sans-serif;
  margin-bottom: 4px;
}

.detail-label {
  font-size: 12px;
  color: rgb(var(--text-gray));
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 600;
}

/* Dots Indicator */
.dots-indicator {
  display: flex;
  justify-content: center;
  gap: 12px;
  margin-top: 20px;
}

.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: rgba(28, 24, 23, 0.3);
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
}

.dot.active {
  background: rgb(var(--primary));
  transform: scale(1.3);
}

/* Property Modal */
.property-modal {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 20px;
  backdrop-filter: blur(5px);
}

.modal-content {
  background: rgb(var(--text-white));
  border-radius: 16px;
  max-width: 700px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
}

.close-btn {
  position: absolute;
  top: 20px;
  right: 20px;
  background: rgba(0, 0, 0, 0.6);
  color: white;
  border: none;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 10;
  transition: all 0.3s ease;
}

.close-btn:hover {
  background: rgba(0, 0, 0, 0.8);
  transform: scale(1.1);
}

.modal-image {
  height: 350px;
  overflow: hidden;
  border-radius: 16px 16px 0 0;
}

.modal-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.modal-info {
  padding: 32px;
}

.modal-category {
  background: rgba(229, 243, 70, 0.2);
  color: rgb(var(--secondary));
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  display: inline-block;
  margin-bottom: 16px;
}

.modal-info h3 {
  font-size: 28px;
  font-weight: 700;
  color: rgb(var(--secondary));
  margin-bottom: 12px;
  font-family: 'Epilogue', sans-serif;
  text-transform: uppercase;
}

.modal-location {
  display: flex;
  align-items: center;
  gap: 8px;
  color: rgb(var(--text-gray));
  font-size: 16px;
  margin-bottom: 20px;
  font-weight: 500;
}

.modal-info p {
  color: rgb(var(--text-gray));
  line-height: 1.7;
  font-size: 16px;
  margin-bottom: 24px;
}

.modal-specs {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  padding-top: 24px;
  border-top: 1px solid rgba(28, 24, 23, 0.1);
}

.spec-item {
  font-size: 15px;
  color: rgb(var(--text-gray));
}

.spec-item strong {
  color: rgb(var(--secondary));
  font-weight: 600;
}

/* Responsive Design */
@media (max-width: 1199px) {
  .property-card {
    flex: 0 0 calc(50% - 15px);
  }

  .properties-container {
    padding: 30px 0;
  }
}

@media (max-width: 991px) {
  .section-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 24px;
    margin-bottom: 60px;
  }

  .nav-arrows {
    align-self: flex-end;
  }

  .gallery-section {
    padding: 100px 0;
  }
}

@media (max-width: 768px) {
  .property-card {
    flex: 0 0 calc(100% - 20px);
  }

  .section-title {
    font-size: clamp(2rem, 6vw, 3rem);
  }

  .gallery-section {
    padding: 80px 0;
  }

  .nav-btn {
    width: 44px;
    height: 44px;
  }

  .properties-container {
    padding: 20px 0;
  }

  .property-info {
    padding: 24px;
  }

  .property-title {
    font-size: 16px;
  }
}

@media (max-width: 480px) {
  .properties-slider {
    padding: 0 16px;
  }

  .property-info {
    padding: 20px;
  }

  .nav-arrows {
    gap: 8px;
  }

  .badge-text {
    padding: 10px 20px;
    font-size: 11px;
  }

  .modal-info {
    padding: 24px;
  }

  .modal-info h3 {
    font-size: 24px;
  }

  .modal-specs {
    grid-template-columns: 1fr;
  }
}
</style>
