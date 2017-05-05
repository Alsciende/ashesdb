<?php

namespace AppBundle\Query;

/**
 * A Query for a list of cards
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryInput
{
    const SORT_SET = "set";
    const SORT_NAME = "name";
    const SORT_TYPE = "type";
    
    const VIEW_LIST = "list";
    const VIEW_IMAGES = "images";
    const VIEW_TEXT = "text";
    const VIEW_FULL = "full";
    const VIEW_ZOOM = "zoom";
    
    /**
     *
     * @var string
     */
    private $sort;
    
    /**
     *
     * @var string
     */
    private $view;
    
    /**
     *
     * @var QueryClause[]
     */
    private $clauses;
    
    function __construct ($clauses = [], $sort = self::SORT_NAME, $view = self::VIEW_LIST)
    {
        $this->clauses = $clauses;
        $this->sort = $sort;
        $this->view = $view;
    }

    function getSort ()
    {
        return $this->sort;
    }

    function getView ()
    {
        return $this->view;
    }

    function getClauses (): array
    {
        return $this->clauses;
    }

    function setSort ($sort)
    {
        $this->sort = $sort;
    }

    function setView ($view)
    {
        $this->view = $view;
    }

    function setClauses (array $clauses)
    {
        $this->clauses = $clauses;
    }



}
