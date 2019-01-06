<template>
  <v-container>
    <v-layout
      text-xs-center
      wrap
    >
      <v-flex
        xs12
        mb-5
      >
        <h2 class="headline font-weight-bold mb-3">Beers</h2>
        <v-card>
          <v-flex
            xs6
            mb-4
          >
            <v-card-title>
              Name
              <v-spacer></v-spacer>
              <v-text-field
                v-model="search.name"
                @input="refreshBeers"
                append-icon="search"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
          </v-flex>
          <v-flex
            xs6
            mb-5
          >
            <v-card-title>
              Country
              <v-spacer></v-spacer>
              <v-text-field
                v-model="search.country"
                @input="refreshBeers"
                append-icon="search"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
          </v-flex>
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
              <td class="text-xs-left">{{ props.item.name }}</td>
              <td class="text-xs-left">{{ props.item.brewer.name }}</td>
              <td class="text-xs-left">{{ props.item.type.name }}</td>
              <td class="text-xs-left">{{ props.item.brewer.country.name }}</td>
              <td class="text-xs-left">{{ props.item.size }}</td>
              <td class="text-xs-left">{{ props.item.pricePerLitre }}</td>
              <td class="text-xs-left">{{ props.item.price}}</td>
              <td class="text-xs-left">{{ props.item.category.name }}</td>
            </template>
          </v-data-table>
          <div class="text-xs-right pt-2">
            <v-btn color="primary" :disabled="pagination.page === 1" @click.prevent="getFirstPage">First Page</v-btn>
            <v-btn color="primary" :disabled="pagination.page === lastPage" @click.prevent="getLastPage">Last Page</v-btn>
          </div>
        </v-card>
      </v-flex>

    </v-layout>
  </v-container>
</template>

<script>
  export default {
    data: () => ({
      search: {
        name: '',
        country: ''
      },
      rowsPerPageItems: [5,10,25,100],
      totalBeers: 0,
      lastPage: 0,
      loading: true,
      pagination: {
        rowsPerPage: 10,
        searchName: '',
        search: {
          name: ''
        }
      },
      beers: [],
      headers: [
        { text: 'Name', value: 'name'},
        { text: 'Brewer', value: 'brewer.name' },
        { text: 'Type', value: 'type.name' },
        { text: 'Country', value: 'brewer.country.name' },
        { text: 'Size', value: 'size' },
        { text: 'Price per litre', value: 'pricePerLitre' },
        { text: 'Price', value: 'price' },
        { text: 'Category', value: 'category.name' },
      ],
    }),
    watch: {
      pagination: {
        handler () {
          console.log(1);
          this.refreshBeers()
        },
        // deep: false
      }
    },
    methods: {
      refreshBeers() {
        let a = ''
        if(this.pagination.descending === true) {
          a = 'desc'
        }
        if(this.pagination.descending === false) {
          a = 'asc'
        }
        let url = `api/beers?itemsPerPage=${this.pagination.rowsPerPage}&page=${this.pagination.page}&order[${this.pagination.sortBy}]=${a}&name=${this.search.name}&brewer.country.name=${this.search.country}`
        this.getBeersFromApi(url)
      },
      getBeersFromApi(url) {
        this.loading = true
        this.$http
          .get(url)
          .then((response) => {
            this.beers = response.data['hydra:member']
            this.totalBeers = response.data['hydra:totalItems']
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
        this.refreshBeers()
      },
      getLastPage() {
        this.pagination.page = this.lastPage
        this.refreshBeers()
      },
      getPageParameters(url) {
        let uri = url.split('?');
        let getVars = {};

        if (uri.length === 2) {
          let vars = uri[1].split('&');
          let tmp = '';
          vars.forEach(function (v) {
            tmp = v.split('=');
            if (tmp.length === 2) getVars[tmp[0]] = tmp[1];
          });
        }

        return getVars.page;
      }
    },
  }
</script>

<style>

</style>
