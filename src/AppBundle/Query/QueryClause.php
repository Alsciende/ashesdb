<?php

namespace AppBundle\Query;

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
    private $name;

    /**
     *
     * @var string
     */
    private $type;

    /**
     *
     * @var array
     */
    private $arguments;

    function __construct ($name = self::IMPLICIT_NAME, $type = self::IMPLICIT_TYPE, $arguments = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->arguments = $arguments;
    }

    function getName ()
    {
        return $this->name;
    }

    function getType ()
    {
        return $this->type;
    }

    function getArguments ()
    {
        return $this->arguments;
    }

    function setName ($name)
    {
        $this->name = $name;
        return $this;
    }

    function setType ($type)
    {
        $this->type = $type;
        return $this;
    }

    function setArguments ($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    function hasArguments ()
    {
        return count($this->arguments) > 0;
    }

    function addArgument ($argument)
    {
        $this->arguments[] = $argument;
        return $this;
    }

    function getArgument ($i = 0)
    {
        if (count($this->arguments) > $i) {
            return $this->arguments[$i];
        }
    }

}
