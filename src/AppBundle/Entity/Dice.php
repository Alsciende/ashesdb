<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Traits\TimestampableEntity;
use Alsciende\SerializerBundle\Annotation\Source;
use JMS\Serializer\Annotation as JMS;

/**
 * Dice
 *
 * @ORM\Table(name="dices")
 * @ORM\Entity
 * 
 * @Source
 * 
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessorOrder("alphabetical")
 * 
 * @author Alsciende <alsciende@icloud.com>
 */
class Dice implements \AppBundle\Model\SlotElementInterface
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
     * Set code
     *
     * @param string $code
     *
     * @return Dice
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
     * @return Dice
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
    
}
