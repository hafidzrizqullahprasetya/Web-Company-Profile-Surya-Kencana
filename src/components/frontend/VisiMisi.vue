<template>
  <section class="visi-misi-section" id="visi-misi">
    <div class="container">
      <div class="section-header">
        <div class="section-badge">
          <span class="badge-text">TENTANG KAMI</span>
        </div>
        <h2 class="section-title">
          CREATE YOUR STORY IN A PLACE<br />
          WHERE <span class="highlight">DREAMS</span> AND REALITY<br />
          MERGE.
        </h2>

        <div class="about-text">
          <p>
            {{
              visiMisi?.tentang ||
              'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
            }}
          </p>
        </div>
      </div>

      <div v-if="isLoading" class="loading-container">
        <div class="loading-spinner"></div>
        <p>Loading vision and mission...</p>
      </div>

      <div v-else-if="error" class="error-container">
        <p class="error-message">{{ error }}</p>
        <button @click="retryFetch" class="retry-btn">Retry</button>
      </div>

      <!-- Main Content Grid -->
      <div v-else-if="visiMisi" class="content-grid">
        <div class="mission-card">
          <div class="card-decoration">
            <div class="decoration-line"></div>
          </div>
          <div class="card-header">
            <div class="card-icon-wrapper">
              <div class="icon-bg">
                <svg
                  width="28"
                  height="28"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </div>
            </div>
            <h3 class="card-title">MISI KAMI</h3>
            <div class="title-underline"></div>
          </div>
          <div class="card-content">
            <p class="card-text">
              {{ visiMisi.mission }}
            </p>
          </div>
        </div>

        <!-- Vision Card (Right) -->
        <div class="vision-card">
          <div class="card-decoration">
            <div class="decoration-dots">
              <span class="dot"></span>
              <span class="dot"></span>
              <span class="dot"></span>
            </div>
          </div>
          <div class="card-header">
            <div class="card-icon-wrapper">
              <div class="icon-bg">
                <svg
                  width="28"
                  height="28"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                </svg>
              </div>
            </div>
            <h3 class="card-title">VISI KAMI</h3>
            <div class="title-underline"></div>
          </div>
          <div class="card-content">
            <p class="card-text">
              {{ visiMisi.vision }}
            </p>
          </div>
        </div>
      </div>

      <!-- CTA Button -->
      <div class="cta-section">
        <router-link to="/contact" class="cta-button">
          <span class="cta-text">Hubungi Kami</span>
          <div class="cta-arrow">→</div>
        </router-link>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api, { type VisionMission } from '@/services/api'

const visiMisi = ref<VisionMission | null>(null)
const isLoading = ref(true)
const error = ref<string | null>(null)

const TOKEN = '1|iY8GANtu5p3qOvjWAhGETnGyCBCy0SCc5KXtpo6uf24b0fa8'

const fetchVisionMission = async () => {
  try {
    isLoading.value = true
    error.value = null
    localStorage.setItem('token', TOKEN)

    const data = await api.getVisionMission()
    visiMisi.value = data

    console.log('Data visi misi:', data)
  } catch (err) {
    console.error('Error fetching visi misi:', err)
    const message = (err as { response?: { data?: { message?: string } } })?.response?.data?.message || 'Failed to load data'
    error.value = message
  } finally {
    isLoading.value = false
  }
}

const retryFetch = () => {
  fetchVisionMission()
}

onMounted(() => {
  fetchVisionMission()
})
</script>

<style scoped>
/* Section Styles */
.visi-misi-section {
  position: relative;
  padding: 120px 0;
  background: rgb(var(--bg-primary));
  overflow: hidden;
}

/* Section Header */
.section-header {
  text-align: center;
  margin-bottom: 80px;
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
  bottom: 20px;
  width: 100%;
  height: 12px;
  background: rgb(var(--primary));
  opacity: 1;
  z-index: -1;
}

/* About Text */
.about-text {
  max-width: 800px;
  margin: 40px auto 0;
  text-align: center;
}

.about-text p {
  font-size: 18px;
  line-height: 1.7;
  color: rgb(var(--text-gray));
  margin: 0;
}

/* Loading State */
.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  text-align: center;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid rgba(229, 243, 70, 0.3);
  border-top: 4px solid rgb(var(--primary));
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 20px;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.loading-container p {
  color: rgb(var(--text-gray));
  font-size: 16px;
}

/* Error State */
.error-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  text-align: center;
}

.error-message {
  color: #e74c3c;
  font-size: 16px;
  margin-bottom: 20px;
  font-weight: 500;
}

.retry-btn {
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.retry-btn:hover {
  background: rgba(229, 243, 70, 0.9);
  transform: translateY(-2px);
}

/* Content Grid - Updated for 2 columns */
.content-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: stretch;
  margin-bottom: 80px;
}

/* Card Base Styles */
.mission-card,
.vision-card {
  position: relative;
  padding: 50px 40px 40px;
  border-radius: 12px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  overflow: hidden;
}

.mission-card:hover,
.vision-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
}

