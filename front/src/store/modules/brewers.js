import Api from '@/api/api'
import mixin from '@/mixin'

// STATE
const state = {
  brewers: [],
  totalBrewers: 0,
  lastPage: 1
}

// GETTERS
const getters = {
  getBrewers: (state) => {
    return state.brewers
  },
  getTotalBrewers: (state) => {
    return state.totalBrewers
  },
  getLastPage: (state) => {
    return state.lastPage
  }
}

// MUTATIONS
const mutations = {
  SET_BREWERS (state, brewers) {
    state.brewers = brewers
  },
  SET_TOTAL_BREWERS (state, totalPages) {
    state.totalBrewers = totalPages
  },
  SET_LAST_PAGE (state, lastPageLink) {
    state.lastPage = lastPageLink ? mixin.methods.getPageParameters(lastPageLink) : 1
  }
}

// ACTIONS
const actions = {
  loadBrewers ({ commit }, urlParams) {
    return new Promise((resolve, reject) => {
      Api.fetchBrewers(urlParams).then(response => {
        commit('SET_BREWERS', response.data['hydra:member'])
        commit('SET_TOTAL_BREWERS', response.data['hydra:totalItems'])
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
