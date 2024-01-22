<?php
namespace App\Controllers;
use App\Request;
use App\Controller;
use App\View;
use App\Registry;
use App\Session;
use App\FormHandler;

class CatalogController extends Controller {
  
    // Constructor
    function __construct($session, $request)
    {
        parent::__construct($session, $request);
    }        
    
    // Display catalog index
    function index(){
        // Check for search query in form submission
        if(!isset($_POST['reset']) && isset($_POST['search']) && $_POST['search'] != ''){
            // Retrieve books matching the search query
            $books = Registry::get('database')
                ->selectAll('Books')
                ->condition(['title'], 'Books', ['%'.$_POST['search'].'%'], 'LIKE')
                ->get();
            
            // Set search query in session
            $this->session::setSession('search', $_POST['search']);
        }
        else {
            // Retrieve all books if no search query is provided
            $books = Registry::get('database')
                ->selectAll('Books')
                ->get();
            
            // Delete search query from session
            $this->session::deleteSession('search');
        }
        
        // Render catalog view with retrieved books
        echo View::render('catalog', [
            "books" => $books,
        ]);
    }

    // Redirect to catalog
    function subscriptionAlert(){
        header('Location:/catalog');
    }
}