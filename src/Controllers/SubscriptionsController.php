<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\View;
    use App\Registry;
    use DateTime;
    use DateInterval;
    class SubscriptionsController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('subscriptions');
        }

        function edit(){
            
            if(Session::getSession('user_subscription') === false){
                $currentDate = new DateTime();

                if($_POST['subscription'] == 'trial'){
                
                    $fields = [
                        'user_id' => Session::getSession('user_data')['user_id'],
                        'start_date' => $currentDate->format('Y-m-d'),
                        'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                        'is_active' => 1,
                        'type' => 'trial',
                    ];
    
                }
                else if($_POST['subscription'] == 'year'){
                
                    $fields = [
                        'user_id' => Session::getSession('user_data')['user_id'],
                        'start_date' => $currentDate->format('Y-m-d'),
                        'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                        'is_active' => 1,
                        'type' => 'year',
                    ];
                    
                }

                Registry::get('database')->insert('Subscriptions', $fields);

                
                
            
            }
            else if(Session::getSession('user_subscription') !== false){
                
                if(Session::getSession('user_subscription')['is_active'] == 0){
                    $currentDate = new DateTime();

                    $fields = [
                        'user_id' => Session::getSession('user_data')['user_id'],
                        'start_date' => $currentDate->format('Y-m-d'),
                        'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                        'is_active' => 1,
                        'type' => 'year',
                    ];

                    Registry::get('database')
                        ->update('subscriptions', $fields)
                        ->condition('user_id', 'subscriptions', Session::getSession('user_data')['user_id'], '=')
                        ->get();
                    
                }
                else {
                    if($_POST['subscription'] == 'cancel'){
                        Registry::get('database')
                            ->update('subscriptions', ['is_active' => 0])
                            ->condition('user_id', 'subscriptions', Session::getSession('user_data')['user_id'], '=')
                            ->get();
                    
                        Session::setSession('user_subscription', 0, 'is_active');
                    }
                    
                }
            }
            $userSubscription = Registry::get('database')
                ->selectAll('Subscriptions')
                ->condition('user_id', 'Subscriptions', Session::getSession('user_data')['user_id'], '=')
                ->get();
            
            Session::setSession('user_subscription', $userSubscription[0]);

            header('Location:/subscriptions');

        }
        function prueba(){
            if($_POST['subscription'] != 'cancel'){
                $this->showPayment();
            }
            else $this->cancel();
        }
        function showPayment(){
            $_COOKIE['subscription'] = $_POST['subscription'];
            include_once 'src/views/payment.tpl.php';
        }

        function cancel(){
            if($_POST['subscription'] == 'cancel'){
                Registry::get('database')
                    ->update('subscriptions', ['is_active' => 0])
                    ->condition('user_id', 'subscriptions', Session::getSession('user_data')['user_id'], '=')
                    ->get();
            
                Session::setSession('user_subscription', 0, 'is_active');
            }
            header('Location:/subscriptions');
        }
        function payment(){
            
            $type = explode('-', $_POST['payment']);
            if($type[0] == 'pay'){
                
                if(Session::getSession('user_subscription') === false){
                    $currentDate = new DateTime();
    
                    if($type[1] == 'trial'){
                    
                        $fields = [
                            'user_id' => Session::getSession('user_data')['user_id'],
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'trial',
                        ];
        
                    }
                    else if($type[1] == 'year'){
                    
                        $fields = [
                            'user_id' => Session::getSession('user_data')['user_id'],
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'year',
                        ];
                        
                    }
    
                    Registry::get('database')->insert('Subscriptions', $fields);
                    
                    
                }

                else if(Session::getSession('user_subscription') !== false){
                    
                    if(Session::getSession('user_subscription')['is_active'] == 0){
                        $currentDate = new DateTime();
    
                        $fields = [
                            'user_id' => Session::getSession('user_data')['user_id'],
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'year',
                        ];
    
                        Registry::get('database')
                            ->update('subscriptions', $fields)
                            ->condition('user_id', 'subscriptions', Session::getSession('user_data')['user_id'], '=')
                            ->get();
                        
                    }

                }
                $userSubscription = Registry::get('database')
                    ->selectAll('Subscriptions')
                    ->condition('user_id', 'Subscriptions', Session::getSession('user_data')['user_id'], '=')
                    ->get();

                $paymentFields = [
                    'user_id' => Session::getSession('user_data')['user_id'],
                    'amount' => $type[2],
                    'date' => $currentDate->format('Y-m-d'),
                ];
                Registry::get('database')
                    ->insert('payments', $paymentFields); 
                
                Session::setSession('user_subscription', $userSubscription[0]);
    
                
            }
            header('Location:/subscriptions');
        }
       
    }