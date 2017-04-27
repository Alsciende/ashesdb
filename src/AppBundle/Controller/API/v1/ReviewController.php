<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Card;
use AppBundle\Entity\Review;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ReviewController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ReviewController extends BaseApiController
{
    /**
     * @Route("/cards/{card_code}/reviews")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("card", class="AppBundle:Card", options={"id" = "card_code"})
     */
    public function postAction (Request $request, Card $card)
    {
        /* @var $review Review */
        $review = $this->denormalize($request->request->all(), Review::class);
        $review->setCard($card);
        $review->setUser($this->getUser());
        $this->getDoctrine()->getManager()->persist($review);
        $this->getDoctrine()->getManager()->flush();
        $this->getDoctrine()->getManager()->refresh($review);
        return $this->encodeOne($review);
    }
    
    /**
     * @Route("/cards/{card_code}/reviews")
     * @Method("GET")
     * @ParamConverter("card", class="AppBundle:Card", options={"id" = "card_code"})
     */
    public function listAction (Card $card)
    {
        $reviews = $this->getDoctrine()->getRepository(Review::class)->findBy(['card' => $card]);
        return $this->encodeMany($reviews);
    }
    
    /**
     * @Route("/cards/{card_code}/reviews/{id}")
     * @Method("GET")
     */
    public function getAction (Review $review)
    {
        return $this->encodeOne($review);
    }
}
