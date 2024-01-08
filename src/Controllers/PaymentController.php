<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\View;
    use App\Registry;
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
        

        function manageSubscription(){
            if($_POST['subscription'] != 'cancel'){
                $this->showPayment();
            }
            else $this->cancel();
        }
        function showPayment(){
            $userCard = Registry::get('database')
                ->selectAll('Cards')
                ->condition('user_id', 'Cards', Session::getSession('user_data')->getId(), '=')
                ->get();
            
            try{
               
                if(!empty($userCard[0]->card) && !empty($userCard[0]->name) && !empty($userCard[0]->cvv)) {
                   
                    $userCard = new Card($userCard[0]->card_id, $userCard[0]->name, 
                    $userCard[0]->card,$userCard[0]->cvv);
                }
                else $userCard = [];
                echo View::render('payment', [
                    'subscription' => $_POST['subscription'],
                    'userCard' => $userCard,
                ]);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
            
        }

        function cancel(){
            if($_POST['subscription'] == 'cancel'){
                Registry::get('database')
                    ->update('Subscriptions', ['is_active' => 0])
                    ->condition('user_id', 'Subscriptions', Session::getSession('user_data')->getId(), '=')
                    ->get();
                
                Session::getSession('user_subscription')->setIsActive(0);
                
            }
            header('Location:/subscriptions');
        }
        
       
    }