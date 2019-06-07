<template>
  <v-container>
    <v-flex xs12 sm8 offset-sm2>
      <v-card>
        <v-img :src="beer.imageUrl" alt="" class="beer-image" contain></v-img>
        <v-card-title primary-title>
          <v-flex xs12>
            <v-layout row wra>
              <v-flex xs12>
                <h1 class="headline mb-0 text-sm-center">{{ beer.name }}</h1>
              </v-flex>
            </v-layout>
            <v-divider class="margin-divider"></v-divider>
            <v-layout row wra>
              <v-flex xs6>
                <p>Available</p>
              </v-flex>
              <v-flex xs6>
                <v-icon v-if="beer.onSale" color="green">check_circle</v-icon>
                <v-icon v-else color="red">remove_circle</v-icon>
              </v-flex>
            </v-layout>
            <template v-for="(info, i) in infos">
              <beer-info :information="getInformation(info.data)" :label="info.label" :key="i"/>
            </template>
            <v-divider class="margin-divider"></v-divider>
            <beer-info :information="beer.brewer.name" label="Brewer"/>
            <beer-info :information="beer.brewer.country.name" label="Country"/>
            <beer-info :information="beer.brewer.country.code" label="Country Code"/>
            <v-divider class="margin-divider"></v-divider>
            <beer-info :information="beer.category.name" label="Category" />
            <beer-info :information="beer.type.name" label="Type" />
          </v-flex>
        </v-card-title>
        <v-card-actions class="text-lg-right">
          <v-btn class="text-sm-right" color="warning" to="/">Go Back</v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
  </v-container>
</template>

<script>
  import BeerInfo from '../components/BeerInfo'
  import {mapActions, mapGetters} from 'vuex'

  export default {
  name: 'PageBeer',
  components: { BeerInfo },
  data: () => ({
    infos: [
      { label: 'Id', data: 'id' },
      { label: 'Abv', data: 'abv' },
      { label: 'Price', data: 'price' },
      { label: 'Price per Litre', data: 'pricePerLitre' },
      { label: 'Size', data: 'size' }
    ]
  }),
  computed: {
    ...mapGetters('beer', { beer: 'getBeer' })
  },
  activated () {
    this.loadBeer(this.$route.params.id)
  },
  methods: {
    ...mapActions('beer', ['loadBeer']),
    getInformation (fieldName) {
      if (this.beer.hasOwnProperty(fieldName)) {
        return this.beer[fieldName]
      }
      return ''
    }
  }
}
</script>

<style scoped>
  .beer-image {
    max-height: 400px;
  }

  .margin-divider {
    margin-bottom: 20px;
  }
</style>
