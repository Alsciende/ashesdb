<?php

namespace AppBundle\Query;

/**
 * Validates a QueryClause
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryValidator
{
    
    /**
     *
     * @var QueryMapper
     */
    private $queryMapper;

    public function __construct (QueryMapper $queryMapper)
    {
        $this->queryMapper = $queryMapper;
    }
    
    /**
     * Remove from its arguments all invalide clauses
     * 
     * @param QueryClause[] $clauses
     * @return QueryClause[]
     */
    public function prune(array $clauses)
    {
        return array_filter($clauses, array($this, 'validate'));
    }
    
    /**
     * Return TRUE if its argument is a valid clause, FALSE otherwise
     * 
     * @param \AppBundle\Query\QueryClause $clause
     * @return boolean
     */
    public function validate(QueryClause $clause)
    {
        $field = $this->queryMapper->getField($clause);
        
        // if the clause is invalid
        if ($field === FALSE) {
            return FALSE;
        }

        $validator = $field['type'] . "Validator";
        
        if(method_exists($this, $validator)) {
            return $this->$validator($clause);
        }
        
        return TRUE;
    }

    private function stringValidator(QueryClause $clause)
    {
        return TRUE;
    }
    
    private function integerValidator(QueryClause $clause) {
        foreach($clause->getArguments() as $argument) {
            if(!is_numeric($argument)) {
                return FALSE;
            }
        }
        return TRUE;
    }
    
    private function booleanValidator(QueryClause $clause) {
        return count($clause->getArgument()) === 1 && in_array($clause->getArgument(), ["0", "1"]);
    }
    
    private function codeValidator(QueryClause $clause) {
        foreach($clause->getArguments() as $argument) {
            if(!preg_match('/^[\w-]+$/', $argument)) {
                return FALSE;
            }
        }
        return TRUE;
    }
    
}
