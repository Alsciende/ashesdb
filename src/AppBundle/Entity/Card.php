<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Alsciende\SerializerBundle\Annotation\Source;

/**
 * Card
 *
 * @ORM\Table(name="cards")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CardRepository")
 * 
 * @Source(break="code")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Card
{

    use TimestampableEntity;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * 
     * @Source(type="string")
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * 
     * @Source(type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="cost", type="string", nullable=true)
     * 
     * @Source(type="string")
     */
    private $cost;

    /**
     * @var string
     * @Assert\NotBlank()
     * 
     * @ORM\Column(name="type", type="string", nullable=false)
     * 
     * @Source(type="string")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     * 
     * @Source(type="string")
     */
    private $text;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_phoenixborn", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     */
    private $isPhoenixborn;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_unit", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     */
    private $isUnit;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_spell", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     */
    private $isSpell;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_conjured", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     */
    private $isConjured;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_spell_action", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     */
    private $isSpellAction;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_spell_alteration", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     */
    private $isSpellAlteration;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_spell_reactive", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     */
    private $isSpellReactive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_spell_ready", type="boolean", nullable=false)
     * 
     * @Source(type="boolean")
     */
    private $isSpellReady;

    /**
     * @var string
     *
     * @ORM\Column(name="placement", type="string", nullable=true)
     * 
     * @Source(type="string")
     */
    private $placement;

    /**
     * @var integer
     *
     * @ORM\Column(name="battlefield", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     */
    private $battlefield;

    /**
     * @var integer
     *
     * @ORM\Column(name="lifepool", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     */
    private $lifepool;

    /**
     * @var integer
     *
     * @ORM\Column(name="spellboard", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     */
    private $spellboard;

    /**
     * @var integer
     *
     * @ORM\Column(name="attack", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     */
    private $attack;

    /**
     * @var integer
     *
     * @ORM\Column(name="life", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     */
    private $life;

    /**
     * @var integer
     *
     * @ORM\Column(name="recover", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     */
    private $recover;

    /**
     * @var string
     *
     * @ORM\Column(name="attack_mod", type="string", nullable=true)
     * 
     * @Source(type="string")
     */
    private $attackMod;

    /**
     * @var string
     *
     * @ORM\Column(name="life_mod", type="string", nullable=true)
     * 
     * @Source(type="string")
     */
    private $lifeMod;

    /**
     * @var string
     *
     * @ORM\Column(name="recover_mod", type="string", nullable=true)
     * 
     * @Source(type="string")
     */
    private $recoverMod;

    /**
     * @var integer
     *
     * @ORM\Column(name="conjuration_limit", type="smallint", nullable=true)
     * 
     * @Source(type="integer")
     */
    private $conjurationLimit;

    function __construct ()
    {
        $this->cardDices = new \Doctrine\Common\Collections\ArrayCollection();
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

    
    /**
     * @var \AppBundle\Entity\Conjuration
     *
     * @ORM\OneToOne(targetEntity="Conjuration", mappedBy="source")
     */
    private $conjuring;
    
    /**
     * @var \AppBundle\Entity\Conjuration
     *
     * @ORM\OneToOne(targetEntity="Conjuration", mappedBy="unit")
     */
    private $conjuredBy;
    
    function getConjuring ()
    {
        return $this->conjuring;
    }

    function getConjuredBy ()
    {
        return $this->conjuredBy;
    }

    function setConjuring (\AppBundle\Entity\Conjuration $conjuring)
    {
        $this->conjuring = $conjuring;
    }

    function setConjuredBy (\AppBundle\Entity\Conjuration $conjuredBy)
    {
        $this->conjuredBy = $conjuredBy;
    }

    /**
     * @var CardDice[]
     * 
     * @ORM\OneToMany(targetEntity="CardDice", mappedBy="card", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $cardDices;

    function getCardDices (): array
    {
        return $this->cardDices;
    }

    function setCardDices (array $cardDices)
    {
        $this->cardDices = $cardDices;
    }

}
