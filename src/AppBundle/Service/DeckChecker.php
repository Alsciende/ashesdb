<?php

namespace AppBundle\Service;

/**
 * Service to determine the legality of a deck
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DeckChecker
{
    const TOO_FEW_PHOENIXBORN = 1;
    const TOO_MANY_PHOENIXBORN = 1;
    const TOO_FEW_CARDS = 2;
    const TOO_MANY_CARDS = 3;
    const TOO_MANY_COPIES = 4;
    const INCLUDES_CONJURATION = 5;
    const FORBIDDEN_EXCLUSIVE = 6;
    const TOO_FEW_DICES = 7;
    const TOO_MANY_DICES = 8;
    
    public function __construct ()
    {
        
    }
    
    
    /**
     * 
     * Returns null if the deck is legal, or a string
     * 
     * @param \AppBundle\Entity\Deck $deck
     */
    public function check (\AppBundle\Entity\Deck $deck)
    {
        
    }
}
