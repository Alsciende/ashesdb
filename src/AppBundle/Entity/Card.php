<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Alsciende\SerializerBundle\Annotation\Source;
use JMS\Serializer\Annotation as JMS;

/**
 * Card
 *
 * @ORM\Table(name="cards")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CardRepository")
 * 
 * @Source(break="code")
 * 
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessorOrder("alphabetical")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Card implements \AppBundle\Model\SlotElementInterface
{

    use TimestampableEntity;

    /**
     * Unique code of the card
     * 
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $code;

    /**
     * Title of the card
     * 
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $name;

    /**
     * Cost of the card, in plain text
     * 
     * @var string
     *
     * @ORM\Column(name="cost", type="string", nullable=true)
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $cost;

    /**
     * Type of the card, in plain text
     * 
     * @var string
     * @Assert\NotBlank()
     * 
     * @ORM\Column(name="type", type="string", nullable=false)
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $type;

    /**
     * Text of the card
     * 
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $text;

    /**
     * Is it a phoenixborn?
     * 
     * @var boolean
     *
     * @ORM\Column(name="is_phoenixborn", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     * 
     * @JMS\Expose
     */
    private $isPhoenixborn;

    /**
     * Is it a unit?
     * 
     * @var boolean
     *
     * @ORM\Column(name="is_unit", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     * 
     * @JMS\Expose
     */
    private $isUnit;

    /**
     * Is it a spell?
     * 
     * @var boolean
     *
     * @ORM\Column(name="is_spell", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     * 
     * @JMS\Expose
     */
    private $isSpell;

    /**
     * Is it a conjured card?
     * 
     * @var boolean
     *
     * @ORM\Column(name="is_conjured", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     * 
     * @JMS\Expose
     */
    private $isConjured;

    /**
     * Is it an action spell?
     * 
     * @var boolean
     *
     * @ORM\Column(name="is_spell_action", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     * 
     * @JMS\Expose
     */
    private $isSpellAction;

    /**
     * Is it an alteration spell?
     * 
     * @var boolean
     *
     * @ORM\Column(name="is_spell_alteration", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     * 
     * @JMS\Expose
     */
    private $isSpellAlteration;

    /**
     * Is it a reactive spell?
     * 
     * @var boolean
     *
     * @ORM\Column(name="is_spell_reactive", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     * 
     * @JMS\Expose
     */
    private $isSpellReactive;

    /**
     * Is it a ready spell?
     * 
     * @var boolean
     *
     * @ORM\Column(name="is_spell_ready", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     * 
     * @JMS\Expose
     */
    private $isSpellReady;

    /**
     * Where does the card go once played
     * 
     * @var string
     *
     * @ORM\Column(name="placement", type="string", nullable=true)
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $placement;

    /**
     * Battlefield attribute of a phoenixborn
     * 
     * @var integer
     *
     * @ORM\Column(name="battlefield", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     * 
     * @JMS\Expose
     */
    private $battlefield;

    /**
     * Lifepool attribute of a phoenixborn
     * 
     * @var integer
     *
     * @ORM\Column(name="lifepool", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     * 
     * @JMS\Expose
     */
    private $lifepool;

    /**
     * Spellboard attribute of a phoenixborn
     * 
     * @var integer
     *
     * @ORM\Column(name="spellboard", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     * 
     * @JMS\Expose
     */
    private $spellboard;

    /**
     * Attack attribute of a unit
     * @var integer
     *
     * @ORM\Column(name="attack", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     * 
     * @JMS\Expose
     */
    private $attack;

    /**
     * Life attribute of a unit
     * 
     * @var integer
     *
     * @ORM\Column(name="life", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     * 
     * @JMS\Expose
     */
    private $life;

    /**
     * Recover attribute of a unit
     * 
     * @var integer
     *
     * @ORM\Column(name="recover", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     * 
     * @JMS\Expose
     */
    private $recover;

    /**
     * Attack Modifier attribute of an alteration spell
     * 
     * @var string
     *
     * @ORM\Column(name="attack_mod", type="string", nullable=true)
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $attackMod;

    /**
     * Life Modifier attribute of an alteration spell
     * 
     * @var string
     *
     * @ORM\Column(name="life_mod", type="string", nullable=true)
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $lifeMod;

    /**
     * Recover Modifier attribute of an alteration spell
     * 
     * @var string
     *
     * @ORM\Column(name="recover_mod", type="string", nullable=true)
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $recoverMod;

    /**
     * Conjuration limit of a conjured card
     * 
     * @var integer
     *
     * @ORM\Column(name="conjuration_limit", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     * 
     * @JMS\Expose
     */
    private $conjurationLimit;

    /**
     * What conjuration is the card conjuring
     * 
     * @var Conjuration
     *
     * @ORM\OneToOne(targetEntity="Conjuration", mappedBy="source")
     * 
     * @JMS\Expose
     */
    private $conjuring;

    /**
     * What is the card that is conjuring this card
     * 
     * @var Conjuration
     *
     * @ORM\OneToOne(targetEntity="Conjuration", mappedBy="unit")
     * 
     * @JMS\Expose
     */
    private $conjuredBy;

    /**
     * What cards are exclusive to this phoenixborn
     * 
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Exclusive", mappedBy="phoenixborn", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     * 
     * @JMS\Expose
     */
    private $exclusives;

    /**
     * What phoenixborn is this card exclusive to
     * 
     * @var Exclusive
     *
     * @ORM\OneToOne(targetEntity="Exclusive", mappedBy="card")
     * 
     * @JMS\Expose
     */
    private $exclusiveTo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="CardDice", mappedBy="card", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $cardDices;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="PackCard", mappedBy="card", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $packCards;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Review", mappedBy="card", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $reviews;
    
    /**
     *
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Ruling", mappedBy="card", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $rulings;
    
    
    function __construct ()
    {
        $this->cardDices = new ArrayCollection();
        $this->packCards = new ArrayCollection();
        $this->exclusives = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->rulings = new ArrayCollection();
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Card
     */
    public function setCode ($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode ()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Card
     */
    public function setName ($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName ()
    {
        return $this->name;
    }

    function getCost ()
    {
        return $this->cost;
    }

    function getType ()
    {
        return $this->type;
    }

    function getText ()
    {
        return $this->text;
    }

    function getIsPhoenixborn ()
    {
        return $this->isPhoenixborn;
    }

    function getIsUnit ()
    {
        return $this->isUnit;
    }

    function getIsSpell ()
    {
        return $this->isSpell;
    }

    function getIsConjured ()
    {
        return $this->isConjured;
    }

    function getIsSpellAction ()
    {
        return $this->isSpellAction;
    }

    function getIsSpellAlteration ()
    {
        return $this->isSpellAlteration;
    }

    function getIsSpellReactive ()
    {
        return $this->isSpellReactive;
    }

    function getIsSpellReady ()
    {
        return $this->isSpellReady;
    }

    function getPlacement ()
    {
        return $this->placement;
    }

    function getBattlefield ()
    {
        return $this->battlefield;
    }

    function getLife ()
    {
        return $this->life;
    }

    function getSpellboard ()
    {
        return $this->spellboard;
    }

    function getAttack ()
    {
        return $this->attack;
    }

    function getRecover ()
    {
        return $this->recover;
    }

    function getConjurationLimit ()
    {
        return $this->conjurationLimit;
    }

    function setCost ($cost)
    {
        $this->cost = $cost;
    }

    function setType ($type)
    {
        $this->type = $type;
    }

    function setText ($text)
    {
        $this->text = $text;
    }

    function setIsPhoenixborn ($isPhoenixborn)
    {
        $this->isPhoenixborn = $isPhoenixborn;
    }

    function setIsUnit ($isUnit)
    {
        $this->isUnit = $isUnit;
    }

    function setIsSpell ($isSpell)
    {
        $this->isSpell = $isSpell;
    }

    function setIsConjured ($isConjured)
    {
        $this->isConjured = $isConjured;
    }

    function setIsSpellAction ($isSpellAction)
    {
        $this->isSpellAction = $isSpellAction;
    }

    function setIsSpellAlteration ($isSpellAlteration)
    {
        $this->isSpellAlteration = $isSpellAlteration;
    }

    function setIsSpellReactive ($isSpellReactive)
    {
        $this->isSpellReactive = $isSpellReactive;
    }

    function setIsSpellReady ($isSpellReady)
    {
        $this->isSpellReady = $isSpellReady;
    }

    function setPlacement ($placement)
    {
        $this->placement = $placement;
    }

    function setBattlefield ($battlefield)
    {
        $this->battlefield = $battlefield;
    }

    function setLife ($life)
    {
        $this->life = $life;
    }

    function setSpellboard ($spellboard)
    {
        $this->spellboard = $spellboard;
    }

    function setAttack ($attack)
    {
        $this->attack = $attack;
    }

    function setRecover ($recover)
    {
        $this->recover = $recover;
    }

    function setConjurationLimit ($conjurationLimit)
    {
        $this->conjurationLimit = $conjurationLimit;
    }

    function getLifepool ()
    {
        return $this->lifepool;
    }

    function getAttackMod ()
    {
        return $this->attackMod;
    }

    function getLifeMod ()
    {
        return $this->lifeMod;
    }

    function getRecoverMod ()
    {
        return $this->recoverMod;
    }

    function setLifepool ($lifepool)
    {
        $this->lifepool = $lifepool;
    }

    function setAttackMod ($attackMod)
    {
        $this->attackMod = $attackMod;
    }

    function setLifeMod ($lifeMod)
    {
        $this->lifeMod = $lifeMod;
    }

    function setRecoverMod ($recoverMod)
    {
        $this->recoverMod = $recoverMod;
    }

    function getConjuring ()
    {
        return $this->conjuring;
    }

    function getConjuredBy ()
    {
        return $this->conjuredBy;
    }

    function setConjuring (Conjuration $conjuring)
    {
        $this->conjuring = $conjuring;
    }

    function setConjuredBy (Conjuration $conjuredBy)
    {
        $this->conjuredBy = $conjuredBy;
    }

    /**
     * 
     * @return \AppBundle\Model\DiceSlotCollectionDecorator
     */
    function getCardDices ()
    {
        return new \AppBundle\Model\DiceSlotCollectionDecorator($this->cardDices->toArray());
    }

    /**
     * 
     * @param \AppBundle\Entity\CardDice $cardDice
     * @return Card
     */
    function addCardDice (CardDice $cardDice)
    {
        $this->cardDices[] = $cardDice;
        
        return $this;
    }

    /**
     * 
     * @return \AppBundle\Model\PackCardSlotCollectionDecorator
     */
    function getPackCards ()
    {
        return new \AppBundle\Model\PackCardSlotCollectionDecorator($this->packCards->toArray());
    }

    /**
     * 
     * @param \AppBundle\Entity\PackCard $packCard
     * @return Card
     */
    function addPackCard (PackCard $packCard)
    {
        $this->packCards[] = $packCard;
        
        return $this;
    }

    /**
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    function getExclusives ()
    {
        return $this->exclusives;
    }

    /**
     * 
     * @return Exclusive
     */
    function getExclusiveTo ()
    {
        return $this->exclusiveTo;
    }

    /**
     * 
     * @param \AppBundle\Entity\Exclusive $exclusive
     * @return Card
     */
    function addExclusive (Exclusive $exclusive)
    {
        $this->exclusives[] = $exclusive;
        
        return $this;
    }

    /**
     * 
     * @param \AppBundle\Entity\Exclusive $exclusiveTo
     * @return Card
     */
    function setExclusiveTo (Exclusive $exclusiveTo)
    {
        $this->exclusiveTo = $exclusiveTo;
        
        return $this;
    }
    
    /**
     * Dices used by the card
     * 
     * @JMS\VirtualProperty
     * @JMS\Type("array")
     * @return array
     */
    function getDices()
    {
        return $this->getCardDices()->getContent();
    }
    
    /**
     * Packs including the card
     * 
     * @JMS\VirtualProperty
     * @JMS\Type("array")
     * @return array
     */
    function getPacks()
    {
        return $this->getPackCards()->getQuantities();
    }
    
    /**
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    function getReviews (): \Doctrine\Common\Collections\Collection
    {
        return $this->reviews;
    }

    /**
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    function getRulings (): \Doctrine\Common\Collections\Collection
    {
        return $this->rulings;
    }

    /**
     * 
     * @param \Doctrine\Common\Collections\Collection $reviews
     * @return Card
     */
    function setReviews (\Doctrine\Common\Collections\Collection $reviews)
    {
        $this->reviews = $reviews;
        return $this;
    }

    /**
     * 
     * @param \Doctrine\Common\Collections\Collection $rulings
     * @return Card
     */
    function setRulings (\Doctrine\Common\Collections\Collection $rulings)
    {
        $this->rulings = $rulings;
        return $this;
    }


}
