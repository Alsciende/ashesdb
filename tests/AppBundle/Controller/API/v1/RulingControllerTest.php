<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of RulingControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class RulingControllerTest extends BaseApiControllerTest
{

    public function testPostRulingsFail ()
    {
        $client = $this->getAnonymousClient();
        $data = [
            "text" => "Lorem ipsum"
        ];
        $client->request('POST', '/api/v1/cards/coal-roarkwin/rulings', $data);
        $this->assertEquals(
                Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode()
        );
    }

    public function testPostRulings ()
    {
        $client = $this->getAuthenticatedClient('guru');
        $data = [
            "text" => "Lorem ipsum"
        ];
        $client->request('POST', '/api/v1/cards/coal-roarkwin/rulings', $data);
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
     * @depends testPostRulings
     */
    public function testListRulings ()
    {
        $client = $this->getAnonymousClient();
        $this->assertStandardGetMany($client, "/api/v1/cards/coal-roarkwin/rulings");
    }

    /**
     * 
     * @depends testPostRulings
     */
    public function testGetRuling (array $ruling)
    {
        $client = $this->getAnonymousClient();

        $client->request('GET', '/api/v1/cards/coal-roarkwin/rulings/' . $ruling['id']);
        $this->assertEquals(
                Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertEquals(
                $ruling['id'], $content['record']['id']
        );
        return $content['record'];
    }

    /**
     * @depends testGetRuling
     * @param array $ruling
     * @return array
     */
    public function testPutRuling (array $ruling)
    {
        $client = $this->getAuthenticatedClient('guru');
        $data = [
            "text" => "Dolor sit amet"
        ];
        $client->request('PUT', '/api/v1/cards/coal-roarkwin/rulings/' . $ruling['id'], $data);
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
