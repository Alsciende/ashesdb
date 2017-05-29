<template>
    <my-card-list v-bind:query="query"></my-card-list>
</template>

<script>
  import MyCardList from './MyCardList'
  export default {
    name: 'my-card-zoom',
    props: ['code'],
    data: function () {
      return {
        currentCode: this.code
      }
    },
    computed: {
      query: function () {
        return "id:" + this.currentCode
      }
    },
    watch: {
      '$route' (to, from) {
        this.currentCode = to.params.code
        console.log(this.currentCode)
      }
    },
    components: {
      MyCardList
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
</style>
