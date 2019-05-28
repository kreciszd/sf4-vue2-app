import Vue from 'vue'
import './plugins/axios'
import './plugins/vuetify'
import axios from 'axios'
import App from './App.vue'
import router from './router/index'
import store from './store'

Vue.config.productionTip = false

axios.defaults.baseURL = 'http://api.app.beer'
axios.defaults.headers = {
  'Content-Type': 'application/ld+json',
  'Accept': 'application/ld+json'
}

// Vue.prototype.$axios = $axios
// store.$axios = $axios

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
