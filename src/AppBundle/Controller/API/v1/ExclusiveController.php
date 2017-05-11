<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Exclusive;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Description of ExclusiveController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ExclusiveController extends BaseApiController
{

    /**
     * Get all pairs Phoenixborn-Exclusive
     * 
     * @ApiDoc(
     *  resource=true,
     *  output="AppBundle\Entity\Exclusive",
     *  section="Cards",
     * )
     * @Route("/exclusives")
     * @Method("GET")
     */
    public function listAction ()
    {
        $exclusives = $this->getDoctrine()->getRepository(Exclusive::class)->findAll();
        return $this->success($exclusives);
    }

}
