<template>
  <v-card-title>
    <v-text-field
      v-model="search.name"
      @input="refreshRecords"
      append-icon="search"
      label="Beer name"
      hide-details
    ></v-text-field>
  </v-card-title>
</template>
<script>
  export default {
    name: 'name-filter',
    props: {
      refreshRecords: {},
      search: {}
    }
  }
</script>
