import Vue from 'vue'
import VueResource from 'vue-resource'
import { taffy } from 'taffydb'

Vue.use(VueResource)

var MyDatastore = {}

var resources = ['cards', 'conjurations', 'cycles', 'exclusives', 'pack_cards', 'packs']

resources.forEach(function (resource) {
  Vue.http.get('/app_dev.php/api/v1/' + resource).then(response => {
    MyDatastore[resource] = taffy(response.body.records)
    console.log(resource, MyDatastore[resource]().get())
  })
})

export default MyDatastore
