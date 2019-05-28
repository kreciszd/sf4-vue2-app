import Api from '@/api/api'

// STATE
const state = {
  brewersList: [],
  countriesList: [],
  typesList: [],
  totalBeers: 0,
  lastPage: 1
}

// GETTERS
const getters = {
  getBrewersList: (state) => {
    return state.brewersList
  },
  getCountriesList: (state) => {
    return state.countriesList
  },
  getTypesList: (state) => {
    return state.typesList
  }
}

// MUTATIONS
const mutations = {
  SET_BREWERS_LIST (state, brewersList) {
    state.brewersList = brewersList
  },
  SET_COUNTRIES_LIST (state, countriesList) {
    state.countriesList = countriesList
  },
  SET_TYPES_LIST (state, typesList) {
    state.typesList = typesList
  }
}

// ACTIONS
const actions = {
  loadBrewersList ({ commit }) {
    return new Promise((resolve, reject) => {
      Api.fetchBrewersList().then(response => {
        commit('SET_BREWERS_LIST', response.data['hydra:member'])
        resolve()
      }).catch(e => {
        reject(e)
      })
    })
  },
  loadCountriesList ({ commit }) {
    return new Promise((resolve, reject) => {
      Api.fetchCountriesList().then(response => {
        commit('SET_COUNTRIES_LIST', response.data['hydra:member'])
        resolve()
      }).catch(e => {
        reject(e)
      })
    })
  },
  loadTypesList ({ commit }) {
    return new Promise((resolve, reject) => {
      Api.fetchTypesList().then(response => {
        commit('SET_TYPES_LIST', response.data['hydra:member'])
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
