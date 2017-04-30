<?php

namespace AppBundle\Service;

/**
 * Service to determine the validity/legality of a deck
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DeckChecker
{

    const VALID_DECK = 0;
    const TOO_FEW_PHOENIXBORNS = 1;
    const TOO_MANY_PHOENIXBORNS = 2;
    const TOO_FEW_CARDS = 3;
    const TOO_MANY_CARDS = 4;
    const TOO_MANY_COPIES = 5;
    const INCLUDES_CONJURATION = 6;
    const FORBIDDEN_EXCLUSIVE = 7;
    const TOO_FEW_DICES = 8;
    const TOO_MANY_DICES = 9;

    /**
     * 
     * Returns null if the deck is legal, or a string
     * 
     * @param \AppBundle\Entity\Deck $deck
     */
    public function check (\AppBundle\Entity\Deck $deck)
    {
        $checkers = [
            'checkPhoenixborns',
            'checkNumberOfCards',
            'checkNumberOfCopies',
            'checkConjurations',
            'checkForbiddenExclusives',
            'checkNumberOfDices',
        ];


        foreach ($checkers as $checker) {
            $result = $this->$checker($deck);
            if ($result) {
                return $result;
            }
        }

        return self::VALID_DECK;
    }

    private function checkPhoenixborns (\AppBundle\Entity\Deck $deck)
    {
        $phoenixborns = $deck->getDeckCards()->filter(function (\AppBundle\Model\CardSlotInterface $slot) {
            /* @var $slot \AppBundle\Entity\DeckCard */
            return $slot->getCard()->getIsPhoenixborn();
        });

        if (count($phoenixborns) < 1) {
            return self::TOO_FEW_PHOENIXBORNS;
        }

        if (count($phoenixborns) > 1) {
            return self::TOO_MANY_PHOENIXBORNS;
        }
    }

    private function checkNumberOfCards (\AppBundle\Entity\Deck $deck)
    {
        $count = $deck->getDeckCards()->getDrawDeck()->countElements();

        if ($count < 30) {
            return self::TOO_FEW_CARDS;
        }

        if ($count > 30) {
            return self::TOO_MANY_CARDS;
        }
    }

    private function checkNumberOfCopies (\AppBundle\Entity\Deck $deck)
    {
        $slot = $deck->getDeckCards()->find(function (\AppBundle\Model\CardSlotInterface $slot) {
            /* @var $slot \AppBundle\Entity\DeckCard */
            return $slot->getQuantity() > 3;
        });

        if ($slot) {
            return self::TOO_MANY_COPIES;
        }
    }

    private function checkConjurations (\AppBundle\Entity\Deck $deck)
    {
        $slot = $deck->getDeckCards()->find(function (\AppBundle\Model\CardSlotInterface $slot) {
            /* @var $slot \AppBundle\Entity\DeckCard */
            return $slot->getCard()->getIsConjured();
        });

        if ($slot) {
            return self::INCLUDES_CONJURATION;
        }
    }

    private function checkForbiddenExclusives (\AppBundle\Entity\Deck $deck)
    {
        $phoenixborn = $deck->getDeckCards()->getPhoenixborn();

        $slot = $deck->getDeckCards()->find(function (\AppBundle\Model\CardSlotInterface $slot) use ($phoenixborn) {
            /* @var $slot \AppBundle\Entity\DeckCard */
            $exclusiveTo = $slot->getCard()->getExclusiveTo();
            if ($exclusiveTo && $exclusiveTo->getPhoenixborn() !== $phoenixborn) {
                return TRUE;
            }
        });

        if ($slot) {
            return self::FORBIDDEN_EXCLUSIVE;
        }
    }

    private function checkNumberOfDices (\AppBundle\Entity\Deck $deck)
    {
        $count = $deck->getDeckDices()->countElements();

        if ($count < 10) {
            return self::TOO_FEW_DICES;
        }

        if ($count > 10) {
            return self::TOO_MANY_DICES;
        }
    }

}
