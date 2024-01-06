<?php
    namespace App\Controllers;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;

    use App\Model\User;
    class RegisterController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('register');
        }

        function edit(){
            
            try {
                
                if($_POST['password'] == $_POST['confirmpass']){
                    
                    $user = new User($_POST['username'], $_POST['password'], $_POST['email'], 'reader');
                    $fields = [
                        'username' => $_POST['username'],
                        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                        'email' => $_POST['email'],
                        'role' => 'reader',
                    ];
                
                    
                    Registry::get('database')->insert('Users', $fields);
                    header('Location:/login');
                }
            }
            catch(\Exception $e){
                echo $e->getMessage();
                //header('Location:/register');
            }
           
            

        }
       
    }