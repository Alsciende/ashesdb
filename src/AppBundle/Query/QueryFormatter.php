<?php

namespace AppBundle\Query;

/**
 * Transform a QueryClause into a string
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryFormatter
{
    /**
     * Return a string representation of an array of QueryClause
     * 
     * @param QueryClause[] $clauses
     * @return string
     */
    public function stringify(array $clauses)
    {
        return implode(' ', array_map(array($this, 'format'), $clauses));
    }
    
    /**
     * Return a string representation of a QueryClause
     * 
     * @param \AppBundle\Query\QueryClause $clause
     * @return string
     */
    public function format(QueryClause $clause)
    {
        return $clause->getName() . $clause->getType() . implode('|', $clause->getArguments());
    }
}
