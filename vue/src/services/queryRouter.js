import queryParser from './queryParser';

class QueryRouter {
  constructor() {
    this.config = {
      id: 'cards-by-card-code',
      p: 'cards-by-prebuilt-code',
    };
    this.reverseMatching = {
      'cards-by-search-query': function matcher(route) {
        return route.query.q;
      },
      'cards-by-card-code': function matcher(route) {
        return `id:${route.params.code}`;
      },
      'cards-by-prebuilt-code': function matcher(route) {
        return `p:${route.params.code}`;
      },
      'cards-by-default': '',
    };
  }

  getRoute(query) {
    const clauses = queryParser.parse(query);
    if (clauses.length === 1) {
      const clause = clauses[0];
      const name = this.config[clause.name];
      if (name && clause.args.length === 1) {
        const params = { code: clause.getArg() };
        return { name, params };
      }
    }
    return { name: 'cards-by-search-query', query: { q: query } };
  }

  getQuery(route) {
    const matcher = this.reverseMatching[route.name];
    switch (typeof matcher) {
      case 'string':
        return matcher;
      case 'function':
        return matcher(route);
      default:
        return null;
    }
  }
}

export default new QueryRouter();
