<?php

namespace AppBundle\Service\DeckChecker;

/**
 * Description of ExclusivesChecker
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ExclusivesChecker implements DeckCheckerInterface
{

    public function check (\AppBundle\Entity\Deck $deck)
    {
        $phoenixborn = $deck->getPhoenixborn();

        $slot = $deck->getDeckCards()->find(function (\AppBundle\Model\CardSlotInterface $slot) use ($phoenixborn) {
            /* @var $slot \AppBundle\Entity\DeckCard */
            $exclusiveTo = $slot->getCard()->getExclusiveTo();
            if ($exclusiveTo && $exclusiveTo->getPhoenixborn() !== $phoenixborn) {
                return TRUE;
            }
        });

        if ($slot) {
            return \AppBundle\Service\DeckChecker::FORBIDDEN_EXCLUSIVE;
        }
    }

}
