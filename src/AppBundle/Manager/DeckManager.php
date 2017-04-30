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
        $dices = $data['dices']; unset($data['dices']);
        $deck = $this->serializer->denormalize($data, \AppBundle\Entity\Deck::class);
        $this->setSlots($deck, $slots);
        $this->setDices($deck, $dices);
        $deck->setUser($user);
        $this->persist($deck);
        return $deck;
    }
    
    public function setSlots(\AppBundle\Entity\Deck $deck, array $data)
    {
        $cardRepository = $this->entityManager->getRepository(\AppBundle\Entity\Card::class);
        foreach($data as $card_code => $quantity) {
            $card = $cardRepository->find($card_code);
            if(!$card) {
                throw new \Exception("Card not found: $card_code");
            }
            $deck->addDeckSlot(new \AppBundle\Entity\DeckSlot($deck, $card, $quantity));
        }
    }
    
    public function setDices(\AppBundle\Entity\Deck $deck, array $data)
    {
        $diceRepository = $this->entityManager->getRepository(\AppBundle\Entity\Dice::class);
        foreach($data as $dice_code => $quantity) {
            $dice = $diceRepository->find($dice_code);
            if(!$dice) {
                throw new \Exception("Dice not found: $dice_code");
            }
            $deck->addDeckDice(new \AppBundle\Entity\DeckDice($deck, $dice, $quantity));
        }
    }
}
