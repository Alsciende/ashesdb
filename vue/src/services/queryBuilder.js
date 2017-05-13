import queryMapper from './queryMapper'

class QueryBuilder {
  build(queryInput) {
    this.filter = {}
    queryInput.clauses.forEach(clause => { this.process(clause) })
    return this.filter
  }
  process(clause) {
    console.log('clause', clause)
    // TODO
  }
}

export default new QueryBuilder()
