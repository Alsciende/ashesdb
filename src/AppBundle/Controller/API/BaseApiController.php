<?php

namespace AppBundle\Controller\API;

use AppBundle\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of ApiController
 *
 * @author Cédric Bertolini <cedric.bertolini@proximedia.fr>
 */
abstract class ApiController extends Controller
{
    public function encode($entities)
    {
        /* @var $service ApiService */
        $service = $this->get('app.api');
        
        return $service->buildResponse($entities);
    }
}
