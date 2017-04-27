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

    function __construct (RequestStack $requestStack, Deserializer $deserializer, $httpCacheMaxAge)
    {
        $this->requestStack = $requestStack;
        $this->deserializer = $deserializer;
        $this->httpCacheMaxAge = $httpCacheMaxAge;
    }

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

    function buildResponseMany ($entities, $content = [])
    {
        $response = $this->getEmptyResponse();

        $dateUpdate = $this->getDateUpdate($entities);

        $response->setLastModified($dateUpdate);
        if($response->isNotModified($this->requestStack->getCurrentRequest())) {
            return $response;
        }

        $content['records'] = [];
        foreach($entities as $entity) {
            $content['records'][] = $this->deserializer->deserialize($entity);
        }

        $content['size'] = count($content['records']);
        $content['success'] = TRUE;
        $content['last_updated'] = $dateUpdate ? $dateUpdate->format('c') : null;

        $response->setData($content);

        return $response;
    }

    function buildResponseOne ($entity, $content = [])
    {
        $response = $this->getEmptyResponse();

        $dateUpdate = $entity->getUpdatedAt();

        $response->setLastModified($dateUpdate);
        if($response->isNotModified($this->requestStack->getCurrentRequest())) {
            return $response;
        }

        $content['record'] = $this->deserializer->deserialize($entity);

        $content['success'] = TRUE;
        $content['last_updated'] = $dateUpdate ? $dateUpdate->format('c') : null;

        $response->setData($content);

        return $response;
    }

    function getDateUpdate ($entities)
    {
        return array_reduce($entities, function($carry, $item) {
            if($carry || $item->getUpdatedAt() > $carry) {
                return $item->getUpdatedAt();
            } else {
                return $carry;
            }
        });
    }

    function getEmptyResponse ()
    {
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $response->setPublic();
        $response->setMaxAge($this->httpCacheMaxAge);

        return $response;
    }

}
