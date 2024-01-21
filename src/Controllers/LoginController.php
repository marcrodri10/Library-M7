<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\FormHandler;
    use App\Model\User;
    use App\Model\Reader;
    use App\Model\Subscription;
    use DateTime;
    class LoginController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            //render login view
            echo View::render('login');
        }

        function log(){
            //save input variables in an array
            $fields = [
                'username' => $_POST['username'],
                'password' => $_POST['password'],
            ];

            
                       
            try{ 
                //get the user from the database
                $userDb = Registry::get('database')
                    ->selectAll('Users')
                    ->condition(['username'], 'Users', [$fields['username']], '=')
                    ->get();
                
                if(sizeof($userDb) > 0){
                    $user = new User($userDb[0]->username, $userDb[0]->password, $userDb[0]->email, $userDb[0]->role, $userDb[0]->user_id);
                    
                    if($fields['username'] == $user->getUsername()){
                        if(password_verify($fields['password'], $user->getPassword())){

                            if($user->getRole() == 'reader'){
                                $reader = Registry::get('database')
                                    ->selectAll('Readers')
                                    ->condition(['user_id'], 'Readers', [$user->getId()], '=')
                                    ->get();

                                if(sizeof($reader) > 0){
                                    $readerData = Registry::get('database')
                                        ->selectAll('Readers')
                                        ->join('Readers', 'Users', 'user_id', 'INNER')
                                        ->condition(['user_id'], 'Readers', [$user->getId()], '=')
                                        ->get();
                                   
                                    $readerClass = new Reader($readerData[0]->username, $readerData[0]->password,
                                        $readerData[0]->email, $readerData[0]->user_id, $readerData[0]->reader_id, $readerData[0]->readed_books);
                                    
                                    $this->session::setSession('user_data', $readerClass);
                                    
                                }
                                
                            }
                            else $this->session::setSession('user_data', $user);
                            
                            $userSubscription = Registry::get('database')
                                ->selectAll('Subscriptions')
                                ->condition(['user_id'], 'Subscriptions', [$user->getId()], '=')
                                ->get();
                            
                            if(sizeof($userSubscription) > 0) {
                                $subscription = new Subscription($user->getId(), $userSubscription[0]->start_date, 
                                $userSubscription[0]->finish_date, $userSubscription[0]->is_active, $userSubscription[0]->type);
                            }
                            else $subscription = false;
        
                         
                            $this->session::setSession('user_subscription', $subscription);
                            
                            $currentDate = new DateTime();
                            
                    
                            if($this->session::getSession('user_subscription') !== false) {
                                if($currentDate->format('Y-m-d') > Session::getSession('user_subscription')->getFinishDate()){
                                    Registry::get('database')
                                        ->update('Subscriptions', [
                                            'is_active' => 0,
                                        ])
                                        ->condition(['user_id'], 'Subscriptions', [$this->session::getSession('user_data')->getId()], '=')
                                        ->get();
                                    
                                    $this->session::getSession('user_subscription')->setIsActive(0);
                                }
                                else {
                                    $finish = new DateTime(Session::getSession('user_subscription')->getFinishDate());
        
                                    $now = new DateTime();
            
                                    $days = $finish->diff($now);
        
                                    $days = ($days->y)*365 + ($days->m)*30 + $days->d + 1;

                                    Session::setSession('days_to_finish', $days);
                                }
                            }
                            else $this->session::deleteSession('days_to_finish');
                            $this->session::deleteSession('error');
                            header('Location:/catalog');
                        }
                        else throw new \Exception('Incorrect password'); 
                    }  
                    
                }
                else {
                    throw new \Exception('User does not exist');          
                }
            }
            catch(\Exception $e){
                $this->session::setSession('error', ucfirst($e->getMessage()));
                header('Location:/login');
            }
            
            
        }
       
    }