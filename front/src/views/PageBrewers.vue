<template>
  <v-container>
    <v-layout text-xs-center wrap>
      <brewers-table/>
    </v-layout>
  </v-container>
</template>

<script>
import BrewersTable from '../components/BrewersTable'

export default {
  name: 'PageBrewers',
  components: {
    BrewersTable
  }
}
</script>
