<?php

namespace App\Model;

class Card
{
    protected $card_id;
    protected $name;
    protected $card;
    protected $cvv;

    public function __construct($card_id, $name, $card, $cvv)
    {
        $this->setCardId($card_id);
        $this->setName($name);
        $this->setCard($card);
        $this->setCvv($cvv);
    }

    public function getCardId()
    {
        return $this->card_id;
    }

    public function setCardId($card_id)
    {
        $this->card_id = $card_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        // Puedes realizar validaciones adicionales para el nombre si es necesario
        $this->name = $name;
    }

    public function getCard()
    {
        return $this->card;
    }

    public function setCard($card)
    {
        // Puedes realizar validaciones adicionales para el número de tarjeta si es necesario
        $this->card = $card;
    }

    public function getCvv()
    {
        return $this->cvv;
    }

    public function setCvv($cvv)
    {
        // Puedes realizar validaciones adicionales para el CVV si es necesario
        $this->cvv = $cvv;
    }
}

?>
