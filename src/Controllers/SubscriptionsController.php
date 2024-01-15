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

        function subscribe($data=[]){
            if(array_keys($data)[0] == 'user-card'){
                $idCard = (explode('-', $data['user-card']))[3];
                $userCard = Registry::get('database')
                    ->selectAll('Cards')
                    ->condition(['card_id'], 'Cards', [$idCard], '=')
                    ->get();
                
                $type = explode('-',$data['user-card']);
            }
            else {
                $card_fields = [
                    'name' => $data['name'],
                    'card' => $data['card'],
                    'cvv' => $data['cvv'],
                    'user_id' => $this->session::getSession('user_data')->getId()
                ];
                $type = explode('-', $data['payment']);
                
                Registry::get('database')
                    ->insert('Cards', $card_fields)
                    ->get();
            }
            try{
                
                if($type[0] == 'pay'){
                
                    if($this->session::getSession('user_subscription') === false){

                        $currentDate = new DateTime();
                        
                        if($type[1] == 'trial'){
                        
                            $fields = [
                                'user_id' => $this->session::getSession('user_data')->getId(),
                                'start_date' => $currentDate->format('Y-m-d'),
                                'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                                'is_active' => 1,
                                'type' => 'trial',
                            ];
            
                        }
                        else if($type[1] == 'month'){
                        
                            $fields = [
                                'user_id' => $this->session::getSession('user_data')->getId(),
                                'start_date' => $currentDate->format('Y-m-d'),
                                'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                                'is_active' => 1,
                                'type' => 'month',
                            ];
                            
                        }
                        
                        Registry::get('database')
                            ->insert('Subscriptions', $fields)
                            ->get();

                    }

                    else if($this->session::getSession('user_subscription') !== false){
                        
                        if($this->session::getSession('user_subscription')->getIsActive() == 0){
                            $currentDate = new DateTime();
                            
                            $fields = [
                                'user_id' => $this->session::getSession('user_data')->getId(),
                                'start_date' => $currentDate->format('Y-m-d'),
                                'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                                'is_active' => 1,
                                'type' => 'month',
                            ];
        
                            
                        }
                        else {
                            if($type[1] == 'renew'){
                                $finish = new DateTime($this->session::getSession('user_subscription')->getFinishDate());
                                
                                $fields = [
                                    'user_id' => $this->session::getSession('user_data')->getId(),
                                    'start_date' => $finish->format('Y-m-d'),
                                    'finish_date' => $finish->add(new DateInterval('P1M'))->format('Y-m-d'),
                                    'is_active' => 1,
                                    'type' => 'month',
                                ];

                                $this->session::deleteSession('days_to_finish');
                            }
                        }
                        
                        Registry::get('database')
                            ->update('Subscriptions', $fields)
                            ->condition(['user_id'], 'Subscriptions', [$this->session::getSession('user_data')->getId()], '=')
                            ->get();

                    }
                    $userSubscription = Registry::get('database')
                        ->selectAll('Subscriptions')
                        ->condition(['user_id'], 'Subscriptions', [$this->session::getSession('user_data')->getId()], '=')
                        ->get();

                    
                    $currentDate = new DateTime();
                    $payment = new Payment($this->session::getSession('user_data')->getId(), $type[2], $currentDate->format('Y-m-d'));
                    
                    $paymentFields = [
                        'user_id' => $payment->getUserId(),
                        'amount' => $payment->getAmount(),
                        'date' => $payment->getDate(),
                    ];

                    Registry::get('database')
                        ->insert('payments', $paymentFields)
                        ->get(); 

                    $subscription = new Subscription($userSubscription[0]->user_id, $userSubscription[0]->start_date, 
                    $userSubscription[0]->finish_date, $userSubscription[0]->is_active, $userSubscription[0]->type);

                    $this->session::setSession('user_subscription', $subscription);
                }
                header('Location:/subscriptions');
                 
            }
            catch(\Exception $e){
                $this->session::setSession('error', ucfirst($e->getMessage()));
                //$this->session::setSession('type_subscription', $type[1]);
                header('Location:/subscriptions');
            }
            

        }
        
       
    }