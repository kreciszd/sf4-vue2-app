import Vue from 'vue'
import Vuex from 'vuex'
import beers from './modules/beers'
import brewers from './modules/brewers'
import filters from './modules/filters'
import createLogger from '../../src/plugins/logger'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    beers,
    brewers,
    filters
  },
  strict: debug,
  plugins: debug ? [createLogger()] : []
})
