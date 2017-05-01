<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Card;
use AppBundle\Entity\Deck;
use AppBundle\Entity\DeckCard;
use AppBundle\Entity\DeckDice;
use AppBundle\Entity\Dice;
use AppBundle\Entity\User;
use AppBundle\Service\DeckChecker;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;

/**
 * Description of DeckManager
 *
 * @author Cédric Bertolini <cedric.bertolini@proximedia.fr>
 */
class DeckManager extends BaseManager
{

    /**
     *
     * @var DeckChecker
     */
    private $deckChecker;

    /**
     *
     * @var \AppBundle\Repository\CardRepository
     */
    private $cardRepository;

    /**
     *
     * @var \AppBundle\Repository\DeckCardRepository
     */
    private $deckCardRepository;

    /**
     *
     * @var \AppBundle\Repository\DiceRepository
     */
    private $diceRepository;

    /**
     *
     * @var \AppBundle\Repository\DeckDiceRepository
     */
    private $deckDiceRepository;

    public function __construct (EntityManager $entityManager, Serializer $serializer, DeckChecker $deckChecker)
    {
        $this->deckChecker = $deckChecker;
        parent::__construct($entityManager, $serializer);
        $this->cardRepository = $this->entityManager->getRepository(Card::class);
        $this->deckCardRepository = $this->entityManager->getRepository(DeckCard::class);
        $this->diceRepository = $this->entityManager->getRepository(Dice::class);
        $this->deckDiceRepository = $this->entityManager->getRepository(DeckDice::class);
    }

    /**
     * Create a new deck from $data. Its version is "0.1". It is private.
     * 
     * @param array $data
     * @param User $user
     * @return type
     */
    public function create (array $data, User $user)
    {
        $deck = $this->denormalize($data);
        $deck->setUser($user);
        $deck->setProblem($this->deckChecker->check($deck));
        $this->persist($deck);
        return $deck;
    }

    /**
     * Update a deck from $data. Its minor version is incremented. It is private.
     * 
     * @param array $data
     * @param Deck $deck
     */
    public function update (array $data, Deck $deck)
    {
        $deck->setDescription($data['description']);
        $deck->setMinorVersion($deck->getMinorVersion() + 1);
        $deck->setName($data['name']);
        $this->setPhoenixborn($deck, $data['phoenixborn_code']);
        $this->setDeckCards($deck, $data['cards']);
        $this->setDeckDices($deck, $data['dices']);
        $deck->setProblem($this->deckChecker->check($deck));
        $merged = $this->merge($deck);
        return $merged;
    }

    /**
     * 
     * @param array $data
     * @return Deck
     */
    public function denormalize ($data)
    {
        $cards = $data['cards'];
        unset($data['cards']);
        $dices = $data['dices'];
        unset($data['dices']);
        $phoenixbornCode = $data['phoenixborn_code'];
        unset($data['phoenixborn_code']);
        /* @var $deck Deck */
        $deck = $this->serializer->denormalize($data, Deck::class);
        $this->setPhoenixborn($deck, $phoenixbornCode);
        $this->setDeckCards($deck, $cards);
        $this->setDeckDices($deck, $dices);
        return $deck;
    }

    public function setPhoenixborn (Deck $deck, $phoenixbornCode)
    {
        $phoenixborn = $this->entityManager->getRepository(Card::class)->find($phoenixbornCode);
        $deck->setPhoenixborn($phoenixborn);
    }

    public function setDeckCards (Deck $deck, array $data)
    {
        $deck->clearDeckCards();
        
        foreach ($data as $card_code => $quantity) {
            $card = $this->cardRepository->find($card_code);
            if (!$card) {
                throw new \Exception("Card not found: $card_code");
            }
            $this->setDeckCard($deck, $card, $quantity);
        }
    }

    public function setDeckCard (Deck $deck, Card $card, int $quantity)
    {
        $deckCard = $this->deckCardRepository->findOneBy(['card' => $card, 'deck' => $deck]);
        if (!$deckCard) {
            $deckCard = new DeckCard($deck, $card, $quantity);
        } else {
            $deckCard->setQuantity($quantity);
        }

        $deck->addDeckCard($deckCard);
    }

    public function setDeckDices (Deck $deck, array $data)
    {
        $deck->clearDeckDices();
        
        foreach ($data as $dice_code => $quantity) {
            $dice = $this->diceRepository->find($dice_code);
            if (!$dice) {
                throw new \Exception("Dice not found: $dice_code");
            }
            $this->setDeckDice($deck, $dice, $quantity);
        }
    }

    public function setDeckDice (Deck $deck, Dice $dice, int $quantity)
    {
        $deckDice = $this->deckDiceRepository->findOneBy(['dice' => $dice, 'deck' => $deck]);
        if (!$deckDice) {
            $deckDice = new DeckDice($deck, $dice, $quantity);
        } else {
            $deckDice->setQuantity($quantity);
        }

        $deck->addDeckDice($deckDice);
    }

}
