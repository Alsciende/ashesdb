// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import MyDatastore from './services/MyDatastore'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './font.css'

Vue.use(BootstrapVue)
Vue.config.productionTip = false

import MyCardText from './components/MyCardText'

/* eslint-disable no-new */
new Vue({
  el: '#app',
  components: {
    MyCardText
  }
})
