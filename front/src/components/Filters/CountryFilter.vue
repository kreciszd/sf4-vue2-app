<template>
  <v-card-title>
    <v-autocomplete
      v-model="search.country"
      :items="countries"
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
  export default {
    name: 'brewer-filter',
    props: {
      refreshRecords: {},
      search: {}
    },
    data() {
      return {
        isEditing: true,
        model: null,
        countries: []
      }
    },
    mounted() {
      this.getCountriesList()
    },
    methods: {
      getCountriesList() {
        this.$http
          .get('api/countries')
          .then((response) => {
            this.countries = response.data['hydra:member']
        })
          .finally(() => {
          })
      }
    }
  }
</script>
