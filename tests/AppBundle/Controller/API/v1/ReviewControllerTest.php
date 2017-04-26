<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of ReviewControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ReviewControllerTest extends WebTestCase
{

    public function testGetReviews ()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/cards/coal-roarkwin/reviews');
        $this->assertEquals(
                200, $client->getResponse()->getStatusCode()
        );
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(
                $content['success']
        );
        $this->assertEquals($content['size'], count($content['records']));
    }

}
