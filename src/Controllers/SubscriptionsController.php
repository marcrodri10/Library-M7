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
  
    // Constructor
    function __construct($session, $request)
    {
        parent::__construct($session, $request);
    }        
    
    // Display subscriptions view
    function index(){
        echo View::render('subscriptions');
    }

    // Handle subscription process
    function subscribe(){
        
        // Check if payment is made using an existing card or a new card
        if(array_keys($_POST)[0] == 'user-card'){
            $idCard = (explode('-', $_POST['user-card']))[3];
            $userCard = Registry::get('database')
                ->selectAll('Cards')
                ->condition(['card_id'], 'Cards', [$idCard], '=')
                ->get();
            $userCard = get_object_vars($userCard[0]);
            $type = explode('-',$_POST['user-card']);
        }
        else {
            // If using a new card, insert card data into the database
            $userCard = [
                'name' => $_POST['name'],
                'card' => $_POST['card'],
                'cvv' => $_POST['cvv'],
                'user_id' => $this->session::getSession('user_data')->getId()
            ];
            $type = explode('-', $_POST['payment']);
            
            Registry::get('database')
                ->insert('Cards', $userCard)
                ->get();
        }
        try{
            
            // Handle payment and subscription creation
            if($type[0] == 'pay'){
            
                // If user doesn't have an active subscription
                if($this->session::getSession('user_subscription') === false){

                    $currentDate = new DateTime();
                    
                    // Set subscription details based on payment type
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
                    
                    // Insert subscription data into the database
                    Registry::get('database')
                        ->insert('Subscriptions', $fields)
                        ->get();

                }
                // If user has an inactive subscription
                else if($this->session::getSession('user_subscription') !== false){
                    
                    // If the subscription was inactive, renew it
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
                        // If the subscription was active and user selects 'renew', extend the subscription
                        if($type[1] == 'renew'){
                            $start = new DateTime($this->session::getSession('user_subscription')->getStartDate());
                            $finish = new DateTime($this->session::getSession('user_subscription')->getFinishDate());
                            $fields = [
                                'user_id' => $this->session::getSession('user_data')->getId(),
                                'start_date' => $start->format('Y-m-d'),
                                'finish_date' => $finish->add(new DateInterval('P1M'))->format('Y-m-d'),
                                'is_active' => 1,
                                'type' => 'month',
                            ];

                            // Delete 'days_to_finish' session variable
                            $this->session::deleteSession('days_to_finish');
                        }
                    }
                    
                    // Update subscription data in the database
                    Registry::get('database')
                        ->update('Subscriptions', $fields)
                        ->condition(['user_id'], 'Subscriptions', [$this->session::getSession('user_data')->getId()], '=')
                        ->get();

                }
                // Create a Payment object
                $userSubscription = Registry::get('database')
                    ->selectAll('Subscriptions')
                    ->condition(['user_id'], 'Subscriptions', [$this->session::getSession('user_data')->getId()], '=')
                    ->get();

                
                $currentDate = new DateTime();
                
                $card = Registry::get('database')
                    ->select('Cards', ['card_id'])
                    ->condition(['card'], 'Cards', [$userCard['card']], '=')
                    ->get();
                $payment = new Payment($this->session::getSession('user_data')->getId(), $type[2], $currentDate->format('Y-m-d'), $card[0]->card_id);

                $paymentFields = [
                    'user_id' => $payment->getUserId(),
                    'amount' => $payment->getAmount(),
                    'date' => $payment->getDate(),
                    'card_id' => $payment->getCardId(),
                ];
                
                // Insert payment data into the database
                Registry::get('database')
                    ->insert('Payments', $paymentFields)
                    ->get(); 
                
                // Create a Subscription object
                $subscription = new Subscription($userSubscription[0]->user_id, $userSubscription[0]->start_date, 
                $userSubscription[0]->finish_date, $userSubscription[0]->is_active, $userSubscription[0]->type);

                // Set 'user_subscription' session variable
                $this->session::setSession('user_subscription', $subscription);
            }
            // Redirect to subscriptions page
            header('Location:/subscriptions');
             
        }
        // Handle exceptions
        catch(\Exception $e){
            // Set error message in session and redirect to subscriptions page
            $this->session::setSession('error', ucfirst($e->getMessage()));
            header('Location:/subscriptions');
        }
    }
}
