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
    <slot>
      No cards to display.
    </slot>
  </div>
</template>

<script>
export default {
  name: 'my-paginated-list',
  props: ['page', 'perPage', 'totalRows', 'query', 'view', 'sort'],
  data: function () {
    return {
      currentPage: this.page
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
      location.href = Routing.generate('app_web_cardlist_search', params)
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
</style>
