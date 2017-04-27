<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Cycle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of CyclesController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CycleController extends BaseApiController
{

    /**
     * @Route("/cycles")
     * @Method("GET")
     */
    public function getAction ()
    {
        $cycles = $this->getDoctrine()->getRepository(Cycle::class)->findAll();
        return $this->encodeMany($cycles);
    }

}
