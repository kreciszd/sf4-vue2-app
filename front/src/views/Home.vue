<template>
  <HelloWorld />
</template>

<script>
  import HelloWorld from '../components/HelloWorld'

  export default {
    components: {
      HelloWorld
    },
    data() {
      return {
        a: 1
      }
    },
    created() {

    },
    methods: {
      getText() {
        return'dsad';
      }
    },
  }
</script>
