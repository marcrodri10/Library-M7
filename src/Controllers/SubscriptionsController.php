<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\View;
    use App\Registry;
    use DateTime;
    use App\FormHandler;
    use DateInterval;
    use App\Model\Subscription;
    use App\Model\Payment;
    class SubscriptionsController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('subscriptions');
        }

        function formHandler(){
            $handler = new FormHandler($_POST);
            $data = $handler->getPostData();
            $this->subscribe($data);
        }

        function subscribe($data){
            $card_fields = [
                'name' => $data['name'],
                'card' => $data['card'],
                'cvv' => $data['cvv'],
                'user_id' => Session::getSession('user_data')->getId()
            ];
            
            $userCard = Registry::get('database')
                ->selectAll('Cards')
                ->condition('user_id', 'Cards', Session::getSession('user_data')->getId(), '=')
                ->get();
            
            if(sizeof($userCard) == 0){
                Registry::get('database')
                    ->insert('Cards', $card_fields);
            }
            
            
            $type = explode('-', $data['payment']);
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
                    else if($type[1] == 'month'){
                    
                        $fields = [
                            'user_id' => Session::getSession('user_data')->getId(),
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'month',
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
                            'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'month',
                        ];
    
                        
                    }
                    else {
                        if($type[1] == 'renew'){
                            $finish = new DateTime(Session::getSession('user_subscription')->getFinishDate());
                            
                            $fields = [
                                'user_id' => Session::getSession('user_data')->getId(),
                                'start_date' => $finish->format('Y-m-d'),
                                'finish_date' => $finish->add(new DateInterval('P1M'))->format('Y-m-d'),
                                'is_active' => 1,
                                'type' => 'month',
                            ];

                            Session::deleteSession('days_to_finish');
                        }
                    }
                    Registry::get('database')
                        ->update('Subscriptions', $fields)
                        ->condition('user_id', 'Subscriptions', Session::getSession('user_data')->getId(), '=')
                        ->get();

                }
                $userSubscription = Registry::get('database')
                    ->selectAll('Subscriptions')
                    ->condition('user_id', 'Subscriptions', Session::getSession('user_data')->getId(), '=')
                    ->get();

                
                try{
                    $currentDate = new DateTime();
                    $payment = new Payment(Session::getSession('user_data')->getId(), $type[2], $currentDate->format('Y-m-d'));
                    
                    $paymentFields = [
                        'user_id' => $payment->getUserId(),
                        'amount' => $payment->getAmount(),
                        'date' => $payment->getDate(),
                    ];

                    Registry::get('database')
                        ->insert('payments', $paymentFields); 

                    $subscription = new Subscription($userSubscription[0]->user_id, $userSubscription[0]->start_date, 
                    $userSubscription[0]->finish_date, $userSubscription[0]->is_active, $userSubscription[0]->type);

                    Session::setSession('user_subscription', $subscription);
                }
                catch(\Exception $e){
                    echo $e->getMessage();
                }
                
                
    
                
            }
            header('Location:/subscriptions');

        }
        
       
    }