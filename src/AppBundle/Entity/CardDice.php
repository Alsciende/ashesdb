<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Alsciende\SerializerBundle\Annotation\Source;
use JMS\Serializer\Annotation as JMS;

/**
 * Description of CardDice
 *
 * @ORM\Table(name="card_dices")
 * @ORM\Entity
 * 
 * @Source
 * 
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessorOrder("alphabetical")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CardDice
{
    
    use TimestampableEntity;

    /**
     * @var \AppBundle\Entity\Card
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Card", inversedBy="cardDices")
     * @ORM\JoinColumn(name="card_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $card;

    /**
     * @var \AppBundle\Entity\Dice
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Dice")
     * @ORM\JoinColumn(name="dice_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     * 
     */
    private $dice;

    function getCard ()
    {
        return $this->card;
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

    function setCard (\AppBundle\Entity\Card $card)
    {
        $this->card = $card;
    }

    function setDice (\AppBundle\Entity\Dice $dice)
    {
        $this->dice = $dice;
    }

    
}
