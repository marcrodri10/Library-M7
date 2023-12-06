<?php
    namespace App\Controllers;
    use App\Request;
    use App\Controller;
    use App\View;
    class RegisterController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
            
         
        }        function index(){
            echo View::render('register');
        }
       
    }