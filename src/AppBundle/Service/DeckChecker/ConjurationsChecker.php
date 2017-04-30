<?php

namespace AppBundle\Service\DeckChecker;

/**
 * Description of ConjurationsChecker
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ConjurationsChecker implements DeckCheckerInterface
{
    
    public function check(\AppBundle\Entity\Deck $deck)
    {
        $slot = $deck->getDeckCards()->find(function (\AppBundle\Model\CardSlotInterface $slot) {
            /* @var $slot \AppBundle\Entity\DeckCard */
            return $slot->getCard()->getIsConjured();
        });

        if ($slot) {
            return \AppBundle\Service\DeckChecker::INCLUDES_CONJURATION;
        }
    }

}
