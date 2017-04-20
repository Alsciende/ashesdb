<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Alsciende\SerializerBundle\Annotation\Source;

/**
 * The relation between a Phoenixborn and her unique cards

 * @ORM\Table(name="unique_cards")
 * @ORM\Entity
 * 
 * @Source
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class UniqueCard
{

    /**
     * @var \AppBundle\Entity\Card
     * @Assert\NotBlank()
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Card", fetch="EXTRA_LAZY")
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
     * @ORM\OneToOne(targetEntity="Card", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="card_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $card;
    
    function getPhoenixborn ()
    {
        return $this->phoenixborn;
    }

    function getCard ()
    {
        return $this->card;
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
