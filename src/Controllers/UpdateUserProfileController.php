<?php
    namespace App\Controllers;
    use App\Session;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
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
            $params = explode("/", $this->request->getParam());
            
            $fields = [
                'username' => $params[0],
                'email' => $params[1],
            ];

            Registry::get('database')
                ->update('users', $fields)
                ->get();

            Session::setSession('user_data', $fields);
            
            header('Location: /updateUserProfile');

        }
       
    }