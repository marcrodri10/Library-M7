<?php
    namespace App\Controllers;
    use App\Session;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\FormHandler;
    use App\Model\User;
    class UserProfileController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            $userData = $this->session::getSession('user_data');
            echo View::render('userProfile', [
                'userData' => $userData
            ]);
        }

        function formHandler(){
            $handler = new FormHandler($_POST);
            $data = $handler->getPostData();
            $this->edit($data);
        }
        function edit($data){
            

        }
       
    }