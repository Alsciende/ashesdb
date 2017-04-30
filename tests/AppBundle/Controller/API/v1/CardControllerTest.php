<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of CardControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CardControllerTest extends BaseApiControllerTest
{

    public function testGetCards ()
    {
        $client = $this->getAnonymousClient();
        $client->request('GET', "/api/v1/cards");
        $this->assertStandardGetMany($client);
    }

    public function testGetCardPhoenixborn ()
    {
        $client = $this->getAnonymousClient();
        $client->request('GET', "/api/v1/cards/rin-northfell");
        $card = $this->assertStandardGetOne($client);
        $this->assertEquals(
                [
            "battlefield" => 6,
            "code" => "rin-northfell",
            "dices" => [],
            "exclusives" => [
                [
                    "card_code" => "ice-buff",
                    "phoenixborn_code" => "rin-northfell"
                ],
                [
                    "card_code" => "rin-s-fury",
                    "phoenixborn_code" => "rin-northfell"
                ]
            ],
            "is_conjured" => false,
            "is_phoenixborn" => true,
            "is_spell" => false,
            "is_spell_action" => false,
            "is_spell_alteration" => false,
            "is_spell_reactive" => false,
            "is_spell_ready" => false,
            "is_unit" => false,
            "lifepool" => 17,
            "name" => "Rin Northfell",
            "spellboard" => 4,
            "text" => "<b>Ice Buff</b>: <i>[side-action] [exhaustion]</i>: Attach an Ice Buff conjured alteration spell to a target unit you control.",
            "type" => "Phoenixborn",
                ], $card
        );
    }

    public function testGetCardUnit ()
    {
        $client = $this->getAnonymousClient();
        $client->request('GET', "/api/v1/cards/blue-jaguar");
        $card = $this->assertStandardGetOne($client);
        $this->assertEquals(
                [
            "attack" => 2,
            "code" => "blue-jaguar",
            "conjuration_limit" => 5,
            "conjured_by" => [
                "source_code" => "summon-blue-jaguar",
                "unit_code" => "blue-jaguar"
            ],
            "dices" => [],
            "exclusive_to" => [
                "card_code" => "blue-jaguar",
                "phoenixborn_code" => "aradel-summergaard"
            ],
            "exclusives" => [],
            "is_conjured" => true,
            "is_phoenixborn" => false,
            "is_spell" => false,
            "is_spell_action" => false,
            "is_spell_alteration" => false,
            "is_spell_reactive" => false,
            "is_spell_ready" => false,
            "is_unit" => true,
            "life" => 2,
            "name" => "Blue Jaguar",
            "placement" => "Battlefield",
            "recover" => 0,
            "text" => "<b>Gaze 1</b>: After a unit comes into play on an opponent's battlefield, you may spend 1[basic] to place 1 exhaustion token on that unit.",
            "type" => "Conjuration"
                ], $card
        );
    }

    public function testGetCardSpell ()
    {
        $client = $this->getAnonymousClient();
        $client->request('GET', "/api/v1/cards/golden-veil");
        $card = $this->assertStandardGetOne($client);
        $this->assertEquals(
                [
            "code" => "golden-veil",
            "cost" => "1[natural-class] 1[charm-class]",
            "dices" => [
                "charm" => 1,
                "natural" => 1,
            ],
            "exclusives" => [],
            "is_conjured" => false,
            "is_phoenixborn" => false,
            "is_spell" => true,
            "is_spell_action" => false,
            "is_spell_alteration" => false,
            "is_spell_reactive" => false,
            "is_spell_ready" => false,
            "is_unit" => false,
            "name" => "Golden Veil",
            "placement" => "Discard",
            "text" => "You may play this spell when an opponent uses a spell, ability or dice power that would target a unit you control. Cancel the effects of that spell, ability or dice power.",
            "type" => "Reaction Spell"
                ], $card
        );
    }

}
