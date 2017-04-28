<?php

namespace AppBundle\Manager;

/**
 * Description of DeckManager
 *
 * @author Cédric Bertolini <cedric.bertolini@proximedia.fr>
 */
class DeckManager extends BaseManager
{
    public function create(array $data, \AppBundle\Entity\User $user)
    {
        $slots = $data['slots']; unset($data['slots']);
        $deck = $this->serializer->denormalize($data, \AppBundle\Entity\Deck::class);
        $this->setSlots($deck, $slots);
        $deck->setUser($user);
        $this->persist($deck);
        return $deck;
    }
    
    public function setSlots(\AppBundle\Entity\Deck $deck, array $data)
    {
        $cardRepository = $this->entityManager->getRepository(\AppBundle\Entity\Card::class);
        $deckSlots = [];
        foreach($data as $card_code => $quantity) {
            $card = $cardRepository->find($card_code);
            if(!$card) {
                throw new \Exception("Card not found: $card_code");
            }
            $deckSlots[] = new \AppBundle\Entity\DeckSlot($deck, $card, $quantity);
        }
        $deck->setDeckSlots($deckSlots);
    }
}
