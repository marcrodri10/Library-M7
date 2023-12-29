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
            
            $userSubscription = Registry::get('database')
                ->selectAll('Subscriptions')
                ->condition('user_id', 'Subscriptions', Session::getSession('user_data')['user_id'], '=')
                ->get();
            
            Session::setSession('user_subscription', sizeof($userSubscription) > 0 ? $userSubscription[0] : false);
            
            $currentDate = new \DateTime();
            
    
            if(Session::getSession('user_subscription') !== false && $currentDate->format('Y-m-d') > Session::getSession('user_subscription')['finish_date']){
                Registry::get('database')
                    ->update('Subscriptions', [
                        'is_active' => 0,
                    ])
                    ->condition('user_id', 'Subscriptions', Session::getSession('user_data')['user_id'], '=')
                    ->get();
                
                Session::setSession('user_subscription', 0, 'is_active');
                
            }

            if($fields['username'] == $userDb[0]['username']){
                if(password_verify($fields['password'], $userDb[0]['password'])){
                    Session::setSession('user_data', $userDb[0]);
                    header('Location:/catalog');
                }
            }
        }
       
    }