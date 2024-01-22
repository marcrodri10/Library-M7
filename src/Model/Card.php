<?php

namespace App\Model;

/**
 * Class Card
 * @package App\Model
 */
class Card
{
    /**
     * @var int|null The ID of the card.
     */
    protected $card_id;

    /**
     * @var string|null The name associated with the card.
     */
    protected $name;

    /**
     * @var string|null The card number.
     */
    protected $card;

    /**
     * @var string|null The CVV (Card Verification Value) of the card.
     */
    protected $cvv;

    /**
     * Card constructor.
     *
     * @param int|null $card_id The ID of the card.
     * @param string|null $name The name associated with the card.
     * @param string|null $card The card number.
     * @param string|null $cvv The CVV of the card.
     */
    public function __construct($card_id, $name, $card, $cvv)
    {
        $this->setCardId($card_id);
        $this->setName($name);
        $this->setCard($card);
        $this->setCvv($cvv);
    }

    /**
     * Get the ID of the card.
     *
     * @return int|null The ID of the card.
     */
    public function getCardId()
    {
        return $this->card_id;
    }

    /**
     * Set the ID of the card.
     *
     * @param int|null $card_id The ID of the card.
     */
    public function setCardId($card_id)
    {
        $this->card_id = $card_id;
    }

    /**
     * Get the name associated with the card.
     *
     * @return string|null The name associated with the card.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name associated with the card.
     *
     * @param string|null $name The name associated with the card.
     */
    public function setName($name)
    {
        // You can perform additional validations for the name if necessary
        $this->name = $name;
    }

    /**
     * Get the card number.
     *
     * @return string|null The card number.
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * Set the card number.
     *
     * @param string|null $card The card number.
     */
    public function setCard($card)
    {
        // You can perform additional validations for the card number if necessary
        $this->card = $card;
    }

    /**
     * Get the CVV (Card Verification Value) of the card.
     *
     * @return string|null The CVV of the card.
     */
    public function getCvv()
    {
        return $this->cvv;
    }

    /**
     * Set the CVV (Card Verification Value) of the card.
     *
     * @param string|null $cvv The CVV of the card.
     */
    public function setCvv($cvv)
    {
        // You can perform additional validations for the CVV if necessary
        $this->cvv = $cvv;
    }
}
