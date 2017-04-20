<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Alsciende\SerializerBundle\Annotation\Source;

/**
 * The relation between a summoning source and its summoned unit

 * @ORM\Table(name="conjurations")
 * @ORM\Entity
 *
 * @Source
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
     * @ORM\OneToOne(targetEntity="Card", inversedBy="conjuring", fetch="EAGER")
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
     * @ORM\OneToOne(targetEntity="Card", inversedBy="conjuredBy", fetch="EAGER")
     * @ORM\JoinColumn(name="unit_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $unit;
    
    function getSource ()
    {
        return $this->source;
    }

    function getUnit ()
    {
        return $this->unit;
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
