<template>
  <v-app>
    <nav-bar></nav-bar>
    <v-content>
      <keep-alive>
        <router-view></router-view>
      </keep-alive>
    </v-content>
  </v-app>
</template>

<script>
  import NavBar from './components/NavBar'

  export default {
  name: 'App',
  components: { NavBar},
  data () {
    return {
      //
    }
  }
}
</script>
