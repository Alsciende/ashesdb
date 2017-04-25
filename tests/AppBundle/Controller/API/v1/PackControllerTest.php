<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of PackControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class PackControllerTest extends WebTestCase
{

    public function testGetPacks ()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/packs');
        $this->assertEquals(
                200, $client->getResponse()->getStatusCode()
        );
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(
                $content['success']
        );
        $this->assertGreaterThan(0, $content['size']);
        $this->assertEquals($content['size'], count($content['records']));
    }

}
