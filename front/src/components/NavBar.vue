<template>
  <v-toolbar dark color="primary">
    <v-toolbar-title>Beers App</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn to="/" flat>Beers</v-btn>
      <v-btn to="/brewers" flat>Brewers</v-btn>
    </v-toolbar-items>
  </v-toolbar>
</template>

<script>
export default {
  name: 'NavBar'
}
</script>

<style scoped></style>
