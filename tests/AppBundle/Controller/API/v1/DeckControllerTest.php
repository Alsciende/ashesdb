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
                11, count($record['cards'])
        );
        $this->assertEquals(
                "0.1", $record['version']
        );
        $this->assertEquals(
                0, $record['problem']
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

    public function postDeckProblem ($cards, $dices, $problem)
    {
        $data = [
            "name" => "Test Deck",
            "description" => "This is the description",
            "tags" => "test,deck",
            "cards" => $cards,
            "dices" => $dices,
        ];

        $client = $this->getAuthenticatedClient();
        $client->request('POST', '/api/v1/decks', $data);
        $record = $this->assertStandardGetOne($client);
        $this->assertEquals(
                $problem, $record['problem']
        );
    }

    public function testPostDeckProblem1 ()
    {
        $cards = $this->getDeckCards();
        unset($cards['jessa-na-ni']);
        $dices = $this->getDeckDices();

        $this->postDeckProblem($cards, $dices, \AppBundle\Service\DeckChecker::TOO_FEW_PHOENIXBORNS);
    }

    public function testPostDeckProblem2 ()
    {
        $cards = $this->getDeckCards();
        $cards['coal-roarkwin'] = 1;
        $dices = $this->getDeckDices();

        $this->postDeckProblem($cards, $dices, \AppBundle\Service\DeckChecker::TOO_MANY_PHOENIXBORNS);
    }

    public function testPostDeckProblem3 ()
    {
        $cards = $this->getDeckCards();
        $cards['blood-archer'] = 2;
        $dices = $this->getDeckDices();

        $this->postDeckProblem($cards, $dices, \AppBundle\Service\DeckChecker::TOO_FEW_CARDS);
    }

    public function testPostDeckProblem4 ()
    {
        $cards = $this->getDeckCards();
        $cards['amplify'] = 1;
        $dices = $this->getDeckDices();

        $this->postDeckProblem($cards, $dices, \AppBundle\Service\DeckChecker::TOO_MANY_CARDS);
    }

    public function testPostDeckProblem5 ()
    {
        $cards = $this->getDeckCards();
        $cards['blood-archer'] = 4;
        $cards['blood-transfer'] = 2;
        $dices = $this->getDeckDices();

        $this->postDeckProblem($cards, $dices, \AppBundle\Service\DeckChecker::TOO_MANY_COPIES);
    }

    public function testPostDeckProblem6 ()
    {
        $cards = $this->getDeckCards();
        $cards['summon-blood-puppet'] = 2;
        $cards['blood-puppet'] = 1;
        $dices = $this->getDeckDices();

        $this->postDeckProblem($cards, $dices, \AppBundle\Service\DeckChecker::INCLUDES_CONJURATION);
    }

    public function testPostDeckProblem7 ()
    {
        $cards = $this->getDeckCards();
        $cards['summon-blood-puppet'] = 2;
        $cards['summon-blue-jaguar'] = 1;
        $dices = $this->getDeckDices();

        $this->postDeckProblem($cards, $dices, \AppBundle\Service\DeckChecker::FORBIDDEN_EXCLUSIVE);
    }
    
    public function testPostDeckProblem8 ()
    {
        $cards = $this->getDeckCards();
        $dices = $this->getDeckDices();
        $dices['charm'] = 4;
        
        $this->postDeckProblem($cards, $dices, \AppBundle\Service\DeckChecker::TOO_FEW_DICES);
    }
    
    public function testPostDeckProblem9 ()
    {
        $cards = $this->getDeckCards();
        $dices = $this->getDeckDices();
        $dices['charm'] = 6;
        
        $this->postDeckProblem($cards, $dices, \AppBundle\Service\DeckChecker::TOO_MANY_DICES);
    }
}
