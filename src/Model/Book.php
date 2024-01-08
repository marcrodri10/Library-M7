<?php

namespace App\Model;

use App\Checker\Checker;

class Book
{
    protected $book_id;
    protected $title;
    protected $author;
    protected $genre;
    protected $price;

    public function __construct($book_id, $title, $author, $genre, $price)
    {
        $message = "";

        if ($this->setTitle($title) == -1) $message .= "Bad Title";
        if ($this->setAuthor($author) == -1) $message .= "Bad Author";
        if ($this->setGenre($genre) == -1) $message .= "Bad Genre";
        if ($this->setPrice($price) == -1) $message .= "Bad Price";
        $this->setBookId($book_id);

        if (strlen($message) > 0) throw new \Exception($message);
    }

    public function getBookId()
    {
        return $this->book_id;
    }

    public function setBookId($book_id)
    {
        $this->book_id = $book_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        if (Checker::checkString($title)) {
            $this->title = $title;
        } else {
            return -1;
        }
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        if (Checker::checkString($author)) {
            $this->author = $author;
        } else {
            return -1;
        }
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function setGenre($genre)
    {
        if (Checker::checkString($genre)) {
            $this->genre = $genre;
        } else {
            return -1;
        }
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}

?>
