<?php

namespace AppBundle\Service\DeckChecker;

/**
 * Description of DiceCountChecker
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DiceCountChecker implements DeckCheckerInterface
{
    
    public function check (\AppBundle\Entity\Deck $deck)
    {
        $count = $deck->getDeckDices()->countElements();

        if ($count < 10) {
            return \AppBundle\Service\DeckChecker::TOO_FEW_DICES;
        }

        if ($count > 10) {
            return \AppBundle\Service\DeckChecker::TOO_MANY_DICES;
        }
    }

}
