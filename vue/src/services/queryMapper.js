class QueryMapper {
  constructor() {
    this.default = {
      builder: 'card', // which QueryBuilder will we add the DQL to
      alias: 0, // position of the alias in the QueryBuilder
    };

    this.map = {
      '': {
        name: 'name',
        type: 'string',
        description: 'Card Title',
      },
      id: {
        name: 'code',
        type: 'code',
        description: 'Card Code',
      },
      x: {
        name: 'text',
        type: 'string',
        description: 'Card Text',
      },
      a: {
        name: 'attack',
        type: 'integer',
        description: 'Unit Attack',
      },
      l: {
        name: 'life',
        type: 'integer',
        description: 'Unit Life',
      },
      r: {
        name: 'recover',
        type: 'integer',
        description: 'Unit Recover',
      },
      p: {
        name: 'packs',
        type: 'join',
        description: 'Prebuilt deck',
      },
      c: {
        name: 'cycles',
        type: 'join',
        description: 'Category',
      },
      d: {
        name: 'dices',
        type: 'join',
        description: 'Dice Code',
      },
      t: {
        name: 'type',
        type: 'string',
        description: 'Card Type',
      },
      u: {
        name: 'is_unit',
        type: 'boolean',
        description: 'Card Is Unit',
      },
      s: {
        name: 'is_spell',
        type: 'boolean',
        description: 'Card Is Spell',
      },
      pb: {
        name: 'is_phoenixborn',
        type: 'boolean',
        description: 'Card Is Phoenixborn',
      },
    };
  }
  getField(clause) {
    if (this.map[clause.name] === null) {
      return false;
    }

    let data = this.map[clause.name];
    if (typeof data === 'function') {
      data = data(clause);
    }

    return Object.assign({}, this.default, data);
  }
}

export default new QueryMapper();
