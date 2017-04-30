<?php

namespace AppBundle\Model;

/**
 * Description of AbstractSlotCollectionDecorator
 *
 * @author Alsciende <alsciende@icloud.com>
 */
abstract class AbstractSlotCollectionDecorator extends \Doctrine\Common\Collections\ArrayCollection
{
    public function __construct (array $elements = array())
    {
        parent::__construct($elements);
    }
    
    /**
     * @return SlotInterface[]
     */
    public function toArray ()
    {
        return parent::toArray();
    }

    public function countElements ()
    {
        $count = 0;
        foreach($this->toArray() as $slot) {
            $count += $slot->getQuantity();
        }
        return $count;
    }

    public function getContent ()
    {
        $content = [];
        foreach($this->toArray() as $slot) {
            $content[$slot->getElement()->getCode()] = $slot->getQuantity();
        }
        ksort($content);
        return $content;
    }
}
