<template>
    <span v-html="formattedText"></span>
</template>

<script>
function replaceIcons(text) {
  return text.replace(/\[([\w-]+)\]/g, '<span class="icon icon-$1"></span>');
}
function replaceSpacesInCost(text) {
  return text.replace(/ /g, '<span class="cost-separator">&#9671;</span>');
}
export default {
  name: 'my-card-text',
  props: ['text'],
  computed: {
    formattedText() {
      let text = this.text;
      if (text.match(/^\[inexhaustible\] (.*)/)) {
        this.$emit('inexhaustible');
      }
      text = text.replace(/<i>(.*?)<\/i>/g, (match, p1) => replaceSpacesInCost(p1));
      return replaceIcons(text);
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
span.cost-separator { color:darkgray; margin: 0 2px; }
</style>
