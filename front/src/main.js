import Vue from 'vue'
import './plugins/vuetify'
import Vuetify from 'vuetify'
import axios from 'axios'
import App from './App.vue'
import router from './router'

Vue.config.productionTip = false

Vue.use(Vuetify)

const base = axios.create({
  baseURL: 'http://api.app.beer'
})

Vue.prototype.$http = base

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
