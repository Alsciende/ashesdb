<template>
    <span v-html="formattedText" class="my-card-text"></span>
</template>

<script>
export default {
  name: 'my-card-text',
  props: ['text'],
  computed: {
    formattedText: function () {
      let parts = this.text.match(/(<b>(.*)<\/b>: )?(<i>(.*)<\/i>: )?(.*)/)
      if (parts) {
        let name = parts[1]
        let cost = parts[4]
        let effect = parts[5]
        if (!name) {
          name = ''
        }
        if (!cost) {
          cost = ''
        } else {
          cost = cost.replace(/ /g, '<span class="text-muted">&#9671;</span>')
          cost = cost.replace(/\[([\w-]+)\]/g, '<span class="icon icon-$1"></span>')
          cost = cost + ': '
        }
        if (!effect) {
          effect = ''
        } else {
          effect = effect.replace(/\[([\w-]+)\]/g, '<span class="icon icon-$1"></span>')
        }
        return name + cost + effect
      } else {
        console.log('Cannot parse card text: ' + this.text)
      }
    }
  }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
span.my-card-text { }
</style>
