<?php
include_once 'partials/header.tpl.php';
use App\Session;


?>

<body>
    <?php include_once 'partials/nav.tpl.php'; ?>
    <div class="subscriptions b-flex-center-center-col">
        <h1>Subscriptions plans</h1>
        <form action="/card/showCards" method="post" class="b-flex-center-center-row subscription-form">
            <div class="subscriptions-group b-flex-center-center-row">
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
                        echo '<div class="renew-sub b-flex-center-center-col"><div class="b-flex-center-center-col"><h2 class="text-align">Your subscription will finish in '. Session::getSession('days_to_finish') .' days</h2>
                        <button class="cssbuttons-io-button" name="subscription" value="renew">
                        Renew
                        <div class="icon">
                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </button></div>';
                    }
                    
                    include_once 'partials/cancelSubscription.tpl.php';
                    echo '</div>';
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
