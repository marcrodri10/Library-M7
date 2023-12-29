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

            }
            else {
                $books = Registry::get('database')
                    ->selectAll('Books')
                    ->condition('available', 'Books', 1, '=')
                    ->get();
                
                Session::deleteSession('search');
            }
            
            
            
            echo View::render('catalog', [
                "books" => $books,
            ]);
            
        }

        function subscriptionAlert(){
            if(Session::getSession('user_subscription') == false || Session::getSession('user_subscription')['is_active'] == 0) header('Location:/catalog');
            else echo 'siii';
        }

       
    }