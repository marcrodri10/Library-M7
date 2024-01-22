<?php
namespace App\Controllers;
use App\Request;
use App\Controller;
use App\View;
use App\Registry;

class IndexController extends Controller {
    
    // Constructor
    function __construct($session, $request)
    {
        parent::__construct($session, $request);
    }

    // Display home page
    function index(){
        // Render home view
        echo View::render('home');
    }
}
