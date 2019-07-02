<template>
  <v-card-title>
    <v-autocomplete
      v-model="type"
      :items="getTypesList"
      @change="$emit('refreshRecords', type)"
      :deletable-chips="true"
      label="Type"
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
  name: 'TypeFilter',
  data () {
    return {
      type: null,
      loading: 'secondary',
      error: false,
      errorMessage: null
    }
  },
  computed: {
    ...mapGetters('filters', ['getTypesList'])
  },
  mounted () {
    this.$store.dispatch('filters/loadTypesList').then(() => {
      this.loading = false
      this.error = false
    }).catch(() => {
      this.error = true
      this.errorMessage = 'Server Error'
    })
  }
}
</script>
