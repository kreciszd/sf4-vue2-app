<template>
  <v-card-title>
    <v-autocomplete
      v-model="search.brewer"
      :items="getBrewersList"
      :readonly="!isEditing"
      @change="refreshRecords"
      :deletable-chips="true"
      label="Brewer"
      item-text="name"
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
      isEditing: { type: Boolean, default: false },
      model: null
    }
  },
  computed: {
    ...mapGetters('filters', ['getBrewersList'])
  },
  mounted () {
    this.loadBrewersList()
  },
  methods: {
    ...mapActions('filters', ['loadBrewersList'])
  }
}
</script>
