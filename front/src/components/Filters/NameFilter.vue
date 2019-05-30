<template>
  <v-card-title>
    <v-text-field
      v-model="search.name"
      @input="$emit('refreshRecords')"
      append-icon="search"
      :label="label"
      hide-details
      :clearable="true"
    ></v-text-field>
  </v-card-title>
</template>
<script>
export default {
  name: 'name-filter',
  props: {
    search: Object,
    label: {
      type: String,
      default: ''
    }
  }
}
</script>
