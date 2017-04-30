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

    private function getDeckCards ()
    {
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

    private function getDeckDices ()
    {
        return [
            "ceremonial" => 5,
            "charm" => 5,
        ];
    }

    public function testPostDeck ()
    {
        $data = [
            "name" => "Test Deck",
            "description" => "This is the description",
            "tags" => "test,deck",
            "cards" => $this->getDeckCards(),
            "dices" => $this->getDeckDices(),
        ];

        $client = $this->getAuthenticatedClient();
        $client->request('POST', '/api/v1/decks', $data);
        $record = $this->assertStandardGetOne($client);
        $this->assertEquals(
                2, count($record['dices'])
        );
        $this->assertEquals(
                12, count($record['cards'])
        );
        $this->assertEquals(
                "0.1", $record['version']
        );
        return $record;
    }

    public function testPostDeckFailName ()
    {
        $data = [
            // missing name
            "description" => "This is the description",
            "tags" => "test,deck",
            "cards" => $this->getDeckCards(),
            "dices" => $this->getDeckDices(),
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
