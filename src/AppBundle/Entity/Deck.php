<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * Description of Deck

 * @ORM\Table(name="decks")
 * @ORM\Entity
 * 
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessorOrder("alphabetical")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Deck
{

    use TimestampableEntity;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * 
     * @JMS\Expose
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * 
     * @JMS\Expose
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * 
     * @JMS\Expose
     */
    private $description;

    /**
     * @var DeckSlot[]
     * 
     * @ORM\OneToMany(targetEntity="DeckSlot", mappedBy="deck", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $deckSlots;
    
    /**
     * @var DeckDice[]
     * 
     * @ORM\OneToMany(targetEntity="DeckDice", mappedBy="deck", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $deckDices;
    
    /**
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    

    function __construct ()
    {
        $this->deckSlots = new \AppBundle\Model\CardSlotCollection();
        $this->deckDices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getId ()
    {
        return $this->id;
    }

    function getName ()
    {
        return $this->name;
    }

    function setName ($name)
    {
        $this->name = $name;
    }
    function getDeckSlots ()
    {
        return $this->deckSlots;
    }

    function setDeckSlots (array $deckSlots)
    {
        $this->deckSlots = $deckSlots;
    }
    
    function getDeckDices ()
    {
        return $this->deckDices;
    }

    function setDeckDices (array $deckDices)
    {
        $this->deckDices = $deckDices;
    }


    function getUser ()
    {
        return $this->user;
    }

    function setUser (User $user)
    {
        $this->user = $user;
    }
    
    function getDescription ()
    {
        return $this->description;
    }

    function setDescription ($description)
    {
        $this->description = $description;
    }



}
