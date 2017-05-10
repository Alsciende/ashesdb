<?php

namespace Tests\AppBundle\Controller\API\v1;

/**
 * Description of DeckCopyControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DeckCopyControllerTest extends \Tests\AppBundle\Controller\API\BaseApiControllerTest
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
                "cut-the-strings" => 3,
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
    public function testPostCopy ($deck)
    {
        $id = $deck['id'];
        $client = $this->getAuthenticatedClient();
        $client->request('POST', "/api/v1/private_decks/$id/copy");
        $record = $this->assertStandardGetOne($client);
        $this->assertEquals(
                "0.1", $record['version']
        );
        $this->assertArrayHasKey(
                "id", $record
        );
        $this->assertNotEquals(
                $record['lineage'], $deck['lineage']
        );
        $this->assertEquals(
                $record['genus'], $deck['genus']
        );
        return $record;
    }

}
