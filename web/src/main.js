// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import MyDatastore from './services/MyDatastore'

import 'bootstrap-vue/dist/bootstrap-vue.css'
import './font.css'

Vue.use(BootstrapVue)
Vue.config.productionTip = false

import MyCardText from './components/MyCardText'
import MyCardTextBlock from './components/MyCardTextBlock'

/* eslint-disable no-new */
new Vue({
  el: '#app',
  components: {
    MyCardTextBlock,
    MyCardText
  },
  methods: {
    pageChanged: function (page) {
      console.log("new page", page)
    }
  }
})
