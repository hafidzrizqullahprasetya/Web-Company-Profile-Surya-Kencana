declare module 'vue-lazyload' {
  import { Plugin } from 'vue'
  interface VueLazyloadOptions {
    preLoad?: number
    error?: string
    loading?: string
    attempt?: number
    // Add other options as needed
  }
  const VueLazyload: Plugin<VueLazyloadOptions>
  export default VueLazyload
}
