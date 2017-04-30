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
        $record = $this->assertStandardGetOne($client);
        $this->assertEquals(
                "coal-roarkwin", $record['card_code']
        );
        return $record;
    }

    /**
     * @depends testPostReviews
     */
    public function testListReviews ()
    {
        $client = $this->getAnonymousClient();
        $client->request('GET', "/api/v1/cards/coal-roarkwin/reviews");
        $this->assertStandardGetMany($client);
    }

    /**
     * 
     * @depends testPostReviews
     */
    public function testGetReview (array $review)
    {
        $client = $this->getAnonymousClient();

        $client->request('GET', '/api/v1/cards/coal-roarkwin/reviews/' . $review['id']);
        $record = $this->assertStandardGetOne($client);
        $this->assertEquals(
                $review['id'], $record['id']
        );
        return $record;
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
        $record = $this->assertStandardGetOne($client);
        $this->assertEquals(
                "Dolor sit amet", $record['text']
        );
        return $record;
    }

}
