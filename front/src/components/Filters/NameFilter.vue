<template>
  <v-card-title>
    <v-text-field
      v-model="name"
      @input="$emit('refreshRecords', name)"
      append-icon="search"
      :label="label"
      hide-details
      :clearable="true"
    ></v-text-field>
  </v-card-title>
</template>

<script>
export default {
  name: 'NameFilter',
  props: {
    label: { type: String, default: '' }
  },
  data: () => ({
    name: null
  })
}
</script>
