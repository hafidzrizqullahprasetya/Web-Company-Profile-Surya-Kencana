<script setup lang="ts">
import { RouterView } from 'vue-router'
</script>

<template>
  <div id="app">
    <RouterView />
  </div>
</template>

<style>
/* Global Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #1C1817;
  background: #fff;
}

#app {
  width: 100%;
  overflow-x: hidden;
}

/* Scrollbar Styling */
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: #E5F346;
  border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
  background: #adb927;
}

/* Smooth Scroll */
html {
  scroll-behavior: smooth;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
  font-family: 'Epilogue', sans-serif;
  font-weight: 600;
  line-height: 1.2;
}

a {
  text-decoration: none;
  color: inherit;
}

ul {
  list-style: none;
}

img {
  max-width: 100%;
  height: auto;
  display: block;
}

/* Container */
.container {
  width: 100%;
  max-width: 1320px;
  margin: 0 auto;
  padding: 0 15px;
}

@media (max-width: 1399px) {
  .container {
    max-width: 1140px;
  }
}

@media (max-width: 1199px) {
  .container {
    max-width: 960px;
  }
}

@media (max-width: 991px) {
  .container {
    max-width: 720px;
  }
}

@media (max-width: 767px) {
  .container {
    max-width: 540px;
  }
}

@media (max-width: 575px) {
  .container {
    max-width: 100%;
  }
}

/* Section Padding */
.section-padding {
  padding: 100px 0;
}

@media (max-width: 991px) {
  .section-padding {
    padding: 80px 0;
  }
}

@media (max-width: 767px) {
  .section-padding {
    padding: 60px 0;
  }
}

/* Loading Animation */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Utility Classes */
.text-center {
  text-align: center;
}

.relative {
  position: relative;
}

.absolute {
  position: absolute;
}

.uppercase {
  text-transform: uppercase;
}

/* Transition */
.transition-all {
  transition: all 0.3s ease-in-out;
}

/* Owl Carousel Override (if needed) */
.owl-carousel .owl-stage-outer {
  overflow: hidden;
}

.owl-carousel .owl-item img {
  width: auto;
  max-width: 100%;
}
</style>
