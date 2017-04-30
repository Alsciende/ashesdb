<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Card;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of CardsController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CardController extends BaseApiController
{

    /**
     * @Route("/cards")
     * @Method("GET")
     */
    public function listAction ()
    {
        $cards = $this->getDoctrine()->getRepository(Card::class)->findAll();
        return $this->success($cards);
    }

    /**
     * @Route("/cards/{id}")
     * @Method("GET")
     */
    public function getAction (Card $card)
    {
        return $this->success($card );
    }

}
