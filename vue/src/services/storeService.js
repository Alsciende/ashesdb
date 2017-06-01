import Vue from 'vue';
import VueResource from 'vue-resource';
import { taffy } from 'taffydb';
import configService from './configService';

Vue.use(VueResource);

const stores = {};
const resources = ['cards', 'conjurations', 'cycles', 'exclusives', 'packs'];

const load = () => Promise.all(resources.map(resource => Vue.http.get(`${configService.apiBaseUrl}/api/v1/${resource}`).then((response) => {
  stores[resource] = taffy(response.body.records);
//      console.log(resource, stores[resource]().get())
})));

export default {
  load,
  stores,
};
