<template>
  <v-card-title>
    <v-text-field
      type="number"
      v-model="price"
      @input="$emit('refreshRecords', price)"
      :append-icon="icon"
      :label="label"
      hide-details
      :clearable="true"
    ></v-text-field>
  </v-card-title>
</template>

<script>
export default {
  name: 'PriceFilter',
  props: {
    icon: {
      type: String,
      default: 'keyboard_arrow_up'
    },
    label: {
      type: String,
      default: 'Price'
    }
  },
  data: () => ({
    price: null
  })
}
</script>
