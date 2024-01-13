<?php
    namespace App\Controllers;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\FormHandler;
    use App\Model\User;
    class RegisterController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('register');
        }
        function formHandler(){
            $handler = new FormHandler($_POST);
            $data = $handler->getPostData();
            $this->registry($data);
        }
        function registry($data){
            
          

                if($data['password'] == $data['confirmpass']){
                    
                    $user = new User($data['username'], $data['password'], $data['email'], 'reader');
                    $fields = [
                        'username' => $user->getUsername(),
                        'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                        'email' => $user->getEmail(),
                        'role' => 'reader',
                    ];
                
                    try{
                        Registry::get('database')->insert('Users', $fields);
                        $this->session::deleteSession('error');
                        header('Location:/login');
                    }
                    catch(\Exception $e){
                        $this->session::setSession('error', ucfirst($e->getMessage()));
                        header('Location:/register');
                    }
                    
                    
                    
                    
                }
            }
           
           
            

        
       
    }