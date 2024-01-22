<?php
namespace App\Controllers;

use App\Session;
use App\Request;
use App\Controller;
use App\View;
use App\Registry;
use App\FormHandler;
use App\Model\User;

class UserProfileController extends Controller {
      
    function __construct($session, $request) {
        parent::__construct($session, $request);
    }        
        
    function index() {
        // Retrieve user data from the session
        $userData = $this->session::getSession('user_data');
        
        // Render the 'userProfile' view with user data
        echo View::render('userProfile', [
            'userData' => $userData
        ]);
    }
}

