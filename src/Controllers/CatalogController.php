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
        function formHandler(){
            $handler = new FormHandler($_POST);
            $data = $handler->getPostData();
            $this->index($data);
        }
        function index($data = []){
            if(isset($data['search']) && $data['search'] != ''){
                $books = Registry::get('database')
                    ->selectAll('Books')
                    ->condition(['title'], 'Books', ['%'.$data['search'].'%'], 'LIKE')
                    ->get();
                
                $this->session::setSession('search', $data['search']);
                
                $files = Registry::get('database')
                    ->selectAll('Files')
                    ->condition(['book_id'], 'Files', [$books[0]->book_id], '=')
                    ->get();

            }
            else {
                $books = Registry::get('database')
                    ->selectAll('Books')
                    ->get();
                
                $this->session::deleteSession('search');

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