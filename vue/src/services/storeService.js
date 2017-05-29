import Vue from 'vue'
import VueResource from 'vue-resource'
Vue.use(VueResource)

import { taffy } from 'taffydb'
import configService from './configService'

var stores = {}
var resources = ['cards', 'conjurations', 'cycles', 'exclusives', 'packs']

let load = () => {
  return Promise.all(resources.map(function (resource) {
    return Vue.http.get(configService.api_base_url + '/api/v1/' + resource).then(response => {
      stores[resource] = taffy(response.body.records)
//      console.log(resource, stores[resource]().get())
    })
  }))
};

export default {
  load,
  stores
}
