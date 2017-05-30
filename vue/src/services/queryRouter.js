import queryParser from './queryParser'

class QueryRouter {
  constructor() {
    this.config = {
      "id": "cards-by-card-code"/*,
      "p": "cards-by-prebuilt-code"*/
    }
  }
  getRoute(query) {
    const clauses = queryParser.parse(query)
    if(clauses.length === 1) {
      let clause = clauses[0]
      let name = this.config[clause.name]
      if(name && clause.args.length === 1) {
        let params = { code: clause.getArg() }
        return { name, params }
      }
    }
    return { name: "cards-by-search-query", query: { q: query } }
  }
}

export default new QueryRouter()
