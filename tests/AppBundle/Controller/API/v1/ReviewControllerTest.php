<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of ReviewControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ReviewControllerTest extends BaseApiControllerTest
{

    public function testListReviews ()
    {
        $client = $this->getAnonymousClient();

        $client->request('GET', '/api/v1/cards/coal-roarkwin/reviews');
        $this->assertEquals(
            Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertTrue(
                $content['success']
        );
        $this->assertEquals($content['size'], count($content['records']));
    }
    
    public function testPostReviews()
    {
        $client = $this->getAnonymousClient();
        $data = [
            "text" => "Lorem ipsum"
        ];
        $client->request('POST', '/api/v1/cards/coal-roarkwin/reviews?access_token='.$this->getAccessToken(), $data);
        $this->assertEquals(
                Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertTrue(
                $content['success']
        );
        $this->assertEquals("coal-roarkwin", $content['record']['card_code']);
        return $content['record']['id'];
    }
    
    /**
     * 
     * @depends testPostReviews
     */
    public function testGetReview ($id)
    {
        $client = $this->getAnonymousClient();

        $client->request('GET', '/api/v1/cards/coal-roarkwin/reviews/'.$id);
        $this->assertEquals(
            Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertEquals(
                $id, $content['record']['id']
        );
    }
    
    

}
