<template>
  <div>
    <form>
      <div class="form-group">
        <form v-on:submit.prevent="filter">
          <input type="text" class="form-control" v-model="currentQuery" placeholder="Enter query">
          <small class="form-text text-muted">Search by name. Prefix with 'x:' to search by text, 'p:' by pack, 'c:' by cycle, 'd:' by dice, 'a:' by attack, 'l:' by life, 'r:' by recover, 'u:1' for units, 's:1' for spells, 'pb:1' for Phoenixborns.</small>
        </form>
      </div>
    </form>
    <b-pagination
    v-bind:total-rows="totalRows"
    v-bind:per-page="perPage"
    v-model="currentPage"
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
import queryParser from '../services/queryParser'
import QueryInput from '../classes/QueryInput'
import queryBuilder from '../services/queryBuilder'
import MyCardCard from './MyCardCard'
export default {
  name: 'my-card-list',
  props: ['query'],
  data: function () {
    return {
      'cards': [],
      'currentQuery': this.query,
      'perPage': 20,
      'totalRows': 0,
      'currentPage': 1,
      'result': []
    }
  },
  watch: {
    currentPage: {
      handler: function (newPage) {
        this.cards = this.result.slice((newPage - 1) * this.perPage, newPage * this.perPage)
      }
    }
  },
  methods: {
    getCardImageURL: configService.getCardImageURL,
    filter: function() {
      var clauses = queryParser.parse(this.currentQuery)
      var queryInput = new QueryInput(clauses)
      var filter = queryBuilder.build(queryInput)
      this.result = storeService.stores.cards(filter).get()
      this.perPage = 20
      this.totalRows = this.result.length;
      this.currentPage = 1;
      this.cards = this.result.slice((this.currentPage - 1) * this.perPage, this.currentPage * this.perPage)
    }
  },
  created: function () {
    this.filter()
  },
  components: {
    MyCardCard
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
</style>
