<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Card;
use AppBundle\Entity\Review;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of ReviewController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ReviewController extends \AppBundle\Controller\API\BaseApiController
{
    /**
     * @Route("/cards/{card_id}/reviews")
     * @Method("POST")
     */
    public function postAction (\Symfony\Component\HttpFoundation\Request $request)
    {
        
    }
    
    /**
     * @Route("/cards/{card_id}/reviews")
     * @Method("GET")
     */
    public function getAction ($card_id)
    {
        $card = $this->getDoctrine()->getRepository(Card::class)->find($card_id);
        if(!$card) {
            throw $this->createNotFoundException();
        }
        
        $reviews = $this->getDoctrine()->getRepository(Review::class)->findBy(['card' => $card]);
        return $this->encode($reviews);
    }
}
