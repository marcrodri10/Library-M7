<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\Registry;
    use App\View;
    use App\FormHandler;
    class CardController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        function formHandler(){

            $handler = new FormHandler($_POST);
            $data = $handler->getPostData();
            $this->showCards($data);
        }
        function showCards($data=[]){
            if($data){
                if($data['subscription'] == 'cancel'){
                    
                    header('Location:/payment/cancel');
                    exit();
                }
                else {
                    $this->session::setSession('subscription_type', $data['subscription']);
                    
                }
            }
            else {
                
                if($this->session::getSession('subscription_type') != 'month' && $this->session::getSession('subscription_type') != 'trial'){
                    header('Location:/payment/cancel');
                }
            }
            
            $userCard = Registry::get('database')
                ->selectAll('Cards')
                ->condition(['user_id'], 'Cards', [$this->session::getSession('user_data')->getId()], '=')
                ->get();
            
            if(sizeof($userCard) != 0){
                echo View::render('cards', [
                    'cards' => $userCard,
                    'subscription' => $this->session::getSession('subscription_type'),
                ]);
            }
            else {
                header('Location:/payment/showPayment');
            }
            
        }

        function add(){
            if($this->session::checkSession('subscription_type')){
                echo View::render('addCard', [
                    'subscription' => $this->session::getSession('subscription_type'),
                    'type' => 'add',
                ]);
            }
        }
        function addCard(){
            $card_fields = [
                'name' => $_POST['name'],
                'card' => $_POST['card'],
                'cvv' => $_POST['cvv'],
                'user_id' => $this->session::getSession('user_data')->getId()
            ];

            $userCards = Registry::get('database')
                ->selectAll('Cards')
                ->condition(['card', 'user_id'], 'Cards', [$card_fields['card'], $card_fields['user_id']], '=')
                ->get();
            
            if(sizeof($userCards) == 0){
                Registry::get('database')
                    ->insert('Cards', $card_fields)
                    ->get();
            }
            
            header('Location:/card/showCards');
        }

       
    }