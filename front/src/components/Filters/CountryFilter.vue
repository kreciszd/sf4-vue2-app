<template>
  <v-card-title>
    <v-autocomplete
      v-model="model"
      :items="getCountriesList"
      @change="$emit('refreshRecords', model)"
      :deletable-chips="true"
      label="Country Code"
      item-text="code"
      color="purple"
      item-value="id"
      persistent-hint
      :loading="loading"
      :error="error"
      :disabled="error"
      :error-messages="errorMessage"
      prepend-icon="mdi-city"
      :light="true"
      :clearable="true">
      <v-slide-x-reverse-transition slot="append-outer" mode="out-in">
      </v-slide-x-reverse-transition>
    </v-autocomplete>
  </v-card-title>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'BrewerFilter',
  data () {
    return {
      model: null,
      loading: 'secondary',
      error: false,
      errorMessage: null
    }
  },
  computed: {
    ...mapGetters('filters', ['getCountriesList'])
  },
  mounted () {
    this.$store.dispatch('filters/loadCountriesList').then(() => {
      this.loading = false
      this.error = false
    }).catch(() => {
      this.error = true
      this.errorMessage = 'Server Error'
    })
  }
}
</script>
