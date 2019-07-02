<template>
  <v-alert :value="true" type="error">
    {{ message }}
  </v-alert>
</template>

<script>
export default {
  name: 'AlertError',
  props: {
    message: { type: String, default: null }
  }
}
</script>
