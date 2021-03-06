<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Card;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Description of CardsController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CardController extends BaseApiController
{

    /**
     * Get all Cards
     * 
     * @ApiDoc(
     *  resource=true,
     *  output="AppBundle\Entity\Card",
     *  section="Cards",
     *  filters={
     *      {"name"="q", "dataType"="string"}
     *  }
     * )
     * @Route("/cards")
     * @Method("GET")
     */
    public function listAction (\Symfony\Component\HttpFoundation\Request $request)
    {
        $q = $request->query->get('q');
        if($q) {
            $clauses = $this->get('app.query_parser')->parse($q);
            $input = new \AppBundle\Query\QueryInput($clauses);
            $query = $this->get('app.query_builder')->getQuery($input);
            $cards = $query->getResult();
        } else {
            $cards = $this->getDoctrine()->getRepository(Card::class)->findAll();
        }
        return $this->success($cards);
    }

    /**
     * Get a Card
     * 
     * @ApiDoc(
     *  resource=true,
     *  output="AppBundle\Entity\Card",
     *  section="Cards",
     * )
     * @Route("/cards/{card_code}")
     * @Method("GET")
     * @ParamConverter("card", class="AppBundle:Card", options={"id" = "card_code"})
     */
    public function getAction (Card $card)
    {
        return $this->success($card );
    }

}
