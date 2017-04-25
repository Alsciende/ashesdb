<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Pack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of PacksController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class PackController extends BaseApiController
{

    /**
     * @Route("/packs")
     * @Method("GET")
     */
    public function indexAction ()
    {
        $packs = $this->getDoctrine()->getRepository(Pack::class)->findAll();
        return $this->encode($packs);
    }

}
