<?php
    namespace App\Controllers;
    use App\Session;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\Model\User;
    class UpdateUserProfileController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            $userData = Session::getSession('user_data');
            echo View::render('updateUserProfile', [
                'userData' => $userData
            ]);
        }

        function edit(){
            
            $fields = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
            ];

            Registry::get('database')
                ->update('users', $fields)
                ->get();

            $userDb = Registry::get('database')
                ->selectAll('Users')
                ->condition('username', 'Users', $fields['username'], '=')
                ->get();
            
            try{
                $user = new User($userDb[0]['username'], $userDb[0]['password'], $userDb[0]['email'], $userDb[0]['role'], $userDb[0]['user_id']);
            } 
            catch(\Exception $e){
                echo $e->getMessage();
            }  
            
            Session::setSession('user_data', $user);
            
            header('Location: /updateUserProfile');

        }
       
    }