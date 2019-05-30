import Api from '@/api/api'
import mixin from '@/mixin'

// STATE
const state = {
  beers: [],
  totalBeers: 0,
  lastPage: 1
}

// GETTERS
const getters = {
  getBeers: (state) => {
    return state.beers
  },
  getTotalBeers: (state) => {
    return state.totalBeers
  },
  getLastPage: (state) => {
    return state.lastPage
  }
}

// MUTATIONS
const mutations = {
  SET_BEERS (state, beers) {
    state.beers = beers
  },
  SET_TOTAL_BEERS (state, totalPages) {
    state.totalBeers = totalPages
  },
  SET_LAST_PAGE (state, lastPageLink) {
    state.lastPage = lastPageLink ? mixin.methods.getPageParameters(lastPageLink) : 1
  }
}

// ACTIONS
const actions = {
  loadBeers ({ commit }, urlParams) {
    return new Promise((resolve, reject) => {
      Api.fetchBeers(urlParams).then(response => {
        commit('SET_BEERS', response.data['hydra:member'])
        commit('SET_TOTAL_BEERS', response.data['hydra:totalItems'])
        commit('SET_LAST_PAGE', response.data['hydra:view']['hydra:last'])
        resolve()
      }).catch(e => {
        reject(e)
      })
    })
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
