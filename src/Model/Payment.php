<?php

namespace App\Model;

class Payment {
    protected $user_id;
    protected $amount;
    protected $date;
    protected $cardId;
    public function __construct($user_id, $amount, $date, $cardId) {
        $this->setUserId($user_id);
        $this->setAmount($amount);
        $this->setDate($date);
        $this->setCardId($cardId);
    }   

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }
    public function getCardId() {
        return $this->cardId;
    }

    public function setCardId($cardId) {
        $this->cardId = $cardId;
    }
}

