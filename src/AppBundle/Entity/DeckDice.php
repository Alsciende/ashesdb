<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alsciende\SerializerBundle\Annotation\Source;

/**
 * Description of DeckDice
 *
 * @ORM\Table(name="deck_dices")
 * @ORM\Entity
 * 
 * @Source
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DeckDice
{
    
    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var \AppBundle\Entity\Deck
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Deck", inversedBy="deckDices")
     * @ORM\JoinColumn(name="deck_id", referencedColumnName="id")
     * 
     * @Source(type="association")
     */
    private $deck;

    /**
     * @var \AppBundle\Entity\Dice
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Dice")
     * @ORM\JoinColumn(name="dice_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $dice;

    public function __construct (Deck $deck, Dice $dice, int $quantity)
    {
        $this->deck = $deck;
        $this->dice = $dice;
        $this->quantity = $quantity;
    }

    function getQuantity ()
    {
        return $this->quantity;
    }

    function getDeck ()
    {
        return $this->deck;
    }

    function getDice ()
    {
        return $this->dice;
    }

    function setQuantity ($quantity)
    {
        $this->quantity = $quantity;
    }

    function setDeck (\AppBundle\Entity\Deck $deck)
    {
        $this->deck = $deck;
    }

    function setDice (\AppBundle\Entity\Dice $dice)
    {
        $this->dice = $dice;
    }

}
