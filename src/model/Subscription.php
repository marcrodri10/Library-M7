<?php

namespace App\Model;

use App\Checker\Checker;

class Subscription
{
    protected $user_id;
    protected $start_date;
    protected $finish_date;
    protected $is_active;
    protected $type;

    public function __construct($user_id, $start_date, $finish_date, $is_active, $type)
    {
        $message = "";

        $this->setStartDate($start_date);
        $this->setFinishDate($finish_date);
        $this->setIsActive($is_active);
        $this->setType($type);
        $this->setUserId($user_id);

        if (strlen($message) > 0) throw new \Exception($message);
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function setStartDate($start_date)
    {
        // Puedes agregar validaciones adicionales para la fecha de inicio si es necesario
        $this->start_date = $start_date;
    }

    public function getFinishDate()
    {
        return $this->finish_date;
    }

    public function setFinishDate($finish_date)
    {
        // Puedes agregar validaciones adicionales para la fecha de finalización si es necesario
        $this->finish_date = $finish_date;
    }

    public function getIsActive()
    {
        return $this->is_active;
    }

    public function setIsActive($is_active)
    {
        // Puedes agregar validaciones adicionales para el estado activo si es necesario
        $this->is_active = $is_active;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (Checker::checkString($type)) {
            $this->type = $type;
        } else {
            return -1;
        }
    }
}

?>
