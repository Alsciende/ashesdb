<template>
  <div class="card">
    <div class="card-block">
      <h4 class="card-title">{{ card.name }}</h4>
      <h6 class="card-subtitle mb-2 text-muted">
        {{ card.type }}
        <span v-if="card.placement">
          &#9671; {{ card.placement }}
        </span>
      </h6>
      <p class="card-text" v-if="card.cost !== undefined">Cost: <my-card-text v-bind:text="'<i>'+card.cost+'</i>'"></my-card-text></p>
      <my-card-text-block v-bind:text="line" v-for="(line, index) in textLines" :key="index"></my-card-text-block>
      <p class="card-text" v-if="card.is_unit">Attack {{ card.attack }} &#9671; Life {{ card.life }} &#9671; Recover {{ card.recover }}</p>
      <p class="card-text" v-if="card.is_phoenixborn">Battlefield {{ card.battlefield }} &#9671; Life {{ card.lifepool }} &#9671; Spellboard {{ card.spellboard }}</p>
      <p class="card-text" v-if="card.is_spell_alteration">Attack {{ card.attack_mod }} &#9671; Life {{ card.life_mod }} &#9671; Recover {{ card.recover_mod }}</p>
    </div>
  </div>
</template>

<script>
import MyCardText from './MyCardText';
import MyCardTextBlock from './MyCardTextBlock';

export default {
  name: 'my-card-card',
  props: ['card'],
  computed: {
    textLines() {
      return this.card.text.split('\n');
    },
  },
  components: {
    MyCardText,
    MyCardTextBlock,
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
</style>
