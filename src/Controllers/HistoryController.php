<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\Registry;
    use App\View;

    class HistoryController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            //inner join books with history
            //SELECT Books.title FROM Books INNER JOIN History ON Books.book_id = History.book_id;
            $userHistoryBooks = Registry::get('database')
                ->select('Books', ['title'])
                ->join('Books', 'History', 'book_id', 'INNER')
                ->condition(['user_id'], 'History', [$this->session::getSession('user_data')->getId()], '=')
                ->get();
            
            echo View::render('history', ['userHistoryBooks' => $userHistoryBooks]);
        }

       
    }