<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Card;
use AppBundle\Entity\Ruling;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of RulingController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class RulingController extends BaseApiController
{

    /**
     * @Route("/cards/{card_code}/rulings")
     * @Method("POST")
     * @Security("has_role('ROLE_GURU')")
     * @ParamConverter("card", class="AppBundle:Card", options={"id" = "card_code"})
     */
    public function postAction (Request $request, Card $card)
    {
        /* @var $manager \AppBundle\Manager\RulingManager */
        $manager = $this->get('app.ruling_manager');
        $ruling = $manager->create($request->request->all(), $this->getUser(), $card);
        return $this->encodeOne($ruling);
    }

    /**
     * @Route("/cards/{card_code}/rulings")
     * @Method("GET")
     * @ParamConverter("card", class="AppBundle:Card", options={"id" = "card_code"})
     */
    public function listAction (Card $card)
    {
        /* @var $manager \AppBundle\Manager\RulingManager */
        $manager = $this->get('app.ruling_manager');
        $rulings = $manager->findByCard($card);
        return $this->encodeMany($rulings);
    }

    /**
     * @Route("/cards/{card_code}/rulings/{id}")
     * @Method("GET")
     */
    public function getAction (Ruling $ruling)
    {
        return $this->encodeOne($ruling);
    }

    /**
     * @Route("/cards/{card_code}/rulings/{id}")
     * @Method("PUT")
     * @Security("has_role('ROLE_GURU')")
     */
    public function putAction (Request $request, Ruling $ruling)
    {
        if ($this->getUser() !== $ruling->getUser()) {
            throw $this->createAccessDeniedException();
        }

        /* @var $manager \AppBundle\Manager\RulingManager */
        $manager = $this->get('app.ruling_manager');
        $updated = $manager->update($request->request->all(), $ruling->getId());
        return $this->encodeOne($updated);
    }

}
