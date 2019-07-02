<template>
  <v-btn
    color="primary"
    :disabled="page === targetPage"
    @click.prevent="$emit('setPage', targetPage)"
  >
    <slot></slot>
  </v-btn>
</template>

<script>
export default {
  name: 'pagination-button',
  props: {
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
