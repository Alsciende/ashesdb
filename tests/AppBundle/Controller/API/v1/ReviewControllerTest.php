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

    public function testPostReviewsFail ()
    {
        $client = $this->getAnonymousClient();
        $data = [
            "text" => "Lorem ipsum"
        ];
        $client->request('POST', '/api/v1/cards/coal-roarkwin/reviews', $data);
        $this->assertEquals(
                Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode()
        );
    }

    public function testPostReviews ()
    {
        $client = $this->getAuthenticatedClient();
        $data = [
            "text" => "Lorem ipsum"
        ];
        $client->request('POST', '/api/v1/cards/coal-roarkwin/reviews', $data);
        $this->assertEquals(
                Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertTrue(
                $content['success']
        );
        $this->assertEquals(
                "coal-roarkwin", $content['record']['card_code']
        );
        return $content['record'];
    }

    /**
     * @depends testPostReviews
     */
    public function testListReviews ()
    {
        $client = $this->getAnonymousClient();
        $this->assertStandardGetMany($client, "/api/v1/cards/coal-roarkwin/reviews");
    }

    /**
     * 
     * @depends testPostReviews
     */
    public function testGetReview (array $review)
    {
        $client = $this->getAnonymousClient();

        $client->request('GET', '/api/v1/cards/coal-roarkwin/reviews/' . $review['id']);
        $this->assertEquals(
                Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertEquals(
                $review['id'], $content['record']['id']
        );
        return $content['record'];
    }

    /**
     * @depends testGetReview
     * @param array $review
     * @return array
     */
    public function testPutReview (array $review)
    {
        $client = $this->getAuthenticatedClient();
        $data = [
            "text" => "Dolor sit amet"
        ];
        $client->request('PUT', '/api/v1/cards/coal-roarkwin/reviews/' . $review['id'], $data);
        $this->assertEquals(
                Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertTrue(
                $content['success']
        );
        $this->assertEquals(
                "Dolor sit amet", $content['record']['text']
        );
        return $content['record'];
    }

}
