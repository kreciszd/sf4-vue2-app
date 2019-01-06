<template>
  <v-flex
    xs12
    mb-5
  >
    <alert-error :message="error.message" v-if="error.show"/>
    <v-card v-else>
      <v-layout row wrap >
        <v-flex xs3>
          <name-filter :refresh-records="refreshBeers" :search="search"/>
        </v-flex>
        <v-flex xs3>
          <country-filter :refresh-records="refreshBeers" :search="search"/>
        </v-flex>
        <v-flex xs3>
          <brewer-filter :refresh-records="refreshBeers" :search="search"/>
        </v-flex>
        <v-flex xs3>
          <type-filter :refresh-records="refreshBeers" :search="search"/>
        </v-flex>
      </v-layout>
      <price-filter :refresh-records="refreshBeers" :search="search"/>
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
            <router-link :to="`beer/${props.item.id}`">{{ props.item.name }}</router-link>
          </td>
          <td class="text-xs-left">{{ props.item.brewer.name }}</td>
          <td class="text-xs-left">{{ props.item.type.name }}</td>
          <td class="text-xs-left">{{ props.item.brewer.country.name }}</td>
          <td class="text-xs-left">{{ props.item.size }}</td>
          <td class="text-xs-left">{{ props.item.pricePerLitre }}</td>
          <td class="text-xs-left">{{ props.item.price}}</td>
          <td class="text-xs-left">{{ props.item.category.name }}</td>
          <td class="text-xs-center">
            <v-icon v-if="props.item.onSale" color="green">check_circle</v-icon>
            <v-icon v-else color="red">remove_circle</v-icon>
          </td>
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
  import BrewerFilter from "./Filters/BrewerFilter";
  import TypeFilter from "./Filters/TypeFilter";
  import PriceFilter from "./Filters/PriceFilter";
  import AlertError from "./AlertError";

  export default {
    components: {AlertError, NameFilter, CountryFilter, BrewerFilter, TypeFilter, PriceFilter},
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
      rowsPerPageItems: [5, 10, 25, 100],
      totalBeers: 0,
      lastPage: 0,
      loading: true,
      pagination: {
        rowsPerPage: 10,
        descending: false,
        page: 1,
        sortBy: 'name',
        totalItems: 0,
      },
      beers: [],
      headers: [
        {text: 'Name', value: 'name'},
        {text: 'Brewer', value: 'brewer.name'},
        {text: 'Type', value: 'type.name'},
        {text: 'Country', value: 'brewer.country.name'},
        {text: 'Size', value: 'size'},
        {text: 'Price per litre', value: 'pricePerLitre'},
        {text: 'Price', value: 'price'},
        {text: 'Category', value: 'category.name'},
        {text: 'On sale', value: 'onSale'},
      ],
    }),
    watch: {
      pagination: {
        handler() {
          this.refreshBeers()
        },
        deep: true
      },
      search: {
        handler() {
          this.refreshBeers()
        },
        deep: true
      }
    },
    activated() {
      if (this.$route.query.brewer) {
        this.clearSearch()
        this.search.brewer = Number(this.$route.query.brewer);
        this.refreshBeers()
      }
    },
    methods: {
      clearSearch() {
        this.search.name = ''
        this.search.country = ''
        this.search.brewer = ''
        this.search.priceFrom = ''
        this.search.priceTo = ''
        this.search.type = ''
      },
      refreshBeers() {
        let direction = ''
        if (this.pagination.descending === true) direction = 'desc'
        if (this.pagination.descending === false) direction = 'asc'

        let url =
          `api/beers?itemsPerPage=${this.pagination.rowsPerPage}&page=${this.pagination.page}&order[${this.pagination.sortBy}]=${direction}&name=${this.search.name}&brewer.country.id=${this.search.country}&price[gte]=${this.search.priceFrom}&price[lte]=${this.search.priceTo}&type.id=${this.search.type}`
        if (this.search.brewer) {
          url = `${url}&brewer=${this.search.brewer}`
        }
        this.getBeersFromApi(url)
      },
      getBeersFromApi(url) {
        this.loading = true
        this.$http
          .get(url)
          .then((response) => {
            this.beers = response.data['hydra:member']
            this.totalBeers = response.data['hydra:totalItems']
            if (response.data['hydra:view']['hydra:last'] !== undefined) {
              this.lastPage = this.getPageParameters(response.data['hydra:view']['hydra:last'])
            } else {
              this.lastPage = 1
            }
          })
          .catch(error => {
            this.error.show = true
            this.error.message = 'Error with server'
          })
          .finally(() => {
          this.loading = false
        })
      },
      getFirstPage() {
        this.pagination.page = 1
        this.refreshBeers()
      },
      getLastPage() {
        this.pagination.page = this.lastPage
        this.refreshBeers()
      },
    },
  }
</script>

