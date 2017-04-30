<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\PackCard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of PackCardController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class PackCardController extends BaseApiController
{

    /**
     * @Route("/pack_cards")
     * @Method("GET")
     */
    public function getAction ()
    {
        $packCards = $this->getDoctrine()->getRepository(PackCard::class)->findAll();
        return $this->success($packCards);
    }

}
