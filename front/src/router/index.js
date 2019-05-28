import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'beers',
      component: () => import(/* webpackChunkName: "beers" */'../views/Beers')
    },
    {
      path: '/brewers',
      name: 'brewers',
      component: () => import(/* webpackChunkName: "brewers" */ '../views/Brewers')
    },
    {
      path: '/beer/:id',
      name: 'beer',
      component: () => import(/* webpackChunkName: "beer" */ '../views/Beer')
    }
  ]
})
