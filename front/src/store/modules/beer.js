import Api from '@/api/api'

// STATE
const state = {
  beer: {
    onSale: false,
    image: '',
    name: '',
    abv: '',
    price: '',
    pricePerLitre: '',
    size: '',
    imageUrl: '',
    brewer: {
      name: '',
      country: {
        name: '',
        code: ''
      }
    },
    type: {
      name: ''
    },
    category: {
      name: ''
    }
  }
}

// GETTERS
const getters = {
  getBeer: (state) => {
    return state.beer
  }
}

// MUTATIONS
const mutations = {
  SET_BEER (state, beer) {
    state.beer = beer
  }
}

// ACTIONS
const actions = {
  loadBeer ({ commit }, id) {
    return new Promise((resolve, reject) => {
      Api.fetchBeer(id).then(response => {
        commit('SET_BEER', response.data)
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
