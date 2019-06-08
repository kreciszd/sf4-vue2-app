<template>
  <v-layout row wra>
    <v-flex xs6>
      <p>{{ label }}</p>
    </v-flex>
    <v-flex xs6>
      <p><slot></slot></p>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  name: 'BeerInfo',
  props: {
    label: { type: String, default: '' }
  }
}
</script>
