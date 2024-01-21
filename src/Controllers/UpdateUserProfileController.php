<?php
    namespace App\Controllers;
    use App\Session;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\FormHandler;
    use App\Model\User;
    class UpdateUserProfileController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            $userData = $this->session::getSession('user_data');
            echo View::render('updateUserProfile', [
                'userData' => $userData
            ]);
        }

        function edit(){
            $fields = [];

            foreach($_POST as $key => $value){
                if($value != ''){
                    if($key == 'password') $fields = array_merge($fields, [$key => password_hash($value, PASSWORD_DEFAULT)]);
                    else $fields = array_merge($fields, [$key => $value]);
                    
                }
            }
            try{
                
                Registry::get('database')
                    ->update('Users', $fields)
                    ->condition(['user_id'], 'Users', [$this->session::getSession('user_data')->getId()], '=')
                    ->get();
                
                $userDb = Registry::get('database')
                    ->selectAll('Users')
                    ->condition(['user_id'], 'Users', [$this->session::getSession('user_data')->getId()], '=')
                    ->get();
            
                $user = new User($userDb[0]->username, $userDb[0]->password, $userDb[0]->email, $userDb[0]->role, $userDb[0]->user_id);
                $this->session::setSession('user_data', $user);
                header('Location: /updateUserProfile');
            } 
            catch(\Exception $e){
                $this->session::setSession('error', ucfirst($e->getMessage()));
                header('Location:/updateUserProfile');
            }

        }
       
    }