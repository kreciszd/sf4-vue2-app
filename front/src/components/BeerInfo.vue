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
  export default {
    name: 'beer-info',
    props: {
      information: {
        default: ''
      },
      label: {
        type: String,
        default: ''
      }
    }
  }
</script>
