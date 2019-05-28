import axios from 'axios'

export default {
  fetchBrewers (urlParameters) {
    return axios.get(`api/brewers?${urlParameters}`)
  },
  fetchBeers (urlParameters) {
    return axios.get(`api/beers?${urlParameters}`)
  },
  fetchCategories () {
    return axios.get('api/categories')
  },
  fetchBrewersList () {
    return axios.get('api/brewers?itemsPerPage=1000')
  },
  fetchCountriesList () {
    return axios.get('api/countries')
  },
  fetchTypesList () {
    return axios.get('api/types')
  }
}
