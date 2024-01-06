<?php

namespace App\Model;
use App\Checker\Checker;
class File
{
    protected $file_id;
    protected $book_id;
    protected $route;

    public function __construct($file_id, $book_id, $route)
    {
        $message = "";

        $this->setFileId($file_id);
        $this->setBookId($book_id);
        if($this->setRoute($route) == -1) $message .= "Bad Route";

        if (strlen($message) > 0) throw new \Exception($message);

    }

    public function getFileId()
    {
        return $this->file_id;
    }

    public function setFileId($file_id)
    {
        $this->file_id = $file_id;
    }

    public function getBookId()
    {
        return $this->book_id;
    }

    public function setBookId($book_id)
    {
        $this->book_id = $book_id;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute($route)
    {
        if (Checker::checkString($route)) {
            $this->route = $route;
        }
        else return -1;
        
    }
}

?>
