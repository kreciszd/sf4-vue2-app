<template>
  <v-flex xs12 mb-5>
    <alert-error :message="error.message" v-if="error.show"/>
    <v-card v-else>
      <v-layout row wrap>
        <v-flex xs3>
          <name-filter :refresh-records="buildQuery" :search="search"/>
        </v-flex>
        <v-flex xs3>
          <country-filter :refresh-records="buildQuery" :search="search"/>
        </v-flex>
        <v-flex xs3>
          <brewer-filter :refresh-records="buildQuery" :search="search"/>
        </v-flex>
        <v-flex xs3>
          <type-filter :refresh-records="buildQuery" :search="search"/>
        </v-flex>
      </v-layout>
      <price-filter :refresh-records="buildQuery" :search="search"/>
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
        <pagination-button
          @setPage="pagination.page = $event"
          :page="pagination.page"
          :target-page="1"
          :text="'First Page'"
        />
        <pagination-button
          @setPage="pagination.page = $event"
          :page="pagination.page"
          :target-page="lastPage"
          :text="'Last Page'"
        />
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
  import {mapActions, mapGetters, mapState} from 'vuex'
  import PaginationButton from './PaginationButton'

  export default {
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
      },
      deep: true
    },
  },
  computed: {
    ...mapGetters('beers', []),
    ...mapState('beers', ['beers', 'totalBeers', 'lastPage'])
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
      this.search.name = ''
      this.search.country = ''
      this.search.brewer = ''
      this.search.priceFrom = ''
      this.search.priceTo = ''
      this.search.type = ''
    },
    buildQuery () {
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
    }
  }
}
</script>
