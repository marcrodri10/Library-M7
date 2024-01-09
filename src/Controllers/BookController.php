<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\View;

    class BookController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function read(){
            $book_id = $this->request->getParam();
            
            echo View::render('book', ['book_id' => $book_id]);
        }

       
    }