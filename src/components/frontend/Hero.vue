<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="hero-section" id="home">
    <div class="hero-slide">
      <div class="slide-inner" :style="{ backgroundImage: `url(${heroData.background})` }">
        <div class="slide-overlay"></div>

        <div class="container">
          <div class="hero-content">
            <div class="slide-content">
              <div class="location-badge">
                <span class="location-text">
                  <svg class="location-icon" width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <path
                      d="M21 10C21 17 12 23 12 23S3 17 3 10C3 5.02944 7.02944 1 12 1C16.9706 1 21 5.02944 21 10Z"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" />
                  </svg>
                  {{ heroData.location }}
                </span>
              </div>

              <div class="hero-title">
                <h1 class="title-text">
                  {{ heroData.title }}
                </h1>
              </div>

              <div class="hero-cta">
                <a href="#kontak" class="hero-btn">
                  <span class="btn-text">Mulai Sekarang</span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="background-text">
          <span class="bg-text-number">01</span>
          <span class="bg-text-multiplier">X</span>
          <span class="bg-text-dimension">960</span>
        </div>
      </div>
    </div>

    <div class="property-details">
      <div class="property-stats">
        <div class="stat-item">
          <div class="stat-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
              <path
                d="M4 6L20 6L18 20H6L4 6Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M2 2L4 6"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M14 12L10 16L14 20"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </div>
          <div class="stat-number">{{ heroData.conveyorMachines }}</div>
          <div class="stat-label">CONVEYOR</div>
        </div>

        <div class="stat-item">
          <div class="stat-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
              <path
                d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </div>
          <div class="stat-number">{{ heroData.packagingMachines }}</div>
          <div class="stat-label">PACKAGING</div>
        </div>

        <div class="stat-item">
          <div class="stat-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
              <path
                d="M12 2L2 7L12 12L22 7L12 2Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M2 17L12 22L22 17"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M2 12L12 17L22 12"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </div>
          <div class="stat-number">{{ heroData.sortingMachines }}</div>
          <div class="stat-label">SORTING</div>
        </div>

        <div class="stat-item">
          <div class="stat-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
              <path
                d="M14.5 2H6C5.89543 2 5.79163 2.02148 5.69686 2.06301L2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V8L14.5 2Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M14 2V8H20"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M10 12H16"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M10 16H16"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </div>
          <div class="stat-number">{{ heroData.cncMachines }}</div>
          <div class="stat-label">CNC CUTTING</div>
        </div>

        <div class="stat-item">
          <div class="stat-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
              <path
                d="M12.5 2C16.6421 2 20 5.35786 20 9.5V14.5C20 18.6421 16.6421 22 12.5 22H4V2H12.5Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M4 7H20"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M4 12H20"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M4 17H12"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </div>
          <div class="stat-number">{{ heroData.roboticMachines }}</div>
          <div class="stat-label">ROBOTIC</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const heroData = ref({
  background:
    'https://plus.unsplash.com/premium_photo-1682144572574-2305752c0f63?q=80&w=1738&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  location: 'Sleman, Yogyakarta',
  title: 'SOLUTION FOR YOUR AUTOMATION MACHINERY',
  conveyorMachines: 15,
  packagingMachines: 12,
  sortingMachines: 8,
  cncMachines: 6,
  roboticMachines: 4,
})
</script>

<style scoped>
/* Hero Section */
.hero-section {
  position: relative;
  width: 100%;
  height: 100vh;
  overflow: hidden;
}

.hero-slide {
  width: 100%;
  height: 100%;
}

/* Slide Styles */
.slide-inner {
  position: relative;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: flex-start;
  padding-top: 130px;
}

.slide-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  z-index: 1;
}

/* Hero Content */
.hero-content {
  position: relative;
  z-index: 10;
  display: flex;
  align-items: center;
  height: 100%;
  margin-top: 20px;
}

.slide-content {
  max-width: 600px;
}

/* Location Badge */
.location-badge {
  margin-bottom: 2rem;
}

.location-text {
  color: rgb(var(--text-white));
  font-weight: 600;
  font-size: 14px;
  padding: 8px 20px;
  background: rgba(28, 24, 23, 0.8);
  border-radius: 4px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.location-icon {
  flex-shrink: 0;
  color: rgb(var(--primary));
}

/* Hero Title */
.hero-title {
  margin: 2rem 0;
}

.title-text {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 700;
  text-transform: uppercase;
  color: rgb(var(--text-white));
  line-height: 1.1;
  margin-bottom: 2rem;
  letter-spacing: 2px;
}

/* Hero Button */
.hero-btn {
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  padding: 16px 32px;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  display: inline-flex;
  align-items: center;
  transition: all 0.3s ease;
  text-decoration: none;
  letter-spacing: 1px;
}

.hero-btn:hover {
  background: rgb(var(--primary-dark));
  transform: translateY(-2px);
}

/* Background Text */
.background-text {
  position: absolute;
  right: 5%;
  top: 50%;
  transform: translateY(-50%);
  z-index: 5;
  font-family: 'Epilogue', sans-serif;
  font-weight: 900;
  opacity: 0.1;
  pointer-events: none;
  display: flex;
  align-items: center;
}

.bg-text-number,
.bg-text-dimension {
  font-size: clamp(8rem, 15vw, 20rem);
  color: rgb(var(--text-white));
  line-height: 0.8;
}

.bg-text-multiplier {
  font-size: clamp(6rem, 12vw, 16rem);
  color: rgb(var(--text-white));
  margin: 0 2rem;
  line-height: 0.8;
}

.property-details {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 20;
  background: rgb(var(--primary));
}

.property-stats {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.stat-item {
  text-align: center;
  padding: 40px 20px;
  flex: 1;
  position: relative;
}

.stat-item:not(:last-child)::after {
  content: '';
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 1px;
  height: 60px;
  background: rgba(28, 24, 23, 0.2);
}

/* Stat Icon */
.stat-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 60px;
  height: 60px;
  background: rgba(28, 24, 23, 0.1);
  border-radius: 50%;
  margin: 0 auto 16px;
  color: rgb(var(--secondary));
  transition: all 0.3s ease;
}

.stat-item:hover .stat-icon {
  background: rgba(28, 24, 23, 0.2);
  transform: scale(1.1);
}

.stat-number {
  font-size: 2.5rem;
  font-weight: 700;
  color: rgb(var(--secondary));
  margin-bottom: 8px;
  font-family: 'Epilogue', sans-serif;
  transition: all 0.3s ease;
}

.stat-item:hover .stat-number {
  transform: scale(1.05);
}

.stat-label {
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  color: rgba(28, 24, 23, 0.8);
  letter-spacing: 1px;
}

.stat-cta {
  padding: 30px 20px;
}

.take-tour-btn {
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  padding: 15px 30px;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  text-decoration: none;
  transition: all 0.3s ease;
  letter-spacing: 1px;
}

.take-tour-btn:hover {
  background: rgb(var(--primary-dark));
  transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 991px) {
  .background-text {
    display: none;
  }

  .property-stats {
    flex-wrap: wrap;
  }

  .stat-item {
    flex: 0 0 20%;
  }
}

@media (max-width: 768px) {
  .title-text {
    font-size: clamp(2rem, 6vw, 3rem);
  }

  .property-stats {
    flex-direction: column;
  }

  .stat-item {
    width: 100%;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  }
}
</style>
