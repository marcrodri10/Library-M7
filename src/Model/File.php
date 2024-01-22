<?php

namespace App\Model;

use App\Checker\Checker;

/**
 * Class File
 * @package App\Model
 */
class File
{
    /**
     * @var int|null The ID of the file.
     */
    protected $file_id;

    /**
     * @var int|null The ID of the associated book.
     */
    protected $book_id;

    /**
     * @var string|null The file route.
     */
    protected $route;

    /**
     * File constructor.
     *
     * @param int|null $file_id The ID of the file.
     * @param int|null $book_id The ID of the associated book.
     * @param string|null $route The file route.
     * @throws \Exception If there are validation errors.
     */
    public function __construct($file_id, $book_id, $route)
    {
        $message = "";

        $this->setFileId($file_id);
        $this->setBookId($book_id);
        
        if ($this->setRoute($route) == -1) {
            $message .= "Bad Route";
        }

        if (strlen($message) > 0) {
            throw new \Exception($message);
        }
    }

    /**
     * Get the ID of the file.
     *
     * @return int|null The ID of the file.
     */
    public function getFileId()
    {
        return $this->file_id;
    }

    /**
     * Set the ID of the file.
     *
     * @param int|null $file_id The ID of the file.
     */
    public function setFileId($file_id)
    {
        $this->file_id = $file_id;
    }

    /**
     * Get the ID of the associated book.
     *
     * @return int|null The ID of the associated book.
     */
    public function getBookId()
    {
        return $this->book_id;
    }

    /**
     * Set the ID of the associated book.
     *
     * @param int|null $book_id The ID of the associated book.
     */
    public function setBookId($book_id)
    {
        $this->book_id = $book_id;
    }

    /**
     * Get the file route.
     *
     * @return string|null The file route.
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set the file route.
     *
     * @param string|null $route The file route.
     * @return -1 if validation fails.
     */
    public function setRoute($route)
    {
        if (Checker::checkString($route)) {
            $this->route = $route;
        } else {
            return -1;
        }
    }
}
