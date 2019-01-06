import Vue from 'vue'
import Router from 'vue-router'
import Beer from "./views/Beer";
import Beers from "./views/Beers";
import Brewers from "./views/Brewers";

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'beers',
      component: Beers
    },
    {
      path: '/brewers',
      name: 'brewers',
      component: Brewers,
    },
    {
      path: '/beer/:id',
      name: 'beer',
      component: Beer,
    }
  ]
})
