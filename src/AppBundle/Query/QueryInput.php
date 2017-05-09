<?php

namespace AppBundle\Query;

/**
 * A Query for a list of cards
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryInput
{

    const VIEW_LIST = "list";
    const VIEW_IMAGES = "images";
    const VIEW_TEXT = "text";
    const VIEW_FULL = "full";
    const VIEW_ZOOM = "zoom";
    const SORT_SET = "set";
    const SORT_NAME = "name";
    const SORT_TYPE = "type";

    /**
     *
     * @var string
     */
    private $view;

    /**
     *
     * @var string
     */
    private $sort;

    /**
     *
     * @var QueryClause[]
     */
    private $clauses;

    function __construct ($clauses = [], $view = self::VIEW_LIST, $sort = self::SORT_NAME)
    {
        $this->clauses = $clauses;
        $this->view = $view;
        $this->sort = $sort;
    }

    function getClauses (): array
    {
        return $this->clauses;
    }

    function getView ()
    {
        return $this->view;
    }

    function getSort ()
    {
        return $this->sort;
    }

    function setClauses (array $clauses)
    {
        $this->clauses = $clauses;
    }

    function setView ($view)
    {
        $this->view = $view;
    }

    function setSort ($sort)
    {
        $this->sort = $sort;
    }

}
