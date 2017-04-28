<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of DeckControllerTest
 *
 * @author Cédric Bertolini <cedric.bertolini@proximedia.fr>
 */
class DeckControllerTest extends BaseApiControllerTest
{

    private function getDeckSlots() {
        return [
                "jessa-na-ni" => 1,
                "blood-archer" => 3,
                "blood-transfer" => 3,
                "cut-the-string" => 3,
                "fear" => 3,
                "final-cry" => 3,
                "leech-warrior" => 3,
                "living-doll" => 3,
                "redirect" => 3,
                "summon-blood-puppet" => 3,
                "blood-puppet" => 5,
                "undying-heart" => 3,
            ];
    }
    
    public function testPostDeck ()
    {
        $data = [
            "name" => "Test Deck",
            "description" => "This is the description",
            "tags" => "test,deck",
            "slots" => $this->getDeckSlots()
        ];
        
        $client = $this->getAuthenticatedClient();
        $client->request('POST', '/api/v1/decks', $data);
        $this->assertEquals(
                Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertTrue(
                $content['success']
        );
        return $content['record'];        
    }

    public function testPostDeckFailName ()
    {
        $data = [
            "description" => "This is the description",
            "tags" => "test,deck",
            "slots" => $this->getDeckSlots()
        ];
        
        $client = $this->getAuthenticatedClient();
        $client->request('POST', '/api/v1/decks', $data);
        $this->assertEquals(
                Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertFalse(
                $content['success']
        );
    }

}
