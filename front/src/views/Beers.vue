<template>
  <v-container>
    <v-layout text-xs-center wrap>
      <ul>
        <li
          v-for="product in products"
          :key="product.id">
          {{ product.title }} - {{ product.price }}
          <br>
          <button
            :disabled="!product.inventory"
            @click="addProductToCart(product)">
            Add to cart
          </button>
        </li>
      </ul>
      <beers-table />
    </v-layout>
  </v-container>
</template>

<script>
  import BeersTable from '../components/BeersTable'
  import {mapActions, mapState} from 'vuex'

  export default {
  components: {
    BeersTable
  },
  computed: mapState({
    products: state => state.brewers.all
  }),
  methods: mapActions('cart', [
    'addProductToCart'
  ]),
  created () {
    // this.$store.dispatch('brewers/getAllProducts')
  }
}
</script>
