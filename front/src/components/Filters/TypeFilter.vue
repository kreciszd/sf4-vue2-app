<template>
  <v-card-title>
    <v-autocomplete
      v-model="search.type"
      :items="getTypesList"
      :readonly="!isEditing"
      @change="$emit('refreshRecords')"
      :deletable-chips="true"
      label="Type"
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
  name: 'type-filter',
  props: {
    search: Object
  },
  data () {
    return {
      isEditing: true
    }
  },
  computed: {
    ...mapGetters('filters', ['getTypesList'])
  },
  mounted () {
    this.loadTypesList()
  },
  methods: {
    ...mapActions('filters', ['loadTypesList'])
  }
}
</script>
