<!-- eslint-disable vue/multi-word-component-names -->
<script setup lang="ts">
import { ref, onMounted } from 'vue'

interface InteractivePoint {
  id: number
  name: string
  x: number
  y: number
  showTooltip: boolean
}

interface MachineProduct {
  id: number
  name: string
  image: string
  cardImage: string
  capacity: string
  power: string
  material: string
  dimensions: string
  weight: string
  points: InteractivePoint[]
}

const activeFloor = ref(0)
const floorPlans = ref<MachineProduct[]>([
  {
    id: 1,
    name: 'CONVEYOR BELT',
    image: '/src/assets/images/1.jpg',
    cardImage: '/src/assets/images/1.jpg',
    capacity: '500 kg/h',
    power: '3.5 kW',
    material: 'Steel Frame',
    dimensions: '5m x 1m',
    weight: '850 kg',
    points: [
      { id: 1, name: 'Motor Drive', x: 15, y: 25, showTooltip: false },
      { id: 2, name: 'Belt System', x: 50, y: 35, showTooltip: false },
      { id: 3, name: 'Control Panel', x: 80, y: 20, showTooltip: false },
      { id: 4, name: 'Safety Guard', x: 30, y: 65, showTooltip: false }
    ]
  },
  {
    id: 2,
    name: 'PACKAGING MACHINE',
    image: '/src/assets/images/1.jpg',
    cardImage: '/src/assets/images/1.jpg',
    capacity: '1200 pcs/h',
    power: '7.5 kW',
    material: 'Stainless Steel',
    dimensions: '3m x 2m',
    weight: '1200 kg',
    points: [
      { id: 1, name: 'Feed System', x: 20, y: 30, showTooltip: false },
      { id: 2, name: 'Sealing Unit', x: 45, y: 40, showTooltip: false },
      { id: 3, name: 'Cutting Blade', x: 70, y: 35, showTooltip: false },
      { id: 4, name: 'Output Chute', x: 85, y: 55, showTooltip: false }
    ]
  },
  {
    id: 3,
    name: 'SORTING SYSTEM',
    image: '/src/assets/images/1.jpg',
    cardImage: '/src/assets/images/1.jpg',
    capacity: '800 pcs/h',
    power: '5.0 kW',
    material: 'Aluminum Frame',
    dimensions: '4m x 1.5m',
    weight: '650 kg',
    points: [
      { id: 1, name: 'Sensor Array', x: 25, y: 20, showTooltip: false },
      { id: 2, name: 'Pneumatic Arms', x: 50, y: 45, showTooltip: false },
      { id: 3, name: 'Collection Bins', x: 75, y: 60, showTooltip: false },
      { id: 4, name: 'Reject Chute', x: 15, y: 70, showTooltip: false }
    ]
  },
  {
    id: 4,
    name: 'CNC CUTTING',
    image: '/src/assets/images/1.jpg',
    cardImage: '/src/assets/images/1.jpg',
    capacity: '50mm thick',
    power: '15 kW',
    material: 'Cast Iron Base',
    dimensions: '2.5m x 2m',
    weight: '2500 kg',
    points: [
      { id: 1, name: 'Spindle Head', x: 40, y: 25, showTooltip: false },
      { id: 2, name: 'Work Table', x: 45, y: 50, showTooltip: false },
      { id: 3, name: 'Tool Magazine', x: 20, y: 35, showTooltip: false },
      { id: 4, name: 'Coolant System', x: 70, y: 40, showTooltip: false }
    ]
  },
  {
    id: 5,
    name: 'ROBOTIC WELDER',
    image: '/src/assets/images/1.jpg',
    cardImage: '/src/assets/images/1.jpg',
    capacity: '6-Axis Movement',
    power: '12 kW',
    material: 'Steel Structure',
    dimensions: '3m x 3m',
    weight: '1800 kg',
    points: [
      { id: 1, name: 'Robot Arm', x: 35, y: 40, showTooltip: false },
      { id: 2, name: 'Welding Head', x: 55, y: 30, showTooltip: false },
      { id: 3, name: 'Positioner', x: 60, y: 65, showTooltip: false },
      { id: 4, name: 'Safety Fence', x: 20, y: 20, showTooltip: false }
    ]
  }
])

