<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Description of DeckDice
 *
 * @ORM\Table(name="deck_dices")
 * @ORM\Entity
 * 
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessorOrder("alphabetical")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DeckDice
{
    
    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     * 
     * @JMS\Expose
     */
    private $quantity;

    /**
     * @var \AppBundle\Entity\Deck
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Deck", inversedBy="deckDices")
     * @ORM\JoinColumn(name="deck_id", referencedColumnName="id")
     */
    private $deck;

    /**
     * @var \AppBundle\Entity\Dice
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Dice")
     * @ORM\JoinColumn(name="dice_code", referencedColumnName="code")
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

    /**
     * @JMS\VirtualProperty
     * @return string
     */
    function getDiceCode ()
    {
        return $this->dice ? $this->dice->getCode() : null;
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
