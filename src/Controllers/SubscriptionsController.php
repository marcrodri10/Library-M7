<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\View;
    use App\Registry;
    use DateTime;
    use DateInterval;
    use App\Model\Subscription;
    class SubscriptionsController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('subscriptions');
        }

        function subscribe(){
            
            $type = explode('-', $_POST['payment']);
            if($type[0] == 'pay'){
                
                if(Session::getSession('user_subscription') === false){
                    $currentDate = new DateTime();
    
                    if($type[1] == 'trial'){
                    
                        $fields = [
                            'user_id' => Session::getSession('user_data')->getId(),
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'trial',
                        ];
        
                    }
                    else if($type[1] == 'year'){
                    
                        $fields = [
                            'user_id' => Session::getSession('user_data')->getId(),
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'year',
                        ];
                        
                    }
    
                    Registry::get('database')->insert('Subscriptions', $fields);
                    
                    
                }

                else if(Session::getSession('user_subscription') !== false){
                   
                    if(Session::getSession('user_subscription')->getIsActive() == 0){
                        $currentDate = new DateTime();
    
                        $fields = [
                            'user_id' => Session::getSession('user_data')->getId(),
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'year',
                        ];
    
                        Registry::get('database')
                            ->update('subscriptions', $fields)
                            ->condition('user_id', 'subscriptions', Session::getSession('user_data')->getId(), '=')
                            ->get();
                        
                    }

                }
                $userSubscription = Registry::get('database')
                    ->selectAll('Subscriptions')
                    ->condition('user_id', 'Subscriptions', Session::getSession('user_data')->getId(), '=')
                    ->get();

                $currentDate = new DateTime();
                $paymentFields = [
                    'user_id' => Session::getSession('user_data')->getId(),
                    'amount' => $type[2],
                    'date' => $currentDate->format('Y-m-d'),
                ];
                Registry::get('database')
                    ->insert('payments', $paymentFields); 
                
                try{
                    $subscription = new Subscription($userSubscription[0]->user_id, $userSubscription[0]->start_date, 
                    $userSubscription[0]->finish_date, $userSubscription[0]->is_active, $userSubscription[0]->type);
                }
                catch(\Exception $e){
                    echo $e->getMessage();
                }
                Session::setSession('user_subscription', $subscription);
    
                
            }
            header('Location:/subscriptions');

        }
        
       
    }