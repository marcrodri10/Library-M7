<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\FormHandler;
    use App\Model\User;
    use App\Model\Subscription;
    class LoginController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('login');
        }

        function formHandler(){
            $handler = new FormHandler($_POST);
            $data = $handler->getPostData();
            $this->edit($data);
        }
        function edit($data){

            $fields = [
                'username' => $data['username'],
                'password' => $data['password'],
            ];

            $userDb = Registry::get('database')
                ->selectAll('Users')
                ->condition('username', 'Users', $fields['username'], '=')
                ->get();
            
            try{ 
                $user = new User($userDb[0]->username, $userDb[0]->password, $userDb[0]->email, $userDb[0]->role, $userDb[0]->user_id);
                
                $userSubscription = Registry::get('database')
                    ->selectAll('Subscriptions')
                    ->condition('user_id', 'Subscriptions', $user->getId(), '=')
                    ->get();
                
                if(sizeof($userSubscription) > 0) {
                    $subscription = new Subscription($user->getId(), $userSubscription[0]->start_date, 
                    $userSubscription[0]->finish_date, $userSubscription[0]->is_active, $userSubscription[0]->type);
                }
                else $subscription = false;

                
                $this->session::setSession('user_subscription', $subscription);
                
                $currentDate = new \DateTime();
                
        
                if($this->session::getSession('user_subscription') !== false && $currentDate->format('Y-m-d') > Session::getSession('user_subscription')->getFinishDate()) {
                    Registry::get('database')
                        ->update('Subscriptions', [
                            'is_active' => 0,
                        ])
                        ->condition('user_id', 'Subscriptions', $this->session::getSession('user_data')->getId(), '=')
                        ->get();
                    
                    $this->session::getSession('user_subscription')->setIsActive(0);

                    
                }
                
                if($fields['username'] == $user->getUsername()){
                    if(password_verify($fields['password'], $user->getPassword())){
                        $this->session::setSession('user_data', $user);
                        /* var_dump(Session::getSession('user_data'));
                        var_dump(Session::getSession('user_subscription')); */
                        
                        header('Location:/catalog');
                    }
                }
            }
            catch(\Exception $e){
                echo $e->getMessage();
            }
            
            
        }
       
    }