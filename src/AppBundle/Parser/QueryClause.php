<?php

namespace AppBundle\Parser;

/**
 * A Clause in a Query (for example, "attack > 2")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryClause
{
    const IMPLICIT_NAME = "";
    const IMPLICIT_TYPE = ":";
    
    /**
     *
     * @var string
     */
    private $type;
    
    /**
     *
     * @var string
     */
    private $name;
    
    /**
     *
     * @var array
     */
    private $arguments;
    
    function getType ()
    {
        return $this->type;
    }

    function getName ()
    {
        return $this->name;
    }

    function getArguments ()
    {
        return $this->arguments;
    }

    function setType ($type)
    {
        $this->type = $type;
        return $this;
    }

    function setName ($name)
    {
        $this->name = $name;
        return $this;
    }

    function setArguments ($Arguments)
    {
        $this->arguments = $Arguments;
        return $this;
    }

    function hasArguments ()
    {
        return count($this->arguments) > 0;
    }
    
    function addArgument($argument)
    {
        $this->arguments[] = $argument;
        return $this;
    }

}
