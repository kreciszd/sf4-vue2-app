<template>
  <v-flex xs12 mb-5>
    <alert-error :message="error.message" v-if="error.show"/>
    <v-card v-else>
      <v-layout row wrap>
        <v-flex xs3>
          <name-filter
            @refreshRecords="buildQuery('name', $event)" :label="'Beer Name'"/>
        </v-flex>
        <v-flex xs3>
          <country-filter @refreshRecords="buildQuery('country', $event)"/>
        </v-flex>
        <v-flex xs3>
          <brewer-filter @refreshRecords="buildQuery('brewer', $event)"/>
        </v-flex>
        <v-flex xs3>
          <type-filter @refreshRecords="buildQuery('type', $event)"/>
        </v-flex>
        <v-flex xs3>
          <price-filter
            @refreshRecords="buildQuery('priceFrom', $event)"
            label="Price from"
          />
        </v-flex>
        <v-flex xs3>
          <price-filter
            @refreshRecords="buildQuery('priceTo', $event)"
            label="Price to"
            icon="keyboard_arrow_down"
          />
        </v-flex>
      </v-layout>
      <v-data-table
        :headers="headers"
        :items="beers"
        :pagination.sync="pagination"
        :total-items="totalBeers"
        :loading="loading"
        :rows-per-page-items="rowsPerPageItems"
        class="elevation-1"
      >
        <template slot="items" slot-scope="props">
          <td class="text-xs-left">
            <router-link :to="`beer/${props.item.id}`">
              {{props.item.name }}
            </router-link>
          </td>
          <td class="text-xs-left">{{ props.item.brewer.name }}</td>
          <td class="text-xs-left">{{ props.item.type.name }}</td>
          <td class="text-xs-left">{{ props.item.brewer.country.code }}</td>
          <td class="text-xs-left">{{ props.item.size }}</td>
          <td class="text-xs-left">{{ props.item.pricePerLitre }}</td>
          <td class="text-xs-left">{{ props.item.price }}</td>
          <td class="text-xs-left">{{ props.item.category.name }}</td>
          <td class="text-xs-center">
            <v-icon v-if="props.item.onSale" color="green">check_circle</v-icon>
            <v-icon v-else color="red">remove_circle</v-icon>
          </td>
        </template>
      </v-data-table>
      <div class="text-xs-right pt-2">
        <pagination-button @setPage="setPage" :page="pagination.page" :target-page="1">
          First Page
        </pagination-button>
        <pagination-button @setPage="setPage" :page="pagination.page" :target-page="lastPage">
          Last page
        </pagination-button>
      </div>
    </v-card>
  </v-flex>
</template>

<script>
  import mixin from '../mixin'
  import CountryFilter from './Filters/CountryFilter'
  import NameFilter from './Filters/NameFilter'
  import BrewerFilter from './Filters/BrewerFilter'
  import TypeFilter from './Filters/TypeFilter'
  import PriceFilter from './Filters/PriceFilter'
  import AlertError from './AlertError'
  import {mapActions, mapGetters} from 'vuex'
  import PaginationButton from './PaginationButton'

  export default {
  name: 'BeersTable',
  components: {
    PaginationButton,
    AlertError,
    NameFilter,
    CountryFilter,
    BrewerFilter,
    TypeFilter,
    PriceFilter
  },
  mixins: [mixin],
  data: () => ({
    search: {
      name: '',
      country: '',
      brewer: '',
      priceFrom: '',
      priceTo: '',
      type: ''
    },
    error: {
      message: '',
      show: false
    },
    loading: true,
    rowsPerPageItems: [5, 10, 25, 100],
    pagination: {
      totalItems: 0,
      rowsPerPage: 10,
      sortBy: 'name',
      descending: false,
      page: 1
    },
    headers: [
      { text: 'Name', value: 'name' },
      { text: 'Brewer', value: 'brewer.name' },
      { text: 'Type', value: 'type.name' },
      { text: 'Country', value: 'brewer.country.name' },
      { text: 'Size', value: 'size' },
      { text: 'Price per litre', value: 'pricePerLitre' },
      { text: 'Price', value: 'price' },
      { text: 'Category', value: 'category.name' },
      { text: 'On sale', value: 'onSale' }
    ]
  }),
  watch: {
    pagination: {
      handler () {
        this.buildQuery()
      }
    }
  },
  computed: {
    ...mapGetters('beers', {
      beers: 'getBeers',
      totalBeers: 'getTotalBeers',
      lastPage: 'getLastPage'
    })
  },
  activated () {
    if (this.$route.query.brewer) {
      this.clearSearch()
      this.search.brewer = Number(this.$route.query.brewer)
      this.buildQuery()
    }
  },
  methods: {
    ...mapActions('beers', ['loadBeers']),
    clearSearch () {
      Object.keys(this.search).forEach((key) => {
        this.search[key] = ''
      })
    },
    buildQuery (prop, value) {
      this.search[prop] = value

      let query = []
      query['itemsPerPage'] = this.pagination.rowsPerPage
      query['page'] = this.pagination.page

      let direction = this.pagination.descending ? 'desc' : 'asc'
      if (this.pagination.sortBy) query[`order[${this.pagination.sortBy}]`] = direction
      if (this.pagination.sortBy === 'beersCount') query['beersCount'] = direction
      if (this.search.name) query['name'] = this.search.name
      if (this.search.country) query['brewer.country.id'] = this.search.country
      if (this.search.priceFrom) query['price[gte]'] = this.search.priceFrom
      if (this.search.priceTo) query['price[lte]'] = this.search.priceTo
      if (this.search.type) query['type.id'] = this.search.type
      if (this.search.brewer) query['brewer'] = this.search.brewer

      this.refreshBeers(this.buildQueryString(query))
    },
    refreshBeers (urlParams) {
      this.loading = true
      this.loadBeers(urlParams).then(() => {
        this.loading = false
        this.pagination.totalItems = this.totalBrewers
      }).catch(() => {
        this.error.show = true
        this.error.message = 'Error with server'
      })
    },
    setPage (page) {
      this.pagination.page = page
      this.buildQuery()
    }
  }
}
</script>
