<template>
  <div>
  <b-pagination
    v-bind:total-rows="totalRows"
    v-bind:per-page="perPage"
    v-model="currentPage"
    v-on:input="change"
    size="md"
    class="my-3 justify-content-center"
  >
  </b-pagination>
    <div class="row" v-for="card in cards">
      <div class="col-7">
        <my-card-card v-bind:card="card">
        </my-card-card>
      </div>
      <div class="col-5">
          <img v-bind:src="getCardImageURL(card)">
      </div>
    </div>
  </div>
</template>

<script>
import storeService from '../services/storeService'
import configService from '../services/configService'
import MyCardCard from './MyCardCard'
export default {
  name: 'my-card-list',
  props: ['query', 'page', 'view', 'sort'],
  data: function () {
    return {
      'cards': [],
      'perPage': 20,
      'totalRows': 0,
      'currentPage': 1
    }
  },
  watch: {
    query: {
      handler: function (newQuery) {
        this.cards = storeService.stores.cards().get()
        this.perPage = 20
        this.totalRows = this.cards.length;
        this.currentPage = 1;
      },
      immediate: true
    }
  },
  methods: {
    change: function () {
      let params = {
        'q': this.query,
        'view': this.view,
        'sort': this.sort,
        'page': this.currentPage
      }
      console.log("reroute", params)
    },
    getCardImageURL: configService.getCardImageURL
  },
  components: {
    MyCardCard
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
</style>
