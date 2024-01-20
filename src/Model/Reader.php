<?php

namespace App\Model;
use App\Checker\Checker;
use App\Model\User;
class Reader extends User{

    protected $reader_id;
    protected $readedBooks;
    public function __construct($username, $password, $email, $id = null,$reader_id = null, $readedBooks = 0){
        parent::__construct($username, $password, $email, 'reader' , $id);
        $this->readedBooks = $readedBooks;
        if($this->reader_id != null) $this->setReaderId($reader_id);
    }
    public function getId() {
        if($this->id != null) return $this->id;  
    }

    // Setter para establecer el nombre del usuario
    public function setId($id) {
        $this->id = $id;
    }

    public function getReaderId() {
        if($this->id != null) return $this->id;  
    }

    // Setter para establecer el nombre del usuario
    public function setReaderId($reader_id) {
        $this->reader_id = $reader_id;
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
    public function getReadedBooks() {
        return $this->readedBooks;
    }

    public function setReadedBooks($readedBooks) {
        $this->readedBooks = $readedBooks;
 
    }
}