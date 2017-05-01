<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Traits\TimestampableEntity;
use Alsciende\SerializerBundle\Annotation\Source;
use JMS\Serializer\Annotation as JMS;

/**
 * Cycle
 *
 * @ORM\Table(name="cycles")
 * @ORM\Entity
 * 
 * @Source
 * 
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessorOrder("alphabetical")
 * 
 * @author Alsciende <alsciende@icloud.com>
 */
class Cycle
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
     * 
     * @JMS\Expose
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * 
     * @Source(type="string")
     * 
     * @JMS\Expose
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     * 
     * @Source(type="integer")
     * 
     * @JMS\Expose
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer", nullable=true)
     * 
     * @Source(type="integer")
     * 
     * @JMS\Expose
     */
    private $size;

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Cycle
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
     * @return Cycle
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
     * @return Cycle
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
     * @return Cycle
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

}
