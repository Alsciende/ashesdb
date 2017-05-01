<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of DeckLineageControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DeckLineageControllerTest extends BaseApiControllerTest
{

    public function testPostDeck ()
    {
        $data = [
            "name" => "Test Deck",
            "phoenixborn_code" => "jessa-na-ni",
            "description" => "This is the description",
            "tags" => "test,deck",
            "cards" => [
                "blood-archer" => 3,
                "blood-transfer" => 3,
                "cut-the-string" => 3,
                "fear" => 3,
                "final-cry" => 3,
                "leech-warrior" => 3,
                "living-doll" => 3,
                "redirect" => 3,
                "summon-blood-puppet" => 3,
                "undying-heart" => 3,
            ],
            "dices" => [
                "ceremonial" => 5,
                "charm" => 5,
            ],
        ];

        $client = $this->getAuthenticatedClient();
        $this->sendJsonRequest($client, 'POST', '/api/v1/private_decks', $data);
        $record = $this->assertStandardGetOne($client);
        $this->assertEquals(
                "0.1", $record['version']
        );
        return $record;
    }

    /**
     * @depends testPostDeck
     */
    public function testPostLineage ($deck)
    {
        $id = $deck['id'];
        $data = [
            "name" => "The Bloodwoods Queen",
            "phoenixborn_code" => "jessa-na-ni",
            "description" => "Pre-built Deck for Jessa Na Ni",
            "tags" => "prebuilt",
            "cards" => [
                "blood-archer" => 3,
                "blood-transfer" => 3,
                "cut-the-string" => 3,
                "fear" => 3,
                "final-cry" => 3,
                "leech-warrior" => 3,
                "living-doll" => 3,
                "redirect" => 3,
                "summon-blood-puppet" => 3,
                "undying-heart" => 3,
            ],
            "dices" => [
                "ceremonial" => 4,
                "charm" => 6,
            ],
        ];
        $client = $this->getAuthenticatedClient();
        $this->sendJsonRequest($client, 'POST', "/api/v1/private_decks/$id/lineage", $data);
        $record = $this->assertStandardGetOne($client);
        $this->assertEquals(
                "0.2", $record['version']
        );
        return $record;
    }

    /**
     * @depends testPostLineage
     */
    public function testGetLineage ($deck)
    {
        $id = $deck['id'];
        $client = $this->getAuthenticatedClient();
        $client->request('GET', "/api/v1/private_decks/$id/lineage");
        $records = $this->assertStandardGetMany($client);
        $this->assertEquals(
                2, count($records)
        );
        return $records[0];
    }
    
    /**
     * @depends testGetLineage
     */
    public function testDeleteLineage($deck)
    {
        $id = $deck['id'];
        $client = $this->getAuthenticatedClient();
        $client->request('DELETE', "/api/v1/private_decks/$id/lineage");
        $this->assertEquals(
                Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
    }

}
