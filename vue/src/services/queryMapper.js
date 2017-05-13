class QueryMapper {
  constructor() {
    this.default = {
      "builder": "card", // which QueryBuilder will we add the DQL to
      "alias": 0, // position of the alias in the QueryBuilder
    }

    this.map = {
      "": function (clause) {
        if (clause.getArg().match(/^{a-z}+-{a-z-}+$/)) {
          // if it looks like a card code, treat it like a card code
          return {
            "name": "code",
            "type": "code",
            "description": "Card Code",
          }
        } else {
          // it may be a single word code, but then matching it like a name works too
          return {
            "name": "name",
            "type": "string",
            "description": "Card Title",
          }
        }
      },
      "x": {
        "name": "text",
        "type": "string",
        "description": "Card Text",
      },
      "a": {
        "name": "attack",
        "type": "integer",
        "description": "Unit Attack",
      },
      "l": {
        "name": "life",
        "type": "integer",
        "description": "Unit Life",
      },
      "r": {
        "name": "recover",
        "type": "integer",
        "description": "Unit Recover",
      },
      "p": {
        "name": "code",
        "type": "code",
        "builder": "pack",
        "alias": 1,
        "description": "Prebuilt deck",
      },
      "c": {
        "name": "code",
        "type": "code",
        "builder": "pack",
        "alias": 2,
        "description": "Category",
      },
      "d": {
        "name": "code",
        "type": "code",
        "builder": "dice",
        "alias": 1,
        "description": "Dice Code",
      },
      "t": {
        "name": "type",
        "type": "string",
        "description": "Card Type",
      },
      "u": {
        "name": "isUnit",
        "type": "boolean",
        "description": "Card Is Unit",
      },
      "s": {
        "name": "isSpell",
        "type": "boolean",
        "description": "Card Is Spell",
      },
      "pb": {
        "name": "isPhoenixborn",
        "type": "boolean",
        "description": "Card Is Phoenixborn",
      },
    }
  }
  getField (clause)    {
    if (this.map[clause.name] === null) {
      return false
    }

    var data = this.map[clause.name]
    if (typeof data === 'function') {
      data = data(clause)
    }

    return Object.assign({}, this.default, data)
  }
}

export default new QueryMapper()
