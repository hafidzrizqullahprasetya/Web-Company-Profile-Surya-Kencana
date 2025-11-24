import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import VueLazyload from 'vue-lazyload'

import './assets/main.css'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(VueLazyload, {
  preLoad: 1.3,
  error: 'https://placehold.co/150x150/F5F6E4/1C1817?text=Image+Error',
  loading: 'https://placehold.co/150x150/F5F6E4/1C1817?text=Loading...',
  attempt: 1,
})

app.mount('#app')