const setActiveFloor = (index: number) => {
  activeFloor.value = index
  floorPlans.value.forEach((machine) => {
    machine.points.forEach((point) => {
      point.showTooltip = false
    })
  })
}

const showPointInfo = (point: InteractivePoint) => {
  point.showTooltip = !point.showTooltip
  console.log('Point clicked:', point.name)
}

onMounted(() => {
  console.log('Produk component mounted')
})
</script>

<template>
  <section class="produk-section" id="produk">
    <div class="container">
      <div class="section-header">
        <div class="section-badge">
          <span class="badge-text">PRODUK KAMI</span>
        </div>
        <h2 class="section-title">
          OUR MACHINE <span class="highlight">PRODUCTS</span><br />
          SPECIFICATIONS.
        </h2>
      </div>

      <div class="floor-nav">
        <button
          v-for="(machine, index) in floorPlans"
          :key="machine.id"
          @click="setActiveFloor(index)"
          class="floor-btn"
          :class="{ active: activeFloor === index }"
        >
          {{ machine.name }}
        </button>
      </div>

      <div class="content-wrapper">
        <div class="floor-plan-container">
          <div class="floor-plan-image">
            <img
              :src="floorPlans[activeFloor]?.image"
              :alt="floorPlans[activeFloor]?.name"
              class="plan-image"
            />

            <div
              v-for="point in floorPlans[activeFloor]?.points"
              :key="point.id"
              class="interactive-point"
              :style="{ top: point.y + '%', left: point.x + '%' }"
              @click="showPointInfo(point)"
            >
              <div class="point-marker">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                  <circle cx="12" cy="12" r="3" fill="currentColor" />
                </svg>
              </div>
              <div class="point-tooltip" v-if="point.showTooltip">
                {{ point.name }}
              </div>
            </div>
          </div>
        </div>

        <div class="property-card">
          <div class="card-image">
            <img
              :src="floorPlans[activeFloor]?.cardImage"
              :alt="floorPlans[activeFloor]?.name"
              class="card-img"
            />
          </div>

          <div class="card-content">
            <div class="machine-title">
              <h3>{{ floorPlans[activeFloor]?.name }}</h3>
            </div>

            <div class="stats-grid">
              <div class="stat-item">
                <div class="stat-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2"/>
                    <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2"/>
                  </svg>
                </div>
                <div class="stat-info">
                  <div class="stat-label">CAPACITY</div>
                  <div class="stat-value">{{ floorPlans[activeFloor]?.capacity }}</div>
                </div>
              </div>

              <div class="stat-item">
                <div class="stat-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" stroke="currentColor" stroke-width="2"/>
                  </svg>
                </div>
                <div class="stat-info">
                  <div class="stat-label">POWER</div>
                  <div class="stat-value">{{ floorPlans[activeFloor]?.power }}</div>
                </div>
              </div>

              <div class="stat-item">
                <div class="stat-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M21 16V8C20.9996 7.64927 20.9071 7.30481 20.7315 7.00116C20.556 6.69751 20.3037 6.44536 20 6.27L13 2.27C12.696 2.09446 12.3511 2.00205 12 2.00205C11.6489 2.00205 11.304 2.09446 11 2.27L4 6.27C3.69626 6.44536 3.44398 6.69751 3.26846 7.00116C3.09294 7.30481 3.00036 7.64927 3 8V16C3.00036 16.3507 3.09294 16.6952 3.26846 16.9988C3.44398 17.3025 3.69626 17.5546 4 17.73L11 21.73C11.304 21.9055 11.6489 21.9979 12 21.9979C12.3511 21.9979 12.696 21.9055 13 21.73L20 17.73C20.3037 17.5546 20.556 17.3025 20.7315 16.9988C20.9071 16.6952 20.9996 16.3507 21 16Z" stroke="currentColor" stroke-width="2"/>
                  </svg>
                </div>
                <div class="stat-info">
                  <div class="stat-label">MATERIAL</div>
                  <div class="stat-value">{{ floorPlans[activeFloor]?.material }}</div>
                </div>
              </div>

              <div class="stat-item">
                <div class="stat-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M14 2V8H20" stroke="currentColor" stroke-width="2"/>
                    <path d="M16 13H8" stroke="currentColor" stroke-width="2"/>
                    <path d="M16 17H8" stroke="currentColor" stroke-width="2"/>
                    <path d="M10 9H9H8" stroke="currentColor" stroke-width="2"/>
                  </svg>
                </div>
                <div class="stat-info">
                  <div class="stat-label">DIMENSIONS</div>
                  <div class="stat-value">{{ floorPlans[activeFloor]?.dimensions }}</div>
                </div>
              </div>

              <div class="stat-item">
                <div class="stat-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M12 1V23" stroke="currentColor" stroke-width="2"/>
                    <path d="M2.5 6.5L21.5 6.5" stroke="currentColor" stroke-width="2"/>
                  </svg>
                </div>
                <div class="stat-info">
                  <div class="stat-label">WEIGHT</div>
                  <div class="stat-value">{{ floorPlans[activeFloor]?.weight }}</div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button class="cta-button">
                <span class="cta-text">Lebih Lanjut</span>
                <div class="cta-arrow">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path
                      d="M5 12H19M19 12L12 5M19 12L12 19"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.produk-section {
  position: relative;
  padding: 120px 0;
  background: rgb(var(--bg-light));
  overflow: hidden;
}

