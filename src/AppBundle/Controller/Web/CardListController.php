<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Card;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Description of CardListController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CardListController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{

    /**
     * @Route("/card/{card_code}")
     * @Method("GET")
     * @param string $card_code
     */
    function cardAction (string $card_code)
    {
        $clause = new \AppBundle\Query\QueryClause("", ":", array($card_code));
        $input = new \AppBundle\Query\QueryInput(array($clause));
        $render = $this->get('app.query_templating')->render($input);
        return new \Symfony\Component\HttpFoundation\Response($render);
    }

    /**
     * @Route("/prebuilt/{pack_code}/{view}/{sort}", defaults={"view" = "list", "sort" = "name"})
     * @Method("GET")
     * @param string pack_code
     */
    function packAction (string $pack_code, string $view, string $sort)
    {
        $clause = new \AppBundle\Query\QueryClause("p", ":", array($pack_code));
        $input = new \AppBundle\Query\QueryInput(array($clause), $view, $sort);
        $render = $this->get('app.query_templating')->render($input);
        return new \Symfony\Component\HttpFoundation\Response($render);
    }

    /**
     * @Route("/category/{cycle_code}/{view}/{sort}", defaults={"view" = "list", "sort" = "name"})
     * @Method("GET")
     * @param string $cycle_code
     */
    function cycleAction (string $cycle_code, string $view, string $sort)
    {
        $clause = new \AppBundle\Query\QueryClause("c", ":", array($cycle_code));
        $input = new \AppBundle\Query\QueryInput(array($clause), $view, $sort);
        $render = $this->get('app.query_templating')->render($input);
        return new \Symfony\Component\HttpFoundation\Response($render);
    }

    /**
     * @Route("/cards")
     * @Method("GET")
     */
    function searchAction (\Symfony\Component\HttpFoundation\Request $request)
    {
        $clauses = $this->get('app.query_parser')->parse($request->query->get('q'));
        $input = new \AppBundle\Query\QueryInput($clauses);
        $render = $this->get('app.query_templating')->render($input);
        return new \Symfony\Component\HttpFoundation\Response($render);
    }

}
