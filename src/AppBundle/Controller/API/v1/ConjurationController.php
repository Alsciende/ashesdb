<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Conjuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of ConjurationController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ConjurationController extends BaseApiController
{

    /**
     * @Route("/conjurations")
     * @Method("GET")
     */
    public function getAction ()
    {
        $conjurations = $this->getDoctrine()->getRepository(Conjuration::class)->findAll();
        return $this->encodeMany($conjurations);
    }

}
