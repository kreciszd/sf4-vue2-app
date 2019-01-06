<template>
  <v-card-title>
    <v-autocomplete
      v-model="search.type"
      :items="types"
      :readonly="!isEditing"
      @change="refreshRecords"
      :deletable-chips="true"
      label="Type"
      item-text="name"
      item-value="id"
      persistent-hint
      prepend-icon="mdi-city"
      type="number"
    >
      <v-slide-x-reverse-transition
        slot="append-outer"
        mode="out-in"
      >
      </v-slide-x-reverse-transition>
    </v-autocomplete>
  </v-card-title>
</template>
<script>
  export default {
    name: 'type-filter',
    props: {
      refreshRecords: {},
      search: {}
    },
    data () {
      return {
        isEditing: true,
        model: null,
        types: []
      }
    },
    mounted() {
      this.getTypesList();
    },
    methods: {
      getTypesList() {
        this.$http
          .get('api/types')
          .then((response) => {
            this.types = response.data['hydra:member']
          }).finally(()=>{
        })
      }
    },
  }
</script>
