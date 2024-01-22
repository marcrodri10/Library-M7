<?php

namespace App\Model;
use App\Checker\Checker;
use App\Model\User;

class Reader extends User{

    protected $reader_id;
    protected $readedBooks;

    // Constructor for creating a Reader object
    public function __construct($username, $password, $email, $id = null, $reader_id = null, $readedBooks = 0){
        // Call the parent constructor to set basic user information
        parent::__construct($username, $password, $email, 'reader', $id);
        
        // Set additional properties specific to Reader
        $this->readedBooks = $readedBooks;

        // If reader_id is provided, set it using the setReaderId method
        if ($reader_id != null) {
            $this->setReaderId($reader_id);
        }
    }

    // Getter for retrieving the ID of the Reader
    public function getReaderId() {
        return $this->reader_id;
    }

    // Setter for setting the ID of the Reader
    public function setReaderId($reader_id) {
        $this->reader_id = $reader_id;
    }

    // Getter for retrieving the number of books read by the Reader
    public function getReadedBooks() {
        return $this->readedBooks;
    }

    // Setter for setting the number of books read by the Reader
    public function setReadedBooks($readedBooks) {
        $this->readedBooks = $readedBooks;
    }
}
