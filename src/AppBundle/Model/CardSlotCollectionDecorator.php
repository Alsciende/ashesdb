<?php

namespace AppBundle\Model;

/**
 * @author Alsciende <alsciende@icloud.com>
 */
class CardSlotCollectionDecorator extends AbstractSlotCollectionDecorator
{

    /**
     * @return CardSlotInterface[]
     */
    function toArray ()
    {
        return parent::toArray();
    }

    /**
     * @return Card
     */
    function getPhoenixborn()
    {
        $slot = $this->find(function (\AppBundle\Model\CardSlotInterface $slot) {
            /* @var $slot \AppBundle\Entity\DeckCard */
            return $slot->getCard()->getIsPhoenixborn();
        });
        return $slot->getCard();
    }
    
}
