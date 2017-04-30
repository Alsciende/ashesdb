<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Alsciende\SerializerBundle\Annotation\Source;
use JMS\Serializer\Annotation as JMS;

/**
 * The relation between a Phoenixborn and her unique cards

 * @ORM\Table(name="exclusives")
 * @ORM\Entity
 * 
 * @Source
 * 
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessorOrder("alphabetical")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Exclusive
{

    use TimestampableEntity;

    /**
     * @var \AppBundle\Entity\Card
     * @Assert\NotBlank()
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Card", inversedBy="exclusives")
     * @ORM\JoinColumn(name="phoenixborn_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $phoenixborn;

    /**
     * @var \AppBundle\Entity\Card
     * @Assert\NotBlank()
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Card", inversedBy="exclusiveTo")
     * @ORM\JoinColumn(name="card_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $card;
    
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
    function getCard ()
    {
        return $this->card;
    }

    /**
     * @JMS\VirtualProperty
     * @return string
     */
    function getCardCode ()
    {
        return $this->card ? $this->card->getCode() : null;
    }
    
    function setPhoenixborn (\AppBundle\Entity\Card $phoenixborn)
    {
        $this->phoenixborn = $phoenixborn;
    }

    function setCard (\AppBundle\Entity\Card $card)
    {
        $this->card = $card;
    }

}
