<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\Registry;
    use App\View;

    class BookController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function read(){
            $book_id = $this->request->getParam();
            //insert on history
            $userHistory = Registry::get('database')
                ->select('History', ['book_id'])
                ->condition('user_id','History', Session::getSession('user_data')->getId(), '=')
                ->get();
            
            
            if(!in_array($book_id,get_object_vars($userHistory[0]))){
                Registry::get('database')
                    ->insert('History', [
                        'user_id' => Session::getSession('user_data')->getId(),
                        'book_id' => $book_id]
                    );
            }
           
            
            echo View::render('book', ['book_id' => $book_id]);
        }

       
    }