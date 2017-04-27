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
        /* @var $manager \AppBundle\Manager\ReviewManager */
        $manager = $this->get('app.review_manager');
        $review = $manager->create($request->request->all(), $this->getUser(), $card);
        return $this->encodeOne($review);
    }

    /**
     * @Route("/cards/{card_code}/reviews")
     * @Method("GET")
     * @ParamConverter("card", class="AppBundle:Card", options={"id" = "card_code"})
     */
    public function listAction (Card $card)
    {
        /* @var $manager \AppBundle\Manager\ReviewManager */
        $manager = $this->get('app.review_manager');
        $reviews = $manager->findByCard($card);
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

    /**
     * @Route("/cards/{card_code}/reviews/{id}")
     * @Method("PUT")
     * @Security("has_role('ROLE_USER')")
     */
    public function putAction (Request $request, Review $review)
    {
        if ($this->getUser() !== $review->getUser()) {
            throw $this->createAccessDeniedException();
        }

        /* @var $manager \AppBundle\Manager\ReviewManager */
        $manager = $this->get('app.review_manager');
        $updated = $manager->update($request->request->all(), $review->getId());
        return $this->encodeOne($updated);
    }

}
