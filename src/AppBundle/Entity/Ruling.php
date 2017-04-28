<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Alsciende\SerializerBundle\Annotation\Source;

/**
 * A Ruling written by a User for a Card
 * 
 * @ORM\Table(name="rulings")
 * @ORM\Entity
 *
 * @Source
 * 
 * @author Alsciende <alsciende@icloud.com>
 */
class Ruling
{
    use TimestampableEntity;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="integer", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @Source(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     * 
     * @Source(type="string")
     */
    private $text;
    
    /**
     * @var Card
     *
     * @ORM\ManyToOne(targetEntity="Card")
     * @ORM\JoinColumn(name="card_code", referencedColumnName="code")
     * 
     * @Source(type="association")
     */
    private $card;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     * @Source(type="association")
     */
    private $user;

    function getId ()
    {
        return $this->id;
    }

    function getText ()
    {
        return $this->text;
    }

    function getCard ()
    {
        return $this->card;
    }

    function getUser ()
    {
        return $this->user;
    }

    function setText ($text)
    {
        $this->text = $text;
        
        return $this;
    }

    function setCard (Card $card)
    {
        $this->card = $card;
        
        return $this;
    }

    function setUser (User $user)
    {
        $this->user = $user;
        
        return $this;
    }

    
}
