<?php
namespace App\Controllers;
use App\Request;
use App\Session;
use App\Controller;
use App\View;

class LogoutController extends Controller {
  
    // Constructor
    function __construct($session, $request)
    {
        parent::__construct($session, $request);
    }        
    
    // Log out user and render login view
    function index(){
        // Destroy all sessions
        $this->session::destroySessions();
        // Render login view
        echo View::render('login');
    }
}
