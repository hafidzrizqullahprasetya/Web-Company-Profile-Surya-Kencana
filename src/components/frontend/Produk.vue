<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="relative py-32 bg-cream-light overflow-hidden" id="produk">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <div class="inline-block mb-6">
          <span
            class="bg-primary text-white px-6 py-3 text-xs font-semibold uppercase tracking-widest rounded-md"
          >
            PRODUK KAMI
          </span>
        </div>
        <h2
          class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-epilogue font-bold text-secondary leading-tight uppercase tracking-wide mb-10"
        >
          OUR MACHINE
          <span class="text-secondary relative"
            >PRODUCTS
            <div class="absolute -bottom-1 left-0 w-full h-3 bg-primary -z-10"></div></span
          ><br />
          SPECIFICATIONS.
        </h2>
      </div>

      <div class="flex justify-center gap-0 mb-16 flex-wrap">
        <button
          v-for="(machine, index) in floorPlans"
          :key="machine.id"
          @click="setActiveFloor(index)"
          class="bg-white text-secondary border border-secondary/20 px-6 py-4 text-sm font-semibold uppercase tracking-wide cursor-pointer transition-all duration-300 rounded-none first:rounded-l-md last:rounded-r-md not-last:border-r-0"
          :class="{ 'bg-primary text-secondary border-primary': activeFloor === index }"
        >
          {{ machine.name }}
        </button>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-[1fr_350px] gap-16 items-start">
        <div class="relative bg-white rounded-xl p-8 shadow-xl">
          <div class="relative w-full h-[500px] overflow-hidden rounded-lg">
            <img
              :src="floorPlans[activeFloor]?.image"
              :alt="floorPlans[activeFloor]?.name"
              class="w-full h-full object-cover"
            />

            <div
              v-for="point in floorPlans[activeFloor]?.points"
              :key="point.id"
              class="absolute z-10 cursor-pointer"
              :style="{ top: point.y + '%', left: point.x + '%' }"
              @click="showPointInfo(point)"
            >
              <div
                class="w-6 h-6 bg-primary text-secondary rounded-full flex items-center justify-center shadow-lg animate-pulse transition-all duration-300 hover:scale-125"
              >
                <i-lucide:circle class="w-3 h-3" />
              </div>
              <div
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 bg-secondary text-white px-3 py-2 rounded text-xs font-medium whitespace-nowrap mb-2 shadow-lg"
                v-if="point.showTooltip"
              >
                {{ point.name }}
                <div
                  class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-secondary"
                ></div>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-primary rounded-xl overflow-hidden shadow-xl sticky top-5">
          <div class="h-48 overflow-hidden">
            <img
              :src="floorPlans[activeFloor]?.cardImage"
              :alt="floorPlans[activeFloor]?.name"
              class="w-full h-full object-cover"
            />
          </div>

          <div class="p-8 bg-primary">
            <div class="mb-6 pb-4 border-b border-secondary/10">
              <h3 class="text-xl font-epilogue font-bold text-white uppercase tracking-wide">
                {{ floorPlans[activeFloor]?.name }}
              </h3>
            </div>

            <div class="grid grid-cols-1 gap-5 mb-8">
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 bg-secondary/10 text-white rounded-lg flex items-center justify-center"
                >
                  <i-lucide:settings class="w-5 h-5" />
                </div>
                <div>
                  <div
                    class="text-xs font-semibold uppercase tracking-wide text-white opacity-70 mb-1"
                  >
                    CAPACITY
                  </div>
                  <div class="text-lg font-epilogue font-bold text-white">
                    {{ floorPlans[activeFloor]?.capacity }}
                  </div>
                </div>
              </div>

              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 bg-secondary/10 text-white rounded-lg flex items-center justify-center"
                >
                  <i-lucide:zap class="w-5 h-5" />
                </div>
                <div>
                  <div
                    class="text-xs font-semibold uppercase tracking-wide text-white opacity-70 mb-1"
                  >
                    POWER
                  </div>
                  <div class="text-lg font-epilogue font-bold text-white">
                    {{ floorPlans[activeFloor]?.power }}
                  </div>
                </div>
              </div>

              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 bg-secondary/10 text-white rounded-lg flex items-center justify-center"
                >
                  <i-lucide:box class="w-5 h-5" />
                </div>
                <div>
                  <div
                    class="text-xs font-semibold uppercase tracking-wide text-white opacity-70 mb-1"
                  >
                    MATERIAL
                  </div>
                  <div class="text-lg font-epilogue font-bold text-white">
                    {{ floorPlans[activeFloor]?.material }}
                  </div>
                </div>
              </div>

              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 bg-secondary/10 text-white rounded-lg flex items-center justify-center"
                >
                  <i-lucide:ruler class="w-5 h-5" />
                </div>
                <div>
                  <div
                    class="text-xs font-semibold uppercase tracking-wide text-white opacity-70 mb-1"
                  >
                    DIMENSIONS
                  </div>
                  <div class="text-lg font-epilogue font-bold text-white">
                    {{ floorPlans[activeFloor]?.dimensions }}
                  </div>
                </div>
              </div>

              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 bg-secondary/10 text-white rounded-lg flex items-center justify-center"
                >
                  <i-lucide:scale class="w-5 h-5" />
                </div>
                <div>
                  <div
                    class="text-xs font-semibold uppercase tracking-wide text-white opacity-70 mb-1"
                  >
                    WEIGHT
                  </div>
                  <div class="text-lg font-epilogue font-bold text-white">
                    {{ floorPlans[activeFloor]?.weight }}
                  </div>
                </div>
              </div>
            </div>

            <div class="pt-6 border-t border-secondary/10">
              <button
                class="w-full bg-secondary text-white px-6 py-4 text-sm font-semibold uppercase tracking-wide rounded-lg flex items-center justify-center gap-2 transition-all duration-300 hover:bg-secondary/90 hover:-translate-y-0.5"
              >
                <span>Lebih Lanjut</span>
                <i-lucide:arrow-right class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

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
      { id: 4, name: 'Safety Guard', x: 30, y: 65, showTooltip: false },
    ],
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
      { id: 4, name: 'Output Chute', x: 85, y: 55, showTooltip: false },
    ],
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
      { id: 4, name: 'Reject Chute', x: 15, y: 70, showTooltip: false },
    ],
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
      { id: 4, name: 'Coolant System', x: 70, y: 40, showTooltip: false },
    ],
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
      { id: 4, name: 'Safety Fence', x: 20, y: 20, showTooltip: false },
    ],
  },
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
