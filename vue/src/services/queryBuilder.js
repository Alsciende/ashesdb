import queryMapper from './queryMapper'

class QueryBuilder {
  build(queryInput) {
    this.filter = {}
    queryInput.clauses.forEach(clause => { this.process(clause) })
    return this.filter
  }
  process(clause) {
    var field = queryMapper.getField(clause)
    if (field === false) {
      return
    }
    switch(field.type) {
      case 'string':
        this.filter[field.name] = {'likenocase': clause.args}
        break
      case 'integer':
        this.filter[field.name] = {'==': clause.args}
        break
      case 'boolean':
        this.filter[field.name] = {'is': !!clause.getArg()}
        break
      case 'code':
        this.filter[field.name] = {'is': clause.args}
        break;
      case 'join':
        this.filter[field.name] = {'has': clause.args}
        break
    }
  }
}

export default new QueryBuilder()
