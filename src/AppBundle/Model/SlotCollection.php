<?php

namespace AppBundle\Model;

/**
 * 
 * @author Alsciende <alsciende@icloud.com>
 */
class SlotCollection extends \Doctrine\Common\Collections\ArrayCollection
{
    function __construct (array $elements = array())
    {
        parent::__construct($elements);
    }

}
