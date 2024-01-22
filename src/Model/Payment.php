<?php

namespace App\Model;

/**
 * Class Payment
 * @package App\Model
 */
class Payment
{
    /**
     * @var int|null The user ID associated with the payment.
     */
    protected $user_id;

    /**
     * @var float|null The payment amount.
     */
    protected $amount;

    /**
     * @var string|null The date of the payment.
     */
    protected $date;

    /**
     * @var int|null The ID of the associated card.
     */
    protected $cardId;

    /**
     * Payment constructor.
     *
     * @param int|null $user_id The user ID associated with the payment.
     * @param float|null $amount The payment amount.
     * @param string|null $date The date of the payment.
     * @param int|null $cardId The ID of the associated card.
     */
    public function __construct($user_id, $amount, $date, $cardId)
    {
        $this->setUserId($user_id);
        $this->setAmount($amount);
        $this->setDate($date);
        $this->setCardId($cardId);
    }

    /**
     * Get the user ID associated with the payment.
     *
     * @return int|null The user ID associated with the payment.
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the user ID associated with the payment.
     *
     * @param int|null $user_id The user ID associated with the payment.
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get the payment amount.
     *
     * @return float|null The payment amount.
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the payment amount.
     *
     * @param float|null $amount The payment amount.
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the date of the payment.
     *
     * @return string|null The date of the payment.
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the date of the payment.
     *
     * @param string|null $date The date of the payment.
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get the ID of the associated card.
     *
     * @return int|null The ID of the associated card.
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set the ID of the associated card.
     *
     * @param int|null $cardId The ID of the associated card.
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;
    }
}