import {createLocalVue, mount} from '@vue/test-utils'
import VueRouter from 'vue-router'
import PageBeers from '../../src/views/PageBeers'
import Vuetify from 'vuetify'

describe('PageBeers', () => {
  beforeEach(() => {
    const localVue = createLocalVue()
    localVue.use(VueRouter)
    localVue.use(Vuetify)

    const routes = [{ path: '/', component: PageBeers }]
    const router = new VueRouter({
      routes
    })

    const wrapper = mount(PageBeers, {
      localVue,
      router
    })
  })

  it('renders props.msg when passed', () => {

  })
})
