<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of PackControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class PackControllerTest extends BaseApiControllerTest
{

    public function testGetPacks ()
    {
        $client = $this->getAnonymousClient();

        $client->request('GET', '/api/v1/packs');
        $this->assertEquals(
                Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertTrue(
                $content['success']
        );
        $this->assertGreaterThan(0, $content['size']);
        $this->assertEquals($content['size'], count($content['records']));
    }

}
