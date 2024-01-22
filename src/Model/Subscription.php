<?php

namespace App\Model;

use App\Checker\Checker;

/**
 * Class Subscription
 * @package App\Model
 */
class Subscription
{
    /**
     * @var int The user ID associated with the subscription.
     */
    protected $user_id;

    /**
     * @var string The start date of the subscription.
     */
    protected $start_date;

    /**
     * @var string The finish date of the subscription.
     */
    protected $finish_date;

    /**
     * @var int The status of the subscription (active or inactive).
     */
    protected $is_active;

    /**
     * @var string The type of the subscription.
     */
    protected $type;

    /**
     * Subscription constructor.
     *
     * @param int $user_id The user ID associated with the subscription.
     * @param string $start_date The start date of the subscription.
     * @param string $finish_date The finish date of the subscription.
     * @param int $is_active The status of the subscription (active or inactive).
     * @param string $type The type of the subscription.
     * @throws \Exception If any validation fails.
     */
    public function __construct($user_id, $start_date, $finish_date, $is_active, $type)
    {
        $message = "";

        $this->setStartDate($start_date);
        $this->setFinishDate($finish_date);
        $this->setIsActive($is_active);
        $this->setType($type);
        $this->setUserId($user_id);

        if (strlen($message) > 0) {
            throw new \Exception($message);
        }
    }

    /**
     * Get the user ID associated with the subscription.
     *
     * @return int The user ID associated with the subscription.
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the user ID associated with the subscription.
     *
     * @param int $user_id The user ID associated with the subscription.
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get the start date of the subscription.
     *
     * @return string The start date of the subscription.
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set the start date of the subscription.
     *
     * @param string $start_date The start date of the subscription.
     */
    public function setStartDate($start_date)
    {
        // You can add additional validations for the start date if necessary
        $this->start_date = $start_date;
    }

    /**
     * Get the finish date of the subscription.
     *
     * @return string The finish date of the subscription.
     */
    public function getFinishDate()
    {
        return $this->finish_date;
    }

    /**
     * Set the finish date of the subscription.
     *
     * @param string $finish_date The finish date of the subscription.
     */
    public function setFinishDate($finish_date)
    {
        // You can add additional validations for the finish date if necessary
        $this->finish_date = $finish_date;
    }

    /**
     * Get the status of the subscription (active or inactive).
     *
     * @return int The status of the subscription (1 for active, 0 for inactive).
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set the status of the subscription (active or inactive).
     *
     * @param int $is_active The status of the subscription (1 for active, 0 for inactive).
     */
    public function setIsActive($is_active)
    {
        // You can add additional validations for the status if necessary
        $this->is_active = $is_active;
    }

    /**
     * Get the type of the subscription.
     *
     * @return string The type of the subscription.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of the subscription.
     *
     * @param string $type The type of the subscription.
     * @return -1 if the type is invalid.
     */
    public function setType($type)
    {
        if (Checker::checkString($type)) {
            $this->type = $type;
        } else {
            return -1;
        }
    }
}
