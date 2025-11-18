import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import VueLazyload from 'vue-lazyload'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
  faArrowRight,
  faArrowUp,
  faUser,
  faBars,
  faTimes,
  faMapMarkerAlt,
  faEnvelope,
  faPhone,
  faChevronLeft,
  faChevronRight,
  faChevronDown,
  faChevronUp,
  faQuoteLeft,
  faCalendar,
  faBuilding,
  faMap,
  faStar,
  faEye,
  faExternalLinkAlt,
  faLightbulb,
  faBox,
  faImages,
  faHandshake,
  faCommentDots,
  faCog,
  faUsers,
  faShieldAlt,
  faClock,
  faTag,
} from '@fortawesome/free-solid-svg-icons'
import {
  faWhatsapp,
  faFacebook,
  faTwitter,
  faInstagram,
  faLinkedin,
} from '@fortawesome/free-brands-svg-icons'

library.add(
  faArrowRight,
  faArrowUp,
  faUser,
  faBars,
  faTimes,
  faMapMarkerAlt,
  faEnvelope,
  faPhone,
  faChevronLeft,
  faChevronRight,
  faChevronDown,
  faChevronUp,
  faQuoteLeft,
  faCalendar,
  faBuilding,
  faWhatsapp,
  faFacebook,
  faTwitter,
  faInstagram,
  faLinkedin,
  faMap,
  faStar,
  faEye,
  faExternalLinkAlt,
  faLightbulb,
  faBox,
  faImages,
  faHandshake,
  faCommentDots,
  faCog,
  faUsers,
  faShieldAlt,
  faClock,
  faTag,
)

import './assets/main.css'

const app = createApp(App)

app.component('font-awesome-icon', FontAwesomeIcon)

app.use(createPinia())
app.use(router)
app.use(VueLazyload, {
  preLoad: 1.3,
  error: 'https://placehold.co/150x150/F5F6E4/1C1817?text=Image+Error',
  loading: 'https://placehold.co/150x150/F5F6E4/1C1817?text=Loading...',
  attempt: 1,
})

app.mount('#app')
