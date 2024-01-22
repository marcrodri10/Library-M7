<?php

namespace App\Model;

use App\Checker\Checker;

/**
 * Class User
 * @package App\Model
 */
class User
{
    /**
     * @var int|null The user ID.
     */
    protected $id;

    /**
     * @var string The username of the user.
     */
    protected $username;

    /**
     * @var string The password of the user.
     */
    protected $password;

    /**
     * @var string The email address of the user.
     */
    protected $email;

    /**
     * @var string The role of the user.
     */
    protected $role;

    /**
     * User constructor.
     *
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     * @param string $email The email address of the user.
     * @param string $role The role of the user.
     * @param int|null $id The user ID.
     * @throws \Exception If any validation fails.
     */
    public function __construct($username, $password, $email, $role, $id = null)
    {
        $message = "";
        if ($this->setUsername($username) == -1) {
            $message .= "Bad Username";
        }
        if ($this->setPassword($password) == -1) {
            $message .= "Bad Password";
        }
        if ($this->setEmail($email) == -1) {
            $message .= "Bad Email";
        }
        $this->setRole($role);
        if ($id !== null) {
            $this->setId($id);
        }

        if (strlen($message) > 0) {
            throw new \Exception($message);
        }
    }

    /**
     * Get the user ID.
     *
     * @return int|null The user ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the user ID.
     *
     * @param int $id The user ID.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the username of the user.
     *
     * @return string The username of the user.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the username of the user.
     *
     * @param string $username The username of the user.
     * @return -1 if the username is invalid.
     */
    public function setUsername($username)
    {
        if (Checker::checkString($username)) {
            $this->username = $username;
        } else {
            return -1;
        }
    }

    /**
     * Get the password of the user.
     *
     * @return string The password of the user.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the password of the user.
     *
     * @param string $password The password of the user.
     * @return -1 if the password is invalid.
     */
    public function setPassword($password)
    {
        if (Checker::checkString($password)) {
            $this->password = $password;
        } else {
            return -1;
        }
    }

    /**
     * Get the email address of the user.
     *
     * @return string The email address of the user.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the email address of the user.
     *
     * @param string $email The email address of the user.
     * @return -1 if the email address is invalid.
     */
    public function setEmail($email)
    {
        if (Checker::checkString($email)) {
            $this->email = $email;
        } else {
            return -1;
        }
    }

    /**
     * Get the role of the user.
     *
     * @return string The role of the user.
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the role of the user.
     *
     * @param string $role The role of the user.
     */
    public function setRole($role)
    {
        if (Checker::checkString($role)) {
            $this->role = $role;
        }
    }
}
