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
      
    function __construct($session, $request) {
        parent::__construct($session, $request);
    }        
        
    function index() {
        // Retrieve user data from the session
        $userData = $this->session::getSession('user_data');
        echo View::render('updateUserProfile', [
            'userData' => $userData
        ]);
    }

    function edit() {
        // Initialize an empty array to store fields to be updated
        $fields = [];

        // Iterate through POST data and populate the fields array
        foreach ($_POST as $key => $value) {
            if ($value != '') {
                // Hash the password if the key is 'password'
                if ($key == 'password') {
                    $fields = array_merge($fields, [$key => password_hash($value, PASSWORD_DEFAULT)]);
                } else {
                    $fields = array_merge($fields, [$key => $value]);
                }
            }
        }

        try {
            // Update user data in the database
            Registry::get('database')
                ->update('Users', $fields)
                ->condition(['user_id'], 'Users', [$this->session::getSession('user_data')->getId()], '=')
                ->get();

            // Retrieve the updated user data from the database
            $userDb = Registry::get('database')
                ->selectAll('Users')
                ->condition(['user_id'], 'Users', [$this->session::getSession('user_data')->getId()], '=')
                ->get();

            // Create a new User object with the updated data
            $user = new User($userDb[0]->username, $userDb[0]->password, $userDb[0]->email, $userDb[0]->role, $userDb[0]->user_id);

            // Update the user data in the session
            $this->session::setSession('user_data', $user);

            // Redirect to the update user profile page
            header('Location: /updateUserProfile');
        } catch (\Exception $e) {
            // Set an error message in the session and redirect to the update user profile page
            $this->session::setSession('error', ucfirst($e->getMessage()));
            header('Location:/updateUserProfile');
        }
    }
}
