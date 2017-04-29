<?php

namespace AppBundle\Entity;

use AppBundle\Model\CardSlotCollection;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Alsciende\SerializerBundle\Annotation\Source;

/**
 * Pack
 *
 * @ORM\Table(name="packs")
 * @ORM\Entity
 * 
 * @Source
 * 
 * @author Alsciende <alsciende@icloud.com>
 */
class Pack
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * 
     * @Source(type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     * 
     * @Source(type="integer")
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer", nullable=true)
     * 
     * @Source(type="integer")
     */
    private $size;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="released_at", type="datetime", nullable=true)
     * 
     * @Source(type="date")
     */
    private $releasedAt;

    /**
     * @var Cycle
     *
     * @ORM\ManyToOne(targetEntity="Cycle")
     * @ORM\JoinColumn(name="cycle_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $cycle;

    /**
     * @var PackSlot[]
     * 
     * @ORM\OneToMany(targetEntity="PackSlot", mappedBy="pack", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $slots;

    function __construct ()
    {
        $this->cards = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Pack
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
     * @return Pack
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

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Pack
     */
    public function setPosition ($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition ()
    {
        return $this->position;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Pack
     */
    public function setSize ($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return int
     */
    public function getSize ()
    {
        return $this->size;
    }
    
    /**
     * 
     * @return DateTime
     */
    function getReleasedAt ()
    {
        return $this->releasedAt;
    }

    /**
     * 
     * @param DateTime $releaseAt
     */
    function setReleasedAt (DateTime $releaseAt)
    {
        $this->releasedAt = $releasedAt;
        
        return $this;
    }

    /**
     * Get cycle
     * 
     * @return Cycle
     */
    function getCycle ()
    {
        return $this->cycle;
    }

    /**
     * Set cycle
     * 
     * @param Cycle $cycle
     * 
     * @return Pack
     */
    function setCycle (Cycle $cycle)
    {
        $this->cycle = $cycle;

        return $this;
    }

}
