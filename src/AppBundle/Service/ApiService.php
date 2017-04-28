<?php

namespace AppBundle\Service;

use Alsciende\SerializerBundle\Serializer\Deserializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Description of ApiService
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ApiService
{

    /**
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     *
     * @var Deserializer 
     */
    private $deserializer;

    /**
     *
     * @var integer
     */
    private $httpCacheMaxAge;

    function __construct (RequestStack $requestStack, Deserializer $deserializer, $httpCacheMaxAge)
    {
        $this->requestStack = $requestStack;
        $this->deserializer = $deserializer;
        $this->httpCacheMaxAge = $httpCacheMaxAge;
    }

    function buildResponse ($data)
    {
        $request = $this->requestStack->getCurrentRequest();
        $isPublic = $request->getMethod() === 'GET';
        $response = $this->getEmptyResponse($isPublic);

        if($isPublic) {
            // make response public and cacheable
            $response->setPublic();
            $response->setMaxAge($this->httpCacheMaxAge);
            // find last update of data
            $dateUpdate = $this->getDateUpdate($data);
            $response->setLastModified($dateUpdate);
            // compare to request header
            if($response->isNotModified($request)) {
                return $response;
            }
        }

        $content = $this->buildContent($data);
        $content['success'] = TRUE;
        $content['last_updated'] = isset($dateUpdate) ? $dateUpdate->format('c') : null;

        $response->setData($content);

        return $response;
    }

    function buildContent ($data)
    {
        $content = [];
        if(is_array($data)) {
            foreach($data as $entity) {
                $content['records'][] = $this->deserializer->deserialize($entity);
            }
            $content['size'] = count($content['records']);
        } else {
            $content['record'] = $this->deserializer->deserialize($data);
        }
        return $content;
    }

    function getDateUpdate ($data)
    {
        if(!is_array($data)) {
            $data = array($data);
        }
        return array_reduce($data, function($carry, $item) {
            if($carry && $item->getUpdatedAt() < $carry) {
                return $carry;
            } else {
                return $item->getUpdatedAt();
            }
        });
    }

    function getEmptyResponse ()
    {
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        return $response;
    }

}
