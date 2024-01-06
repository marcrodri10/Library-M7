<?php
    namespace App\Controllers;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\Session;
    
    class CatalogController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            if(isset($_POST['search']) && $_POST['search'] != ''){
                $books = Registry::get('database')
                    ->selectAll('Books')
                    ->condition('title', 'Books', $_POST['search'], 'like')
                    ->get();
                
                Session::setSession('search', $_POST['search']);

                $files = Registry::get('database')
                    ->selectAll('Files')
                    ->condition('book_id', 'Files', $books[0]['book_id'], '=')
                    ->get();

            }
            else {
                $books = Registry::get('database')
                    ->selectAll('Books')
                    ->get();
                
                Session::deleteSession('search');

                $files = Registry::get('database')
                    ->selectAll('Files')
                    ->get();
            }
            
            
            
            echo View::render('catalog', [
                "books" => $books,
                "files" => $files,
            ]);
            
        }

        function subscriptionAlert(){
            
            header('Location:/catalog');
            
        }

       
    }