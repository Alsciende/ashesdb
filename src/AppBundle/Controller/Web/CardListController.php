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
}
