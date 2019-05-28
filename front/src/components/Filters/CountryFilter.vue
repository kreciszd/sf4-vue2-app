<template>
  <v-card-title>
    <v-autocomplete
      v-model="search.country"
      :items="getCountriesList"
      :readonly="!isEditing"
      @change="refreshRecords"
      :deletable-chips="true"
      label="Country Code"
      item-text="code"
      item-value="id"
      persistent-hint
      prepend-icon="mdi-city"
      :clearable="true"
    >
      <v-slide-x-reverse-transition slot="append-outer" mode="out-in">
      </v-slide-x-reverse-transition>
    </v-autocomplete>
  </v-card-title>
</template>
<script>
  import {mapActions, mapGetters} from 'vuex'

  export default {
  name: 'brewer-filter',
  props: {
    refreshRecords: {},
    search: {}
  },
  data () {
    return {
      isEditing: true,
      model: null
    }
  },
  computed: {
    ...mapGetters('filters', ['getCountriesList'])
  },
  mounted () {
    this.loadCountriesList()
  },
  methods: {
    ...mapActions('filters', ['loadCountriesList'])
  }
}
</script>
