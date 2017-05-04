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
     * @ParamConverter("card", class="AppBundle:Card", options={"id" = "card_code"})
     * @param Card $card
     */
    function cardAction(Card $card)
    {
        $clause = new \AppBundle\Query\QueryClause("", ":", array($card->getCode()));
        $input = new \AppBundle\Query\QueryInput(array($clause));
        $view = $this->get('app.query_templating')->render($input);
        return new \Symfony\Component\HttpFoundation\Response($view);
    }
    
    /**
     * @Route("/pack/{pack_code}")
     * @Method("GET")
     * @ParamConverter("pack", class="AppBundle:Pack", options={"id" = "pack_code"})
     * @param Pack $pack
     */
    function packAction(\AppBundle\Entity\Pack $pack)
    {
        $clause = new \AppBundle\Query\QueryClause("p", ":", array($pack->getCode()));
        $input = new \AppBundle\Query\QueryInput(array($clause));
        $view = $this->get('app.query_templating')->render($input);
        return new \Symfony\Component\HttpFoundation\Response($view);
    }
    
    /**
     * @Route("/cycle/{cycle_code}")
     * @Method("GET")
     * @ParamConverter("cycle", class="AppBundle:Cycle", options={"id" = "cycle_code"})
     * @param \AppBundle\Entity\Cycle $cycle
     */
    function cycleAction(\AppBundle\Entity\Cycle $cycle)
    {
        $clause = new \AppBundle\Query\QueryClause("y", ":", array($cycle->getCode()));
        $input = new \AppBundle\Query\QueryInput(array($clause));
        $view = $this->get('app.query_templating')->render($input);
        return new \Symfony\Component\HttpFoundation\Response($view);
    }
    
    /**
     * @Route("/cards")
     * @Method("GET")
     */
    function searchAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $clauses = $this->get('app.query_parser')->parse($request->query->get('q'));
        $input = new \AppBundle\Query\QueryInput($clauses);
        $view = $this->get('app.query_templating')->render($input);
        return new \Symfony\Component\HttpFoundation\Response($view);
    }
}
