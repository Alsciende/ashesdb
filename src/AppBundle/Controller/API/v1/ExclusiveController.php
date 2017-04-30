<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Exclusive;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of ExclusiveController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ExclusiveController extends BaseApiController
{

    /**
     * @Route("/exclusives")
     * @Method("GET")
     */
    public function getAction ()
    {
        $exclusives = $this->getDoctrine()->getRepository(Exclusive::class)->findAll();
        return $this->success($exclusives);
    }

}
