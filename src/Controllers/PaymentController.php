<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\View;
    use App\Registry;
    use App\FormHandler;
    use App\Model\User;
    use DateTime;
    use DateInterval;
    use App\Model\Card;
use Exception;

    class PaymentController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function formHandler(){
            if(!$this->session::checkSession('type_subscription')){
                $handler = new FormHandler($_POST);
                $data = $handler->getPostData();
                $this->manageSubscription($data);
            }
            else $this->manageSubscription();
            
            
        }
        function manageSubscription($data = []){
            
            if($this->session::checkSession('type_subscription') || $data['subscription'] != 'cancel'){
                $this->showPayment($data);
            }
            else $this->cancel();
        }
        function showPayment($data = []){
            
            try{
                $userCard = Registry::get('database')
                ->selectAll('Cards')
                ->condition(['user_id'], 'Cards', [$this->session::getSession('user_data')->getId()], '=')
                ->get();
               
                if(!empty($userCard[0]->card) && !empty($userCard[0]->name) && !empty($userCard[0]->cvv)) {
                   
                    $userCard = new Card($userCard[0]->card_id, $userCard[0]->name, 
                    $userCard[0]->card,$userCard[0]->cvv);
                }
                else $userCard = [];

                if($this->session::checkSession('type_subscription')){
                    echo View::render('payment', [
                        'subscription' => $this->session::getSession('type_subscription'),
                        'userCard' => $userCard,
                    ]);
                }
                else {
                    echo View::render('payment', [
                        'subscription' => $data['subscription'],
                        'userCard' => $userCard,
                    ]);
                }
                
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
            
        }

        function cancel(){
            if($_POST['subscription'] == 'cancel'){
                Registry::get('database')
                    ->update('Subscriptions', ['is_active' => 0])
                    ->condition(['user_id'], 'Subscriptions', [$this->session::getSession('user_data')->getId()], '=')
                    ->get();
                
                $this->session::getSession('user_subscription')->setIsActive(0);
                
            }
            header('Location:/subscriptions');
        }
        
       
    }