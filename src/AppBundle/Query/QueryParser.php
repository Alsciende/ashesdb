<?php

namespace AppBundle\Query;

/**
 * Description of QueryParser
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryParser
{

    const STATE_INITIAL = 1;
    const STATE_ARGUMENT = 2;
    const STATE_ERROR = 3;

    /**
     * String to parse and transform into QueryClauses
     * 
     * @var string
     */
    private $query;

    /**
     * Result of parsing
     * 
     * @var QueryClause[]
     */
    private $list;

    /**
     * The clause currently being built by the parse
     * 
     * @var QueryClause
     */
    private $clause;

    /**
     * the parser has those states:
     * 1: looking for a type
     * 2: looking for a name
     * 3: looking for arguments
     * 4: parsing error, looking for next clause
     * if an argument is found in state 1, then type is empty
     *
     * @var integer
     */
    private $state;

    private function hasClause ()
    {
        return isset($this->clause);
    }

    private function saveClause ()
    {
        if ($this->hasClause()) {
            $this->list[] = $this->clause;
        }
    }

    private function createClause ()
    {
        $this->clause = new QueryClause();
    }

    /**
     * 
     * @return \AppBundle\Model\CardQuery
     */
    public function parse ($query)
    {
        $this->query = preg_replace('/\s+/u', ' ', trim($query));
        $this->list = [];
        $this->state = self::STATE_INITIAL;

        $success = $this->findClauses();

        // pending clause is ready
        if ($success && $this->clause->hasArguments()) {
            $this->saveClause();
        }

        return $this->list;
    }

    /**
     * Return TRUE if the parsing is successful, FALSE otherwise
     */
    public function findClauses ()
    {
        $this->createClause();

        while (strlen($this->query)) {
            switch ($this->state) {
                case self::STATE_INITIAL:
                    $this->findNameAndType();
                    break;
                case self::STATE_ARGUMENT:
                    $this->findArgument() || $this->findDisjonction() || $this->findConjonction() || $this->findNothing();
                    break;
                case self::STATE_ERROR:
                    return FALSE;
            }
        }

        return TRUE;
    }

    private function findNameAndType ()
    {
        // we're looking for a type but our current clause is ready -> close it
        if ($this->hasClause() && $this->clause->hasArguments()) {
            $this->saveClause();
            $this->createClause();
        }

        // looking for a type
        $match = $this->findToken('(\p{L}+)([:<>!])');
        if ($match) {
            // we have found a token "{condition}:"
            $this->clause
                    ->setName(mb_strtolower($match[1]))
                    ->setType($match[2]);
        } else {
            // we didn't find a type token at the start of the query
            // so the type is the implicit one
            $this->clause
                    ->setName(QueryClause::IMPLICIT_NAME)
                    ->setType(QueryClause::IMPLICIT_TYPE);
        }

        // we have name and type, let's find the arguments
        $this->state = self::STATE_ARGUMENT;

        return TRUE;
    }

    private function findArgument ()
    {
        // token 'any text in quotes' or 'allowed text without quotes'
        $match = $this->findToken('"([^"]*)"') ?: $this->findToken('([\p{L}\p{N}\-\&]+)');

        if (!$match) {
            return FALSE;
        }

        $this->clause->addArgument($match[1]);

        return TRUE;
    }

    private function findDisjonction ()
    {
        // token '|'
        $match = $this->findToken('\|');

        if (!$match) {
            return FALSE;
        }

        if ($this->clause->getType() === ':' || $this->clause->getType() === '!') {
            // type allows disjonctions
            // nothing to do, the parser will eat the token on next iteration
        } else {
            // error
            $this->state = self::STATE_ERROR;
        }

        return TRUE;
    }

    private function findConjonction ()
    {
        // token ' '
        $match = $this->findToken(' ');

        if (!$match) {
            return FALSE;
        }

        $this->state = self::STATE_INITIAL;

        return TRUE;
    }

    private function findNothing ()
    {
        // error
        $this->query = substr($this->query, 1);
        $this->state = self::STATE_ERROR;
    }

    /**
     * Try to match the start of query with the token
     * If successful, return the matches and remove the token from the query
     * Else, return FALSE
     * 
     * @param string $token
     * @return array
     */
    private function findToken ($token)
    {
        $regexp = "/^$token(.*)/u";
        $match = [];
        if (preg_match($regexp, $this->query, $match)) {
            $this->query = array_pop($match);
            return $match;
        } else {
            return FALSE;
        }
    }

}
