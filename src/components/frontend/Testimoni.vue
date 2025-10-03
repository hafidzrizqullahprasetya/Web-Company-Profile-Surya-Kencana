<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <section class="wpo-testimonial-section-s2 section-padding" id="testimoni">
    <div class="container">
      <div class="wpo-section-title-tp">
        <div class="row">
          <div class="col-lg-7">
            <div class="wpo-section-title-s2">
              <small
                class="inline-block px-8 py-1.5 bg-gray-100 text-gray-800 text-xs font-medium uppercase mb-8"
              >
                Testimonials
              </small>
              <h2 class="text-5xl md:text-6xl lg:text-7xl font-medium uppercase text-gray-900 mb-5">
                Discover the Smiles
                <span class="relative inline-block z-10">
                  Behind Our
                  <span class="absolute left-1 bottom-5 w-[96%] h-5 bg-yellow-400 -z-10"></span>
                </span>
                Success.
              </h2>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="text-center py-20">
        <div
          class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-yellow-400"
        ></div>
        <p class="mt-4 text-gray-600">Loading testimonials...</p>
      </div>

      <!-- Testimonial Carousel -->
      <div
        v-else-if="testimonials.length > 0"
        ref="testimonialCarousel"
        class="wpo-testimonial-wrap owl-carousel"
      >
        <div v-for="testimonial in testimonials" :key="testimonial.id" class="item">
          <div class="testimonial-top-wrap">
            <div class="testimonial-left-item">
              <div class="image">
                <img
                  :src="`https://ui-avatars.com/api/?name=${testimonial.nama_client}&background=E5F346&color=1C1817&size=70`"
                  :alt="testimonial.nama_client"
                />
              </div>
              <div class="text">
                <h4>{{ testimonial.nama_client }}</h4>
                <span>{{ testimonial.instansi }}</span>
              </div>
            </div>
            <div class="ratting">
              <ul>
                <li v-for="star in 5" :key="star">
                  <i class="ti-star"></i>
                </li>
              </ul>
            </div>
          </div>
          <div class="testimonial-text">
            <p>"{{ testimonial.isi }}"</p>
            <small class="text-gray-500 text-sm mt-2 block">{{
              formatDate(testimonial.tanggal)
            }}</small>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-20">
        <div class="mb-4">
          <i class="fi flaticon-user text-6xl text-gray-300"></i>
        </div>
        <p class="text-gray-600 text-lg">No testimonials available at the moment.</p>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick, inject } from 'vue'
import api, { type Testimoni } from '@/services/api'
import $ from 'jquery'
import 'owl.carousel'

const testimonials = ref<Testimoni[]>([])
const isLoading = ref(true)
const testimonialCarousel = ref<HTMLElement | null>(null)

// Inject dummy data
const dummyTestimoni = inject<Testimoni[]>('dummyTestimoni', [])

const formatDate = (dateString: string): string => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

const initCarousel = () => {
  const carousel = testimonialCarousel.value
  if (carousel && testimonials.value.length > 0) {
    nextTick(() => {
      $(carousel).owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        navText: ['<i class="fi flaticon-back"></i>', '<i class="fi flaticon-next"></i>'],
        responsive: {
          0: {
            items: 1,
          },
          768: {
            items: 1,
          },
          992: {
            items: 2,
          },
        },
      })
    })
  }
}

onMounted(async () => {
  try {
    isLoading.value = true

    // Use dummy data for testing
    if (dummyTestimoni && dummyTestimoni.length > 0) {
      testimonials.value = dummyTestimoni
    } else {
      // Fallback to API when backend is ready
      testimonials.value = await api.getTestimoni()
    }

    initCarousel()
  } catch (error) {
    console.error('Error loading testimonials:', error)
    // Use dummy data as fallback on error
    if (dummyTestimoni && dummyTestimoni.length > 0) {
      testimonials.value = dummyTestimoni
      initCarousel()
    }
  } finally {
    isLoading.value = false
  }
})
</script>

<style scoped>
.wpo-testimonial-section-s2 {
  background: #fff;
}

.wpo-testimonial-wrap .item {
  background: #f5f6e4;
  padding: 40px 30px;
  border-radius: 8px;
  margin-bottom: 30px;
}

@media (max-width: 575px) {
  .wpo-testimonial-wrap .item {
    padding: 30px 20px;
  }
}

.testimonial-top-wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

@media (max-width: 575px) {
  .testimonial-top-wrap {
    flex-direction: column;
    align-items: flex-start;
  }
}

.testimonial-top-wrap ul {
  list-style: none;
  display: flex;
}

.testimonial-top-wrap ul li {
  margin-right: 5px;
  color: #e5f346;
}

@media (max-width: 575px) {
  .testimonial-top-wrap ul li {
    font-size: 14px;
  }
}

.testimonial-left-item {
  display: flex;
  align-items: center;
}

@media (max-width: 575px) {
  .testimonial-left-item {
    margin-bottom: 15px;
  }
}

.testimonial-left-item .image {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  overflow: hidden;
  margin-right: 20px;
  position: relative;
}

.testimonial-left-item .image::before {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  content: '';
  border: 2px solid #e5f346;
  border-radius: 50%;
}

.testimonial-left-item .image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.testimonial-left-item .text h4 {
  font-size: 20px;
  font-weight: 600;
  color: #1c1817;
  margin-bottom: 5px;
  font-family: 'Epilogue', sans-serif;
}

.testimonial-left-item .text span {
  font-size: 14px;
  color: #687693;
}

.testimonial-text p {
  font-size: 16px;
  line-height: 1.8;
  color: #525252;
  margin-bottom: 0;
}

@media (max-width: 575px) {
  .testimonial-text p {
    font-size: 15px;
  }
}

/* Owl Carousel Navigation */
:deep(.owl-nav) {
  position: absolute;
  right: 0;
  top: -145px;
  display: flex;
  gap: 10px;
}

@media (max-width: 767px) {
  :deep(.owl-nav) {
    display: none;
  }
}

:deep(.owl-nav [class*='owl-']) {
  background: #f5f6e4;
  width: 58px;
  height: 58px;
  line-height: 63px;
  padding: 0;
  margin: 0;
  border-radius: 0;
  color: #1c1817;
  transition: all 0.3s;
  border: 1px solid transparent;
}

:deep(.owl-nav [class*='owl-']:hover) {
  background: #1c1817;
  color: #fff;
}

:deep(.owl-nav [class*='owl-'] .fi::before) {
  font-size: 20px;
}

/* Owl Carousel Dots */
:deep(.owl-dots) {
  text-align: center;
  margin-top: 40px;
  display: none;
}

@media (max-width: 767px) {
  :deep(.owl-dots) {
    display: block;
    position: relative;
    top: 0;
  }
}

:deep(.owl-dot) {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  display: inline-block;
  background: #e5f346;
  margin: 0 9px;
  position: relative;
  border: transparent;
  padding: 0;
}

:deep(.owl-dot::before) {
  position: absolute;
  top: 4px;
  left: 4px;
  width: 20px;
  height: 20px;
  content: '';
  border: 1px solid transparent;
  border-radius: 50%;
  transform: translate(-50%, -50%);
}

:deep(.owl-dot.active) {
  background-color: #adb927;
}

:deep(.owl-dot.active::before) {
  border: 1px solid #adb927;
}
</style>
