<template>
  <v-card-title>
    <v-autocomplete
      v-model="brewer"
      :items="getBrewersList"
      @change="$emit('refreshRecords', brewer)"
      :deletable-chips="true"
      label="Brewer"
      item-text="name"
      item-value="id"
      color="purple"
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
      brewer: null,
      loading: 'secondary',
      error: false,
      errorMessage: null
    }
  },
  computed: {
    ...mapGetters('filters', ['getBrewersList'])
  },
  mounted () {
    this.$store.dispatch('filters/loadBrewersList').then(() => {
      this.loading = false
      this.error = false
    }).catch(() => {
      this.error = true
      this.errorMessage = 'Server Error'
    })
  }
}
</script>
