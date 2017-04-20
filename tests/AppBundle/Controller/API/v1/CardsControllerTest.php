<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of CardsControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CardsControllerTest extends WebTestCase
{

    public function testGetCards ()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/cards');
        $this->assertEquals(
                200, $client->getResponse()->getStatusCode()
        );
    }

}