/* Section Header */
.section-header {
  text-align: center;
  margin-bottom: 60px;
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

/* Floor Navigation */
.floor-nav {
  display: flex;
  justify-content: center;
  gap: 0;
  margin-bottom: 60px;
  flex-wrap: wrap;
}

.floor-btn {
  background: rgb(var(--text-white));
  color: rgb(var(--secondary));
  border: 1px solid rgba(28, 24, 23, 0.2);
  padding: 15px 24px;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.3s ease;
  border-radius: 0;
  position: relative;
  white-space: nowrap;
}

.floor-btn:first-child {
  border-radius: 6px 0 0 6px;
}

.floor-btn:last-child {
  border-radius: 0 6px 6px 0;
}

.floor-btn:not(:last-child) {
  border-right: none;
}

.floor-btn.active,
.floor-btn:hover {
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  border-color: rgb(var(--primary));
  z-index: 2;
}

/* Main Content */
.content-wrapper {
  display: grid;
  grid-template-columns: 1fr 350px;
  gap: 60px;
  align-items: start;
}

/* Floor Plan Container */
.floor-plan-container {
  position: relative;
  background: rgb(var(--text-white));
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.floor-plan-image {
  position: relative;
  width: 100%;
  height: 500px;
  overflow: hidden;
  border-radius: 8px;
}

.plan-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Interactive Points */
.interactive-point {
  position: absolute;
  z-index: 10;
  cursor: pointer;
}

.point-marker {
  width: 24px;
  height: 24px;
  background: rgb(var(--primary));
  color: rgb(var(--secondary));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(229, 243, 70, 0.4);
  animation: pulse 2s infinite;
  transition: all 0.3s ease;
}

.interactive-point:hover .point-marker {
  transform: scale(1.2);
  animation: none;
}

.point-tooltip {
  position: absolute;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  background: rgb(var(--secondary));
  color: rgb(var(--text-white));
  padding: 8px 12px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
  white-space: nowrap;
  margin-bottom: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.point-tooltip::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  border: 4px solid transparent;
  border-top-color: rgb(var(--secondary));
}

@keyframes pulse {
  0%,
  100% {
    box-shadow: 0 4px 12px rgba(229, 243, 70, 0.4);
  }
  50% {
    box-shadow: 0 4px 12px rgba(229, 243, 70, 0.8), 0 0 0 8px rgba(229, 243, 70, 0.2);
  }
}

/* Property Card */
.property-card {
  background: rgb(var(--primary));
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 20px;
}

.card-image {
  height: 200px;
  overflow: hidden;
}

.card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.card-content {
  padding: 30px;
  background: rgb(var(--primary));
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
  margin-bottom: 30px;
}

.stat-item {
  display: flex;
  align-items: center;
  gap: 12px;
}

.stat-icon {
  width: 40px;
  height: 40px;
  background: rgba(28, 24, 23, 0.1);
  color: rgb(var(--secondary));
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.stat-info {
  flex: 1;
}

.stat-label {
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: rgb(var(--secondary));
  opacity: 0.7;
  margin-bottom: 2px;
}

.machine-title {
  margin-bottom: 24px;
  padding-bottom: 16px;
  border-bottom: 1px solid rgba(28, 24, 23, 0.1);
}

.machine-title h3 {
  font-size: 20px;
  font-weight: 700;
  color: rgb(var(--secondary));
  text-transform: uppercase;
  letter-spacing: 1px;
  font-family: 'Epilogue', sans-serif;
  margin: 0;
}

.stat-value {
  font-size: 18px;
  font-weight: 700;
  color: rgb(var(--secondary));
  font-family: 'Epilogue', sans-serif;
  line-height: 1.2;
}

/* CTA Button */
.card-footer {
  border-top: 1px solid rgba(28, 24, 23, 0.1);
  padding-top: 24px;
}

.cta-button {
  width: 100%;
  background: rgb(var(--secondary));
  color: rgb(var(--text-white));
  border: none;
  padding: 16px 24px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.cta-button:hover {
  background: rgba(28, 24, 23, 0.9);
  transform: translateY(-2px);
}

.cta-arrow {
  transition: transform 0.3s ease;
}

.cta-button:hover .cta-arrow {
  transform: translateX(4px);
}

/* Responsive Design */
@media (max-width: 1199px) {
  .content-wrapper {
    grid-template-columns: 1fr 320px;
    gap: 40px;
  }

  .property-card {
    position: relative;
    top: auto;
  }
}

@media (max-width: 991px) {
  .content-wrapper {
    grid-template-columns: 1fr;
    gap: 40px;
  }

  .floor-plan-image {
    height: 400px;
  }

  .produk-section {
    padding: 80px 0;
  }
}

@media (max-width: 768px) {
  .section-title {
    font-size: clamp(2rem, 6vw, 3rem);
  }

  .floor-nav {
    gap: 8px;
    justify-content: stretch;
  }

  .floor-btn {
    flex: 1;
    padding: 12px 16px;
    font-size: 12px;
  }

  .floor-btn:first-child,
  .floor-btn:last-child {
    border-radius: 6px;
  }

  .floor-btn:not(:last-child) {
    border-right: 1px solid rgba(28, 24, 23, 0.2);
  }

  .floor-plan-container {
    padding: 20px;
  }

  .floor-plan-image {
    height: 300px;
  }

  .card-content {
    padding: 24px;
  }
}

@media (max-width: 480px) {
  .floor-nav {
    flex-direction: column;
    gap: 0;
  }

  .floor-btn {
    border-radius: 0 !important;
    border-right: 1px solid rgba(28, 24, 23, 0.2) !important;
    border-bottom: none;
  }

  .floor-btn:first-child {
    border-radius: 6px 6px 0 0 !important;
  }

  .floor-btn:last-child {
    border-radius: 0 0 6px 6px !important;
    border-bottom: 1px solid rgba(28, 24, 23, 0.2);
  }

  .stats-grid {
    gap: 16px;
  }

  .stat-value {
    font-size: 20px;
  }
}
</style>
