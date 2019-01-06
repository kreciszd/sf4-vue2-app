<template>
  <v-layout row wrap>
    <v-flex xs3>
      <v-card-title>
        <v-text-field
          type="number"
          v-model="search.priceFrom"
          @input="refreshRecords"
          append-icon="keyboard_arrow_up"
          label="Price from"
          hide-details
          clearable="true"
        ></v-text-field>
      </v-card-title>
    </v-flex>
    <v-flex xs3>
      <v-card-title>
        <v-text-field
          v-model="search.priceTo"
          @input="refreshRecords"
          append-icon="keyboard_arrow_down"
          label="Price to"
          hide-details
          clearable="true"
          type="number"
        ></v-text-field>
      </v-card-title>
    </v-flex>
  </v-layout>
</template>
<script>
  export default {
    name: 'price-filter',
    props: {
      refreshRecords: {},
      search: {}
    }
  }
</script>
