<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * A Deck, private (minorVersion > 0) or public (minorVersion == 0)

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
     * @var Card
     * 
     * @ORM\ManyToOne(targetEntity="Card")
     * @ORM\JoinColumn(name="phoenixborn_code", referencedColumnName="code")
     */
    private $phoenixborn;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="DeckCard", mappedBy="deck", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $deckCards;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
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
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="major_version", type="integer", nullable=false)
     */
    private $majorVersion;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="minor_version", type="integer", nullable=false)
     */
    private $minorVersion;
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="is_published", type="boolean", nullable=false)
     */
    private $isPublished;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="problem", type="integer", nullable=false)
     * 
     * @JMS\Expose
     */
    private $problem;

    
    
    function __construct ()
    {
        $this->deckCards = new \Doctrine\Common\Collections\ArrayCollection();
        $this->deckDices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->majorVersion = 0;
        $this->minorVersion = 1;
        $this->isPublished = FALSE;
        $this->problem = \AppBundle\Service\DeckChecker::VALID_DECK;
    }
    
    

    /**
     * 
     * @return string
     */
    function getId ()
    {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    function getName ()
    {
        return $this->name;
    }

    /**
     * 
     * @param string $name
     * @return Deck
     */
    function setName ($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * 
     * @return Card
     */
    function getPhoenixborn ()
    {
        return $this->phoenixborn;
    }

    /**
     * @JMS\VirtualProperty
     * @return string
     */
    function getPhoenixbornCode ()
    {
        return $this->phoenixborn ? $this->phoenixborn->getCode() : null;
    }
    
    /**
     * 
     * @param \AppBundle\Entity\Card $phoenixborn
     * @return Deck
     */
    function setPhoenixborn (Card $phoenixborn)
    {
        $this->phoenixborn = $phoenixborn;
        
        return $this;
    }

        /**
     * 
     * @return \AppBundle\Model\CardSlotCollectionDecorator
     */
    function getDeckCards ()
    {
        return new \AppBundle\Model\CardSlotCollectionDecorator($this->deckCards->toArray());
    }

    /**
     * 
     * @param \AppBundle\Entity\DeckCard $deckCard
     * @return Deck
     */
    function addDeckCard (DeckCard $deckCard)
    {
        $this->deckCards[] = $deckCard;
        
        return $this;
    }
    
    /**
     * 
     * @return DeckDice[]
     */
    function getDeckDices ()
    {
        return new \AppBundle\Model\DiceSlotCollectionDecorator($this->deckDices->toArray());
    }

    /**
     * 
     * @param \AppBundle\Entity\DeckDice $deckDice
     * @return Deck
     */
    function addDeckDice (DeckDice $deckDice)
    {
        $this->deckDices[] = $deckDice;
        
        return $this;
    }

    /**
     * 
     * @return User
     */
    function getUser ()
    {
        return $this->user;
    }
    
    /**
     * @JMS\VirtualProperty
     * @return string
     */
    function getUserId()
    {
        return $this->user ? $this->user->getId() : null;
    }

    /**
     * 
     * @param \AppBundle\Entity\User $user
     * @return Deck
     */
    function setUser (User $user)
    {
        $this->user = $user;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    function getDescription ()
    {
        return $this->description;
    }

    /**
     * 
     * @param string $description
     * @return Deck
     */
    function setDescription ($description)
    {
        $this->description = $description;
        
        return $this;
    }

    /**
     * 
     * @return integer
     */
    function getMajorVersion ()
    {
        return $this->majorVersion;
    }

    /**
     * 
     * @return integer
     */
    function getMinorVersion ()
    {
        return $this->minorVersion;
    }

    /**
     * 
     * @param integer $majorVersion
     * @return Deck
     */
    function setMajorVersion ($majorVersion)
    {
        $this->majorVersion = $majorVersion;
        
        return $this;
    }

    /**
     * 
     * @param integer $minorVersion
     * @return Deck
     */
    function setMinorVersion ($minorVersion)
    {
        $this->minorVersion = $minorVersion;
        
        return $this;
    }

    /**
     * @JMS\VirtualProperty
     * @return string
     */
    function getVersion ()
    {
        return $this->majorVersion . "." . $this->minorVersion;
    }

    /**
     * 
     * @return boolean
     */
    function getIsPublished ()
    {
        return $this->isPublished;
    }

    /**
     * 
     * @param boolean $isPublished
     * @return Deck
     */
    function setIsPublished ($isPublished)
    {
        $this->isPublished = $isPublished;
        
        return $this;
    }

    /**
     * @JMS\VirtualProperty
     * @return array
     */
    function getCards()
    {
        return $this->getDeckCards()->getContent();
    }

    /**
     * @JMS\VirtualProperty
     * @return array
     */
    function getDices()
    {
        return $this->getDeckDices()->getContent();
    }

    /**
     * 
     * @return integer
     */
    function getProblem ()
    {
        return $this->problem;
    }

    /**
     * 
     * @param integer $problem
     * @return Deck
     */
    function setProblem ($problem)
    {
        $this->problem = $problem;
        
        return $this;
    }


}
