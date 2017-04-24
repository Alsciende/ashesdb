<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
    
    /**
     * @var \AppBundle\Entity\Card
     * @Assert\NotBlank()
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Card", fetch="EXTRA_LAZY")
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
     * @ORM\OneToOne(targetEntity="Card", fetch="EXTRA_LAZY")
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
