<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\PackSlot;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of PackSlotController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class PackSlotController extends BaseApiController
{

    /**
     * @Route("/pack_slots")
     * @Method("GET")
     */
    public function getAction ()
    {
        $packSlots = $this->getDoctrine()->getRepository(PackSlot::class)->findAll();
        return $this->success($packSlots);
    }

}
