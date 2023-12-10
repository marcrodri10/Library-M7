<?php
    namespace App\Controllers;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    class RegisterController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('register');
        }

        function edit(){

            $params = explode("/", $this->request->getParam());
            if($params[2] == $params[3]){
                $fields = [
                    'username' => $params[0],
                    'password' => password_hash($params[2], PASSWORD_DEFAULT),
                    'email' => $params[1],
                    'role' => 'reader',
                ];
                
                Registry::get('database')->insert('users', $fields);
                header('Location:/login');
            }
            
            
        }
       
    }