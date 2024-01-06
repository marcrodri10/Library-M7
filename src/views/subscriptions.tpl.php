<?php
include_once 'partials/header.tpl.php';
use App\Session;

?>

<body>
    <a href="/catalog">CATALOG</a>
    <div class="vh-100 register-form h-100 d-flex justify-content-center align-items-center flex-column">
        <h1>Subscriptions plans</h1>
        <form action="/payment/manageSubscription" method="post">
        
            <?php 
    
            if(Session::getSession('user_subscription') === false){
                echo '<div class="row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">1 month subscription</h5>
                            <p class="card-text">You will have access to our entire catalog.</p>
                            <button class="btn btn-primary" name="subscription" value="month">Subscribe</button>
                        </div>
                        </div>
                    </div>';
                echo '<div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">1 month trial</h5>
                    <p class="card-text">Start your free trial to have access to the entire catalog.</p>
                    <button class="btn btn-primary" name="subscription" value="trial">Subscribe</button>
                </div>
                </div>
            </div>';
            }
            ?>
            
            <?php 
  
            if(Session::getSession('user_subscription') !== false ){
                if(Session::getSession('user_subscription')->getIsActive() == 1){
                    if(Session::checkSession('days_to_finish') && Session::getSession('days_to_finish') <= 10){
                        echo '<h2 class="text-align">Your subscription will finish in '. Session::getSession('days_to_finish') .' days</h2>
                        <button class="btn btn-primary" name="subscription" value="renew">Renew subscription</button>';
                    }
                    
                    echo '<div class="row">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Your subscription</h5>
                            <p class="card-text">Started: '.Session::getSession('user_subscription')->getStartDate().'</p>
                            <p class="card-text">Ends: '.Session::getSession('user_subscription')->getFinishDate().'</p>
                            <p class="card-text">Type: '.ucfirst(Session::getSession('user_subscription')->getType()).'</p>
                            <button class="btn btn-danger" name="subscription" value="cancel">Cancel Subscription</button>
                        </div>
                        </div>
                    </div>';
                }
                else {
                    echo '<div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">1 month subscription</h5>
                            <p class="card-text">You will have access to our entire catalog.</p>
                            <button class="btn btn-primary" name="subscription" value="month">Subscribe</button>
                        </div>
                        </div>
                    </div>';
                }
            }
            
            
            ?>
          
        </div>
        </form>
    </div>
    
</body>

</html>