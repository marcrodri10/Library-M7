<?php

namespace App\Model;

use App\Checker\Checker;

/**
 * Class Book
 * @package App\Model
 */
class Book
{
    /**
     * @var int|null The ID of the book.
     */
    protected $book_id;

    /**
     * @var string|null The title of the book.
     */
    protected $title;

    /**
     * @var string|null The author of the book.
     */
    protected $author;

    /**
     * @var string|null The genre of the book.
     */
    protected $genre;

    /**
     * @var float|null The price of the book.
     */
    protected $price;

    /**
     * Book constructor.
     *
     * @param int|null $book_id The ID of the book.
     * @param string|null $title The title of the book.
     * @param string|null $author The author of the book.
     * @param string|null $genre The genre of the book.
     * @param float|null $price The price of the book.
     * @throws \Exception If any validation checks fail.
     */
    public function __construct($book_id, $title, $author, $genre, $price)
    {
        $message = "";

        if ($this->setTitle($title) == -1) {
            $message .= "Bad Title";
        }
        if ($this->setAuthor($author) == -1) {
            $message .= "Bad Author";
        }
        if ($this->setGenre($genre) == -1) {
            $message .= "Bad Genre";
        }
        if ($this->setPrice($price) == -1) {
            $message .= "Bad Price";
        }
        $this->setBookId($book_id);

        if (strlen($message) > 0) {
            throw new \Exception($message);
        }
    }

    /**
     * Get the ID of the book.
     *
     * @return int|null The ID of the book.
     */
    public function getBookId()
    {
        return $this->book_id;
    }

    /**
     * Set the ID of the book.
     *
     * @param int|null $book_id The ID of the book.
     */
    public function setBookId($book_id)
    {
        $this->book_id = $book_id;
    }

    /**
     * Get the title of the book.
     *
     * @return string|null The title of the book.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the title of the book.
     *
     * @param string|null $title The title of the book.
     * @return int|null Returns -1 if validation fails.
     */
    public function setTitle($title)
    {
        if (Checker::checkString($title)) {
            $this->title = $title;
        } else {
            return -1;
        }
    }

    /**
     * Get the author of the book.
     *
     * @return string|null The author of the book.
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the author of the book.
     *
     * @param string|null $author The author of the book.
     * @return int|null Returns -1 if validation fails.
     */
    public function setAuthor($author)
    {
        if (Checker::checkString($author)) {
            $this->author = $author;
        } else {
            return -1;
        }
    }

    /**
     * Get the genre of the book.
     *
     * @return string|null The genre of the book.
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set the genre of the book.
     *
     * @param string|null $genre The genre of the book.
     * @return int|null Returns -1 if validation fails.
     */
    public function setGenre($genre)
    {
        if (Checker::checkString($genre)) {
            $this->genre = $genre;
        } else {
            return -1;
        }
    }

    /**
     * Get the price of the book.
     *
     * @return float|null The price of the book.
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the price of the book.
     *
     * @param float|null $price The price of the book.
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
}
