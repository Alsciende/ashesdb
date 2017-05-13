<template>
  <p class="card-text" v-bind:class="{ inexhaustible: isInexhaustible }">
    <my-card-text v-bind:text="text" v-on:inexhaustible="setIsInexhaustible"></my-card-text>
  </p>
</template>

<script>
import MyCardText from './MyCardText'

export default {
  name: 'my-card-text-block',
  data: function () {
    return {
      isInexhaustible: false
    }
  },
  methods: {
    setIsInexhaustible: function () {
      this.isInexhaustible = true
    }
  },
  props: ['text'],
  components: {
    MyCardText
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
p.card-text.inexhaustible { background: LightYellow; }
</style>
