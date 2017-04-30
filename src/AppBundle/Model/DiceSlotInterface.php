<?php

namespace AppBundle\Model;

/**
 *
 * @author Alsciende <alsciende@icloud.com>
 */
interface DiceSlotInterface extends SlotInterface
{
    
    /**
     * @return AppBundle\Entity\Dice
     */
    public function getDice ();

}
