<?php
    namespace App\Controllers;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    class CatalogController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            $books = Registry::get('database')
                ->selectAll('Books')
                ->condition('available', 'Books', 1, '=')
                ->get();
            
            echo View::render('catalog', [
                "books" => $books,
            ]);
            
        }


        function edit(){

        }
       
    }