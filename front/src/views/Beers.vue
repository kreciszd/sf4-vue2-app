<template>
  <v-container>
    <v-layout
      text-xs-center
      wrap
    >
      <beers-table />
    </v-layout>
  </v-container>
</template>

<script>
  import BeersTable from '../components/BeersTable'

  export default {
    components: {
      BeersTable
    },
  }
</script>
