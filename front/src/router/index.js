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
      component: () => import(/* webpackChunkName: "PageBeers" */'../views/PageBeers')
    },
    {
      path: '/brewers',
      name: 'brewers',
      component: () => import(/* webpackChunkName: "pageBrewers" */ '../views/PageBrewers')
    },
    {
      path: '/beer/:id',
      name: 'beer',
      component: () => import(/* webpackChunkName: "pageBeer" */ '../views/PageBeer')
    }
  ]
})
