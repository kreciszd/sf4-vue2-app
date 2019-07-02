<template>
  <v-container>
    <v-flex xs12 sm8 offset-sm2 v-if="loaded">
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
              <beer-info :label="info.label" :key="i">{{ getInformation(info.data) }}</beer-info>
            </template>
            <v-divider class="margin-divider"></v-divider>
            <beer-info label="Brewer">{{ beer.brewer.name }}</beer-info>
            <beer-info label="Country">{{ beer.brewer.country.name }}</beer-info>
            <beer-info label="Country Code">{{ beer.brewer.country.code }}</beer-info>
            <v-divider class="margin-divider"></v-divider>
            <beer-info label="Category">{{ beer.category.name }}</beer-info>
            <beer-info label="Type">{{ beer.type.name }}</beer-info>
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
import { mapActions, mapGetters } from 'vuex'

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
    ],
    loaded: false
  }),
  computed: {
    ...mapGetters('beer', { beer: 'getBeer' })
  },
  activated () {
    this.loaded = false
    this.loadBeer(this.$route.params.id).then(() => {
      this.loaded = true
    }).catch(() => {
      this.loaded = false
    })
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
