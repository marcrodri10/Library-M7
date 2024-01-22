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
  
    // Constructor
    function __construct($session, $request)
    {
        parent::__construct($session, $request);
    }        
    
    // Display registration form
    function index(){
        echo View::render('register');
    }

    // Handle user registration
    function registry(){
        try{
            // Check if passwords match
            if($_POST['password'] == $_POST['confirmpass']){
                
                // Create a User object
                $user = new User($_POST['username'], $_POST['password'], $_POST['email'], 'reader');
                $fields = [
                    'username' => $user->getUsername(),
                    'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                    'email' => $user->getEmail(),
                    'role' => 'reader',
                ];
            
                try{
                    // Insert user data into the database
                    Registry::get('database')
                        ->insert('Users', $fields)
                        ->get();
                    $this->session::deleteSession('error');
                    
                    // Retrieve the newly created user
                    $userDb = Registry::get('database')
                        ->selectAll('Users')
                        ->condition(['username'], 'Users', [$fields['username']], '=')
                        ->get();

                    // Create a User object with retrieved data
                    $user = new User($userDb[0]->username, $userDb[0]->password, $userDb[0]->email, $userDb[0]->role, $userDb[0]->user_id);

                    // If the user is a reader, insert reader data into the database
                    if($user->getRole() == 'reader'){
                        $reader_fields = [
                            'user_id' => $userDb[0]->user_id,
                        ];
                        Registry::get('database')
                            ->insert('Readers', $reader_fields)
                            ->get();
                        
                    }
                    // Redirect to login page after successful registration
                    header('Location:/login');
                }
                catch(\Exception $e){
                    // Set error message in session and redirect to register page
                    $this->session::setSession('error', ucfirst($e->getMessage()));
                    header('Location:/register');
                }

            }
            else throw new \Exception('Passwords do not match');
            
        }
        catch(\Exception $e){
            // Set error message in session and redirect to register page
            $this->session::setSession('error', ucfirst($e->getMessage()));
            header('Location:/register');
        }
       
    }
}
