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
    public function encodeMany(array $entities)
    {
        /* @var $service ApiService */
        $service = $this->get('app.api');
        
        return $service->buildResponseMany($entities);
    }
    
    public function encodeOne($entity)
    {
        /* @var $service ApiService */
        $service = $this->get('app.api');
        
        return $service->buildResponseOne($entity);
    }
    
    public function denormalize($data, $type)
    {
        /* @var $serializer \Symfony\Component\Serializer\Serializer */
        $serializer = $this->get('serializer');
        
        return $serializer->denormalize($data, $type);
    }
}
