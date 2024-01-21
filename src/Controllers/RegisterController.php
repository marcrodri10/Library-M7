<?php
    namespace App\Controllers;
    use App\Request;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\FormHandler;
    use App\Model\User;
    use App\Model\Reader;
    class RegisterController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('register');
        }
        function registry(){
            try{
                if($_POST['password'] == $_POST['confirmpass']){
                    
                    $user = new User($_POST['username'], $_POST['password'], $_POST['email'], 'reader');
                    $fields = [
                        'username' => $user->getUsername(),
                        'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                        'email' => $user->getEmail(),
                        'role' => 'reader',
                    ];
                
                    try{
                        Registry::get('database')
                            ->insert('Users', $fields)
                            ->get();
                        $this->session::deleteSession('error');
                        
                        $userDb = Registry::get('database')
                            ->selectAll('Users')
                            ->condition(['username'], 'Users', [$fields['username']], '=')
                            ->get();

                        $user = new User($userDb[0]->username, $userDb[0]->password, $userDb[0]->email, $userDb[0]->role, $userDb[0]->user_id);
                        if($user->getRole() == 'reader'){
                            $reader_fields = [
                                'user_id' => $userDb[0]->user_id,
                            ];
                            Registry::get('database')
                                ->insert('Readers', $reader_fields)
                                ->get();
                            
                        }
                        header('Location:/login');
                    }
                    catch(\Exception $e){
                        $this->session::setSession('error', ucfirst($e->getMessage()));
                        header('Location:/register');
                    }

                }
                else throw new \Exception('Passwords do not match');
                
            }
            catch(\Exception $e){
                $this->session::setSession('error', ucfirst($e->getMessage()));
                header('Location:/register');
            }
           
        }
    }