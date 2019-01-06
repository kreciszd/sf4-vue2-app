<template>
  <v-card-title>
    <v-text-field
      v-model="search.country"
      @input="refreshRecords"
      append-icon="search"
      label="Country name"
      hide-details
    ></v-text-field>
  </v-card-title>
</template>
<script>
  export default {
    name: 'country-filter',
    props: {
      refreshRecords: {},
      search: {}
    }
  }
</script>
