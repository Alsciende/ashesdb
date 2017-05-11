<?php

namespace AppBundle\Controller\Web;

use AppBundle\Query\QueryClause;
use AppBundle\Query\QueryInput;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of CardListController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CardListController extends Controller
{

    /**
     * @Route("/card/{card_code}")
     * @Method("GET")
     * @param string $card_code
     */
    function cardAction (string $card_code)
    {
        $clause = new QueryClause("", ":", array($card_code));
        $input = new QueryInput(array($clause));
        $render = $this->get('app.query_templating')->render($input);
        return new Response($render);
    }

    /**
     * @Route("/prebuilt/{pack_code}/{view}/{sort}", defaults={"view" = "list", "sort" = "name"})
     * @Method("GET")
     * @param string pack_code
     */
    function packAction (Request $request, string $pack_code, string $view, string $sort)
    {
        $page = $request->query->get('page', 1);
        $clause = new QueryClause("p", ":", array($pack_code));
        $input = new QueryInput(array($clause), $view, $sort, $page);
        $render = $this->get('app.query_templating')->render($input);
        return new Response($render);
    }

    /**
     * @Route("/category/{cycle_code}/{view}/{sort}", defaults={"view" = "list", "sort" = "name"})
     * @Method("GET")
     * @param string $cycle_code
     */
    function cycleAction (Request $request, string $cycle_code, string $view, string $sort)
    {
        $page = $request->query->get('page', 1);
        $clause = new QueryClause("c", ":", array($cycle_code));
        $input = new QueryInput(array($clause), $view, $sort, $page);
        $render = $this->get('app.query_templating')->render($input);
        return new Response($render);
    }

    /**
     * @Route("/cards")
     * @Method("GET")
     */
    function searchAction (Request $request)
    {
        $q = $request->query->get('q', '');
        $view = $request->query->get('view', QueryInput::VIEW_LIST);
        $sort = $request->query->get('sort', QueryInput::SORT_NAME);
        $page = $request->query->get('page', 1);
        $clauses = $this->get('app.query_parser')->parse($q);
        $pruned = $this->get('app.query_validator')->prune($clauses);
        $input = new QueryInput($pruned, $view, $sort, $page);
        $render = $this->get('app.query_templating')->render($input);
        return new Response($render);
    }

}
