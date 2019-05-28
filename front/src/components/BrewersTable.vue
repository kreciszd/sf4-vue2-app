<template>
  <v-flex xs12 mb-5>
    <alert-error :message="error.message" v-if="error.show"/>
    <v-card v-else>
      <v-layout row wra>
        <v-flex xs3>
          <name-filter :refresh-records="buildQuery" :search="search"/>
        </v-flex>
        <v-flex xs3>
          <country-filter :refresh-records="buildQuery" :search="search"/>
        </v-flex>
      </v-layout>
      <v-data-table
        :headers="headers"
        :items="brewers"
        :pagination.sync="pagination"
        :total-items="totalBrewers"
        :loading="loading"
        :rows-per-page-items="rowsPerPageItems"
        class="elevation-1"
      >
        <template slot="items" slot-scope="props">
          <td class="text-xs-left">{{ props.item.id }}</td>
          <td class="text-xs-left">
            <router-link :to="`/?brewer=${props.item.id}`">{{ props.item.name }}</router-link>
          </td>
          <td class="text-xs-left">{{ props.item.beersCount }}</td>
          <td class="text-xs-left">{{ props.item.country.name }}</td>
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
  import AlertError from './AlertError'
  import {mapActions, mapGetters, mapState} from 'vuex'
  import PaginationButton from './PaginationButton'

  export default {
  components: { CountryFilter, NameFilter, AlertError, PaginationButton },
  mixins: [mixin],
  data: () => ({
    search: {
      name: '',
      country: ''
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
      sortBy: 'beersCount',
      descending: true,
      page: 1
    },
    headers: [
      { text: 'Id', value: 'id' },
      { text: 'Name', value: 'name' },
      { text: 'Number of beers', value: 'beersCount' },
      { text: 'Country', value: 'country.name' }
    ]
  }),
  watch: {
    pagination: {
      handler () {
        this.buildQuery()
      },
      deep: true
    }
  },
  computed: {
    ...mapGetters('brewers', []),
    ...mapState('brewers', ['brewers', 'totalBrewers', 'lastPage'])
  },
  methods: {
    ...mapActions('brewers', ['loadBrewers']),
    buildQuery () {
      let query = []
      query['itemsPerPage'] = this.pagination.rowsPerPage
      query['page'] = this.pagination.page

      let direction = this.pagination.descending ? 'desc' : 'asc'
      if (this.pagination.sortBy) query[`order[${this.pagination.sortBy}]`] = direction
      if (this.pagination.sortBy === 'beersCount') query['beersCount'] = direction
      if (this.search.name) query['name'] = this.search.name
      if (this.search.country) query['country.id'] = this.search.country

      this.refreshBrewers(this.buildQueryString(query))
    },
    refreshBrewers (urlParams) {
      this.loading = true
      this.loadBrewers(urlParams).then(() => {
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
