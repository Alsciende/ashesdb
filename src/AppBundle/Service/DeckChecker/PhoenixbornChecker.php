<?php

namespace AppBundle\Service\DeckChecker;

/**
 * Description of PhoenixbornChecker
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class PhoenixbornChecker implements DeckCheckerInterface
{
    
    public function check(\AppBundle\Entity\Deck $deck)
    {
        $slot = $deck->getDeckCards()->find(function (\AppBundle\Model\CardSlotInterface $slot) {
            /* @var $slot \AppBundle\Entity\DeckCard */
            return $slot->getCard()->getIsPhoenixborn();
        });

        if ($slot) {
            return \AppBundle\Service\DeckChecker::INCLUDES_PHOENIXBORN;
        }
    }

}
