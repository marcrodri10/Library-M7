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
            
            $userSuscription = Registry::get('database')
                ->selectAll('Suscriptions')
                ->condition('user_id', 'Suscriptions', Session::getSession('user_data')['user_id'], '=')
                ->get();
            
            Session::setSession('user_suscription', sizeof($userSuscription) > 0 ? $userSuscription[0] : false);
            
            $currentDate = new \DateTime();
            
    
            if(Session::getSession('user_suscription') !== false && $currentDate->format('Y-m-d') > Session::getSession('user_suscription')['finish_date']){
                Registry::get('database')
                    ->update('Suscriptions', [
                        'is_active' => 0,
                    ])
                    ->condition('user_id', 'Suscriptions', Session::getSession('user_data')['user_id'], '=')
                    ->get();
                
                Session::setSession('user_suscription', 0, 'is_active');
                
            }

            if($fields['username'] == $userDb[0]['username']){
                if(password_verify($fields['password'], $userDb[0]['password'])){
                    Session::setSession('user_data', $userDb[0]);
                    header('Location:/catalog');
                }
            }
        }
       
    }