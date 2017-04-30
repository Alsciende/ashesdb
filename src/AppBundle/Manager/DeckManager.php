<?php

namespace AppBundle\Manager;

/**
 * Description of DeckManager
 *
 * @author Cédric Bertolini <cedric.bertolini@proximedia.fr>
 */
class DeckManager extends BaseManager
{

    public function create (array $data, \AppBundle\Entity\User $user)
    {
        $cards = $data['cards'];
        unset($data['cards']);
        $dices = $data['dices'];
        unset($data['dices']);
        $deck = $this->serializer->denormalize($data, \AppBundle\Entity\Deck::class);
        $this->setCards($deck, $cards);
        $this->setDices($deck, $dices);
        $deck->setUser($user);
        $this->persist($deck);
        return $deck;
    }

    public function setCards (\AppBundle\Entity\Deck $deck, array $data)
    {
        $cardRepository = $this->entityManager->getRepository(\AppBundle\Entity\Card::class);
        foreach ($data as $card_code => $quantity) {
            $card = $cardRepository->find($card_code);
            if (!$card) {
                throw new \Exception("Card not found: $card_code");
            }
            $deck->addDeckCard(new \AppBundle\Entity\DeckCard($deck, $card, $quantity));
        }
    }

    public function setDices (\AppBundle\Entity\Deck $deck, array $data)
    {
        $diceRepository = $this->entityManager->getRepository(\AppBundle\Entity\Dice::class);
        foreach ($data as $dice_code => $quantity) {
            $dice = $diceRepository->find($dice_code);
            if (!$dice) {
                throw new \Exception("Dice not found: $dice_code");
            }
            $deck->addDeckDice(new \AppBundle\Entity\DeckDice($deck, $dice, $quantity));
        }
    }


}
