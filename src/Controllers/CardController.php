<?php
namespace App\Controllers;
use App\Request;
use App\Session;
use App\Controller;
use App\Registry;
use App\View;
use App\FormHandler;

class CardController extends Controller {
    
    // Constructor
    function __construct($session,$request)
    {
        parent::__construct($session,$request);
    }        

    // Display user cards
    function showCards(){
        // Check if form data is submitted
        if($_POST){
            // If subscription is canceled, redirect to payment cancel page
            if($_POST['subscription'] == 'cancel'){
                header('Location:/payment/cancel');
                exit();
            }
            // Otherwise, set the subscription type in the session
            else {
                $this->session::setSession('subscription_type', $_POST['subscription']);
            }
        }
        // If no form data, check subscription type in session
        else {
            // Redirect to payment cancel page if subscription type is invalid
            if($this->session::getSession('subscription_type') != 'month' && $this->session::getSession('subscription_type') != 'trial'){
                header('Location:/payment/cancel');
            }
        }

        // Get user's cards from the database
        $userCard = Registry::get('database')
            ->selectAll('Cards')
            ->condition(['user_id'], 'Cards', [$this->session::getSession('user_data')->getId()], '=')
            ->get();
        
        // Render cards view if user has cards, otherwise redirect to showPayment page
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

    // Display add card form
    function add(){
        // Render addCard view if subscription type is set in the session
        if($this->session::checkSession('subscription_type')){
            echo View::render('addCard', [
                'subscription' => $this->session::getSession('subscription_type'),
                'type' => 'add',
            ]);
        }
    }

    // Add new card
    function addCard(){
        // Define card fields from form data
        $card_fields = [
            'name' => $_POST['name'],
            'card' => $_POST['card'],
            'cvv' => $_POST['cvv'],
            'user_id' => $this->session::getSession('user_data')->getId()
        ];

        // Check if the card already exists for the user
        $userCards = Registry::get('database')
            ->selectAll('Cards')
            ->condition(['card', 'user_id'], 'Cards', [$card_fields['card'], $card_fields['user_id']], '=')
            ->get();
        
        // If the card does not exist, insert it into the database
        if(sizeof($userCards) == 0){
            Registry::get('database')
                ->insert('Cards', $card_fields)
                ->get();
        }
        
        // Redirect to showCards page
        header('Location:/card/showCards');
    }
}
