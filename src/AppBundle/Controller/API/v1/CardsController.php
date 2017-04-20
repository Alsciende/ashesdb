<?php

namespace AppBundle\Controller\API\v1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of CardsController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CardsController extends Controller
{

    /**
     * @Route("/cards")
     * @Method("GET")
     */
    public function indexAction ()
    {
        return new JsonResponse(["success" => true]);
    }
    
}
