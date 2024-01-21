<?php
    namespace App\Controllers;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\Session;
    use App\FormHandler;
    class CatalogController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            
            if(!isset($_POST['reset']) && isset($_POST['search']) && $_POST['search'] != ''){
                $books = Registry::get('database')
                    ->selectAll('Books')
                    ->condition(['title'], 'Books', ['%'.$_POST['search'].'%'], 'LIKE')
                    ->get();
                
                $this->session::setSession('search', $_POST['search']);

            }
            else {
                $books = Registry::get('database')
                    ->selectAll('Books')
                    ->get();
                
                $this->session::deleteSession('search');
            }
            
            echo View::render('catalog', [
                "books" => $books,
            ]);
            
        }

        function subscriptionAlert(){
            
            header('Location:/catalog');
            
        }

       
    }