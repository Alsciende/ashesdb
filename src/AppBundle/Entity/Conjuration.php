<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Alsciende\SerializerBundle\Annotation\Source;
use JMS\Serializer\Annotation as JMS;

/**
 * The relation between a summoning source and its summoned unit

 * @ORM\Table(name="conjurations")
 * @ORM\Entity
 *
 * @Source
 * 
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessorOrder("alphabetical")
 * 
 * @author Alsciende <alsciende@icloud.com>
 */
class Conjuration
{
    
    use TimestampableEntity;

    /**
     * @var \AppBundle\Entity\Card
     * @Assert\NotBlank()
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Card", inversedBy="conjuring")
     * @ORM\JoinColumn(name="source_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $source;

    /**
     * @var \AppBundle\Entity\Card
     * @Assert\NotBlank()
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Card", inversedBy="conjuredBy")
     * @ORM\JoinColumn(name="unit_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $unit;
    
    function getSource ()
    {
        return $this->source;
    }

    /**
     * Code of the source of the conjuration
     * 
     * @JMS\VirtualProperty
     * @JMS\Type("string")
     * @return string
     */
    function getSourceCode ()
    {
        return $this->source ? $this->source->getCode() : null;
    }

    function getUnit ()
    {
        return $this->unit;
    }


    /**
     * Code of the conjured unit
     * 
     * @JMS\VirtualProperty
     * @JMS\Type("string")
     * @return string
     */
    function getUnitCode ()
    {
        return $this->unit ? $this->unit->getCode() : null;
    }

    function setSource (\AppBundle\Entity\Card $source)
    {
        $this->source = $source;
    }

    function setUnit (\AppBundle\Entity\Card $unit)
    {
        $this->unit = $unit;
    }


}
