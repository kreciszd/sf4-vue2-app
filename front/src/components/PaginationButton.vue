<template>
  <v-btn
    color="primary"
    :disabled="page === targetPage"
    @click.prevent="$emit('setPage', targetPage)"
  >
    {{ text }}
  </v-btn>
</template>

<script>
// TODO Make this by slots
export default {
  name: 'pagination-button',
  props: {
    text: {
      type: String,
      default: ''
    },
    page: {
      type: Number,
      default: 1
    },
    targetPage: {
      type: Number,
      default: 1
    }
  }
}
</script>
