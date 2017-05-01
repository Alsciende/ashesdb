<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Conjuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Description of ConjurationController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ConjurationController extends BaseApiController
{

    /**
     * Get all pairs Source-Conjuration
     * 
     * @ApiDoc(
     *  resource=true,
     *  output="AppBundle\Entity\Conjuration",
     *  section="Cards",
     * )
     * @Route("/conjurations")
     * @Method("GET")
     */
    public function listAction ()
    {
        $conjurations = $this->getDoctrine()->getRepository(Conjuration::class)->findAll();
        return $this->success($conjurations);
    }

}
