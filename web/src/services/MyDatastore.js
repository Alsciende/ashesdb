import Vue from 'vue'
import VueResource from 'vue-resource'
import { taffy } from 'taffydb'

Vue.use(VueResource)

var MyDatastore = {}

var resources = ['card', 'conjuration', 'cycle', 'exclusive', 'packcard', 'pack']

resources.forEach(function (resource) {
  Vue.http.get(Routing.generate('app_api_v1_'+resource+'_list')).then(response => {
    MyDatastore[resource] = taffy(response.body.records)
  })
})

export default MyDatastore
