<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
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
                ->selectAll('Users')
                ->condition('username', 'Users', $fields['username'], '=')
                ->get();
            
           
            
            if($fields['username'] == $userDb[0]['username']){
                if(password_verify($fields['password'], $userDb[0]['password'])){
                    Session::setSession('user_data', $userDb[0]);
                    header('Location:/catalog');
                }
            }
        }
       
    }