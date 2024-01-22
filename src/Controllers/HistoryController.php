<?php
namespace App\Controllers;
use App\Request;
use App\Session;
use App\Controller;
use App\Registry;
use App\View;

class HistoryController extends Controller {
  
    // Constructor
    function __construct($session, $request)
    {
        parent::__construct($session, $request);
    }        
    
    // Display user's reading history
    function index(){
        // Retrieve books from user's reading history using inner join
        $userHistoryBooks = Registry::get('database')
            ->select('Books', ['title'])
            ->join('Books', 'History', 'book_id', 'INNER')
            ->condition(['user_id'], 'History', [$this->session::getSession('user_data')->getId()], '=')
            ->get();
        
        // Render history view with user's history books
        echo View::render('history', ['userHistoryBooks' => $userHistoryBooks]);
    }
}
