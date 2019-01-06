import Vue from 'vue'
import './plugins/vuetify'
import App from './App.vue'
import router from './router'
import store from './store'
import Vuetify from 'vuetify'
import axios from 'axios'

Vue.config.productionTip = false;

Vue.use(Vuetify);

const base = axios.create({
  baseURL: 'http://app.beer',
})

Vue.prototype.$http = base

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
