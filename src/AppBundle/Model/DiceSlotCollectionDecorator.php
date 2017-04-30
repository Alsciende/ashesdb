<?php

namespace AppBundle\Model;

/**
 * @author Alsciende <alsciende@icloud.com>
 */
class DiceSlotCollectionDecorator extends AbstractSlotCollectionDecorator
{

    /**
     * @return DiceSlotInterface[]
     */
    function toArray ()
    {
        return parent::toArray();
    }

}
