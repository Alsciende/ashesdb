<?php

namespace AppBundle\Controller\API;

use AppBundle\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of ApiController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
abstract class BaseApiController extends Controller
{
    public function encode($entities)
    {
        /* @var $service ApiService */
        $service = $this->get('app.api');
        
        return $service->buildResponse($entities);
    }
}
