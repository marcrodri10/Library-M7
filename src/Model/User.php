<?php

namespace App\Model;
use App\Checker\Checker;
class User {
    protected $id;
    protected $username;
    protected $password;
    protected $email;
    protected $role;

    public function __construct($username, $password, $email, $role, $id = null) {
        $message = "";
        if($this->setUsername($username) == -1) $message .= "Bad Username";
        if($this->setPassword($password) == -1) $message .= "Bad Password";
        if($this->setEmail($email) == -1) $message .= "Bad Email";
        $this->setRole($role);
        if($id != null) $this->setId($id);

        if(strlen($message) > 0) throw new \Exception($message);
    }

    public function getId() {
        if($this->id != null) return $this->id;  
    }

    // Setter para establecer el nombre del usuario
    public function setId($id) {
        $this->id = $id;
    }

    // Getter para obtener el nombre del usuario
    public function getUsername() {
        return $this->username;
    }

    // Setter para establecer el nombre del usuario
    public function setUsername($username) {
        if(Checker::checkString($username)){
            $this->username = $username;
        }
        else return -1;
    }

    // Getter para obtener la contraseña del usuario
    public function getPassword() {
        return $this->password;
    }

    // Setter para establecer la contraseña del usuario
    public function setPassword($password) {
        if(Checker::checkString($password)){
            $this->password = $password;
        }
        else return -1;
        
    }

    // Getter para obtener el correo electrónico del usuario
    public function getEmail() {
        return $this->email;
    }

    // Setter para establecer el correo electrónico del usuario
    public function setEmail($email) {
        if(Checker::checkString($email)){
            $this->email = $email;
        }
        else return -1;
        
    }

    // Getter para obtener el rol del usuario
    public function getRole() {
        return $this->role;
    }

    // Setter para establecer el rol del usuario
    public function setRole($role) {
        if(Checker::checkString($role)){
            $this->role = $role;
        }
        
    }
}



?>
