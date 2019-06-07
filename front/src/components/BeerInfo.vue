<template>
  <v-layout row wra>
    <v-flex xs6>
      <p>{{ label }}</p>
    </v-flex>
    <v-flex xs6>
      <p>{{ information }}</p>
    </v-flex>
  </v-layout>
</template>

<script>
// TODO make this with slots
export default {
  name: 'BeerInfo',
  props: {
    information: { type: String, default: '' },
    label: { type: String, default: '' }
  }
}
</script>
