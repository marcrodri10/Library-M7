<?php
include_once 'partials/header.tpl.php';
use App\Session;


?>

<body>
    <?php include_once 'partials/nav.tpl.php'; ?>
    <div class="subscriptions b-flex-center-center-col">
        <h1>Subscriptions plans</h1>
        <form action="/card/formHandler" method="post" class="b-flex-center-center-row subscription-form">
            <?php 
            if(Session::getSession('user_subscription') === false){
                include_once 'partials/subscriptionTrial.tpl.php';
                include_once 'partials/subscriptionMonth.tpl.php';
            }
            ?>
            
            <?php 
  
            if(Session::getSession('user_subscription') !== false ){
                if(Session::getSession('user_subscription')->getIsActive() == 1){
                    if(Session::checkSession('days_to_finish') && Session::getSession('days_to_finish') <= 10){
                        echo '<h2 class="text-align">Your subscription will finish in '. Session::getSession('days_to_finish') .' days</h2>
                            <button class="btn btn-primary" name="subscription" value="renew">Renew subscription</button>';
                    }
                    
                    include_once 'partials/cancelSubscription.tpl.php';
                }
                else {
                    include_once 'partials/subscriptionMonth.tpl.php';
                }
            }
            
            
            ?>
          
        </div>
        </form>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-icon" viewBox="0 0 16 16">
        <path
            fill-rule="evenodd"
            d="M13.86 3.85a1 1 0 011.41 1.41l-7 7a1 1 0 01-1.41 0l-3-3a1 1 0 111.41-1.41L7 10.17l6.42-6.42a1 1 0 011.41 0z"
        />
    </symbol>
</svg>
</body>

</html>
