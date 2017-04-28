<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Alsciende\SerializerBundle\Annotation\Source;

/**
 * Description of Deck

 * @ORM\Table(name="decks")
 * @ORM\Entity
 *
 * @Source
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
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * 
     * @Source(type="string")
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * 
     * @Source(type="string")
     */
    private $description;

    /**
     * @var DeckSlots[]
     * 
     * @ORM\OneToMany(targetEntity="DeckSlot", mappedBy="deck", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $slots;
    
    /**
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    

    function __construct ()
    {
        $this->slots = new \AppBundle\Model\CardSlotCollection();
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

    function getSlots ()
    {
        return $this->slots;
    }

    function setDescription ($description)
    {
        $this->description = $description;
    }

    function setSlots (array $slots)
    {
        $this->slots = $slots;
    }



}