/* Mission Card (Dark Theme) */
.mission-card {
  background: rgb(var(--secondary));
  color: rgb(var(--text-white));
}

.mission-card .card-decoration {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
}

.decoration-line {
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, rgb(var(--primary)), rgba(229, 243, 70, 0.3));
}

/* Vision Card (Light Theme) */
.vision-card {
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  border: 1px solid rgba(229, 243, 70, 0.2);
}

.vision-card .card-decoration {
  position: absolute;
  top: 20px;
  right: 20px;
}

.decoration-dots {
  display: flex;
  gap: 6px;
}

.dot {
  width: 8px;
  height: 8px;
  background: rgb(var(--primary));
  border-radius: 50%;
  opacity: 0.6;
}

/* Vision Card dots - Updated color */
.vision-card .decoration-dots .dot {
  background: rgb(var(--secondary));
  opacity: 0.6;
}

/* Card Headers */
.card-header {
  margin-bottom: 30px;
}

.card-icon-wrapper {
  margin-bottom: 20px;
}

.icon-bg {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.mission-card .icon-bg {
  background: rgba(229, 243, 70, 0.2);
  color: rgb(var(--primary));
}

.vision-card .icon-bg {
  background: rgba(28, 24, 23, 0.1);
  color: rgb(var(--secondary));
}

.card-title {
  font-size: 24px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 12px;
  font-family: 'Epilogue', sans-serif;
}

.mission-card .card-title {
  color: rgb(var(--primary));
}

.vision-card .card-title {
  color: rgb(var(--secondary));
}

.title-underline {
  width: 60px;
  height: 3px;
  background: rgb(var(--bg-primary));
  margin-bottom: 20px;
}

/* Card Content */
.card-text {
  font-size: 16px;
  line-height: 1.8;
  margin-bottom: 30px;
}

.mission-card .card-text {
  color: rgba(255, 255, 255, 0.9);
}

.vision-card .card-text {
  color: rgb(var(--text-gray));
}

/* Card Footers */
.card-footer {
  margin-top: 30px;
  padding-top: 30px;
  border-top: 1px solid rgba(229, 243, 70, 0.2);
}

/* Mission Stats */
.mission-stats {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
}

.stat-item {
  text-align: center;
}

.stat-number {
  display: block;
  font-size: 28px;
  font-weight: 700;
  color: rgb(var(--primary));
  font-family: 'Epilogue', sans-serif;
}

.stat-label {
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: rgba(255, 255, 255, 0.7);
}

.stat-divider {
  width: 1px;
  height: 40px;
  background: rgba(229, 243, 70, 0.3);
}

/* Vision Features */
.vision-features {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.feature-item {
  display: flex;
  align-items: center;
  gap: 12px;
}

.feature-icon {
  width: 24px;
  height: 24px;
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: 700;
  flex-shrink: 0;
}

.feature-text {
  font-size: 14px;
  font-weight: 500;
  color: rgb(var(--text-gray));
}

/* CTA Section */
.cta-section {
  text-align: center;
}

.cta-button {
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  padding: 20px 40px;
  font-size: 16px;
  font-weight: 600;
  text-transform: uppercase;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 12px;
  transition: all 0.3s ease;
  letter-spacing: 1px;
  border-radius: 8px;
  box-shadow: 0 10px 30px rgba(229, 243, 70, 0.3);
}

.cta-button:hover {
  background: rgb(var(--primary-dark));
  transform: translateY(-3px);
  box-shadow: 0 15px 40px rgba(229, 243, 70, 0.4);
}

.cta-arrow {
  font-size: 18px;
  transition: transform 0.3s ease;
}

.cta-button:hover .cta-arrow {
  transform: translateX(4px);
}

/* Responsive Design - Updated */
@media (max-width: 1199px) {
  .content-grid {
    gap: 40px;
  }

  .mission-card,
  .vision-card {
    padding: 40px 30px 30px;
  }
}

@media (max-width: 991px) {
  .content-grid {
    grid-template-columns: 1fr;
    gap: 40px;
  }

  .about-text p {
    font-size: 16px;
  }

  .visi-misi-section {
    padding: 80px 0;
  }
}

@media (max-width: 768px) {
  .section-title {
    font-size: clamp(1.8rem, 5vw, 2.5rem);
  }

  .about-text {
    margin: 30px auto 0;
  }

  .about-text p {
    font-size: 15px;
  }

  .mission-card,
  .vision-card {
    padding: 35px 25px 25px;
  }

  .card-title {
    font-size: 20px;
  }

  .card-text {
    font-size: 14px;
  }

  .section-header {
    margin-bottom: 50px;
  }

  .mission-stats {
    flex-direction: column;
    gap: 15px;
  }

  .stat-divider {
    width: 40px;
    height: 1px;
  }
}

@media (max-width: 480px) {
  .badge-text {
    padding: 10px 20px;
    font-size: 11px;
  }

  .mission-card,
  .vision-card {
    padding: 30px 20px 20px;
  }

  .card-title {
    font-size: 18px;
  }

  .cta-button {
    padding: 16px 32px;
    font-size: 14px;
  }
}
</style>
