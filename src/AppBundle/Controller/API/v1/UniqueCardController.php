<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\UniqueCard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of UniqueCardController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class UniqueCardController extends BaseApiController
{

    /**
     * @Route("/unique_cards")
     * @Method("GET")
     */
    public function getAction ()
    {
        $uniqueCards = $this->getDoctrine()->getRepository(UniqueCard::class)->findAll();
        return $this->encode($uniqueCards);
    }

}
