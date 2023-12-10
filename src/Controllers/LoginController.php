<?php
    namespace App\Controllers;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    class LoginController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('login');
        }

        function edit(){

            $params = explode("/", $this->request->getParam());
            $fields = [
                'username' => $params[0],
                'password' => $params[1],
            ];

            $userDb = Registry::get('database')
                ->select('users', $fields)
                ->condition('username', 'users', $fields['username'], '=')
                ->get();
           
            if($fields['username'] == $userDb[0]['username']){
                if(password_verify($fields['password'], $userDb[0]['password'])){
                    header('Location:/catalog');
                }
            }
        }
       
    }