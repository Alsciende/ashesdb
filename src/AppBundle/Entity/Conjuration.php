<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alsciende\SerializerBundle\Annotation\Source;

/**
 * The relation between a summoning spell and its summoned unit

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
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Card", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="spell_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $spell;

    /**
     * @var \AppBundle\Entity\Card
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Card", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="unit_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $unit;
    
    function getSpell ()
    {
        return $this->spell;
    }

    function getUnit ()
    {
        return $this->unit;
    }

    function setSpell (\AppBundle\Entity\Card $spell)
    {
        $this->spell = $spell;
    }

    function setUnit (\AppBundle\Entity\Card $unit)
    {
        $this->unit = $unit;
    }


}
