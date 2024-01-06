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
    class PaymentController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('payment');
        }

        function manageSubscription(){
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
                    ->condition('user_id', 'subscriptions', Session::getSession('user_data')->getId(), '=')
                    ->get();
                
                Session::getSession('user_subscription')->setIsActive(0);
                
            }
            header('Location:/subscriptions');
        }
        
       
    }