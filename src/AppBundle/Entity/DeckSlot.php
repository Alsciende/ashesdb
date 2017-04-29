<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alsciende\SerializerBundle\Annotation\Source;

/**
 * Description of DeckSlot
 *
 * @ORM\Table(name="deck_slots")
 * @ORM\Entity
 * 
 * @author Alsciende <alsciende@icloud.com>
 */
class DeckSlot implements \AppBundle\Model\CardSlotInterface
{

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var \AppBundle\Entity\Card
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Card")
     * @ORM\JoinColumn(name="card_code", referencedColumnName="code")
     */
    private $card;

    /**
     * @var \AppBundle\Entity\Deck
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Deck", inversedBy="deckSlots")
     * @ORM\JoinColumn(name="deck_id", referencedColumnName="id")
     */
    private $deck;
    
    public function __construct (Deck $deck, Card $card, int $quantity)
    {
        $this->deck = $deck;
        $this->card = $card;
        $this->quantity = $quantity;
    }

    function getQuantity ()
    {
        return $this->quantity;
    }

    function getCard ()
    {
        return $this->card;
    }

    function getDeck ()
    {
        return $this->deck;
    }

    function setQuantity ($quantity)
    {
        $this->quantity = $quantity;
    }

    function setCard (\AppBundle\Entity\Card $card)
    {
        $this->card = $card;
    }

    function setDeck (\AppBundle\Entity\Deck $deck)
    {
        $this->deck = $deck;
    }

}
