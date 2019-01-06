<template>
  <v-flex
    xs12
    mb-5
  >
    <v-card>
      <v-layout row wra>
      <v-flex xs3>
        <name-filter :refresh-records="refreshBewers" :search="search"/>
      </v-flex>
      <v-flex xs3>
        <country-filter :refresh-records="refreshBewers" :search="search"/>
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
          <td class="text-xs-left"><router-link :to="`/?brewer=${props.item.id}`">{{ props.item.name }}</router-link></td>
          <td class="text-xs-left">{{ props.item.beersCount }}</td>
          <td class="text-xs-left">{{ props.item.country.name }}</td>
        </template>
      </v-data-table>
      <div class="text-xs-right pt-2">
        <v-btn color="primary" :disabled="pagination.page === 1" @click.prevent="getFirstPage">First Page</v-btn>
        <v-btn color="primary" :disabled="pagination.page === lastPage" @click.prevent="getLastPage">Last Page</v-btn>
      </div>
    </v-card>
  </v-flex>
</template>

<script>
  import mixin from '../mixin';
  import CountryFilter from "./Filters/CountryFilter";
  import NameFilter from "./Filters/NameFilter";

  export default {
    components: {CountryFilter, NameFilter},
    mixins: [mixin],
    data: () => ({
      search: {
        name: '',
        country: ''
      },
      rowsPerPageItems: [5,10,25,100],
      totalBrewers: 0,
      lastPage: 0,
      loading: true,
      pagination: {
        rowsPerPage: 10,
        sortBy: 'beersCount',
        descending: true
      },
      brewers: [],
      headers: [
        { text: 'Id', value: 'id'},
        { text: 'Name', value: 'name'},
        { text: 'Number of beers', value: 'beersCount' },
        { text: 'Country', value: 'country.name' },
      ],
    }),
    watch: {
      pagination: {
        handler () {
          this.refreshBewers()
        },
        deep: true
      }
    },
    methods: {
      refreshBewers() {
        let direction = ''
        if(this.pagination.descending === true) direction = 'desc'
        if(this.pagination.descending === false) direction = 'asc'

        let url = `api/brewers?itemsPerPage=${this.pagination.rowsPerPage}&page=${this.pagination.page}&order[${this.pagination.sortBy}]=${direction}&name=${this.search.name}&country.id=${this.search.country}`
        if(this.pagination.sortBy === 'beersCount') {
          url = `api/brewers?itemsPerPage=${this.pagination.rowsPerPage}&page=${this.pagination.page}&${this.pagination.sortBy}=${direction}&name=${this.search.name}&country.id=${this.search.country}`
        }
        this.getBrewersFromApi(url)
      },
      getBrewersFromApi(url) {
        this.loading = true
        this.$http
          .get(url)
          .then((response) => {
            this.brewers = response.data['hydra:member']
            this.totalBrewers = response.data['hydra:totalItems']
            if(response.data['hydra:view']['hydra:last'] !== undefined) {
              this.lastPage = this.getPageParameters(response.data['hydra:view']['hydra:last'])
            } else {
              this.lastPage = 1;
            }
          }).finally(()=>{
            this.loading = false
          })
      },
      getFirstPage() {
        this.pagination.page = 1
        this.refreshBewers()
      },
      getLastPage() {
        this.pagination.page = this.lastPage
        this.refreshBewers()
      },

    },
  }
</script>

