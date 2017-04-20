<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of CycleControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CycleControllerTest extends WebTestCase
{

    public function testGetCycles ()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/cycles');
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
