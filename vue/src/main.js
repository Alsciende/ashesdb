import Vue from 'vue'
Vue.config.productionTip = false

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import 'bootstrap-vue/dist/bootstrap-vue.css'
import './font.css'

import storeService from './services/storeService'

import MyCardText from './components/MyCardText'
import MyCardTextBlock from './components/MyCardTextBlock'
import MyCardList from './components/MyCardList'

const routes = [
  {
    path: '/',
    name: 'cards-by-default',
    component: MyCardList
  },
  {
    path: '/cards/search',
    name: 'cards-by-search-query',
    component: MyCardList
  },
  {
    path: '/card/:code',
    name: 'cards-by-card-code',
    component: MyCardList,
    props: true
  },
  {
    path: '/prebuilt/:code',
    name: 'cards-by-prebuilt-code',
    component: MyCardList,
    props: true
  }
]

const router = new VueRouter({
  routes // short for routes: routes
})

storeService.load().then(() => {
  /* eslint-disable no-new */
  new Vue({
    router: router,
    el: '#app',
    components: {
      MyCardList,
      MyCardTextBlock,
      MyCardText
    }
  })
})
