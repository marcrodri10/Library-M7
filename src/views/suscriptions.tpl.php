<?php
include_once 'partials/header.tpl.php';
use App\Session;

?>

<body>
    <div class="vh-100 register-form h-100 d-flex justify-content-center align-items-center flex-column">
        <h1>Suscriptions plans</h1>
        <form action="/suscriptions/prueba" method="post">
        <div class="row">
            <?php 
    
            if(Session::getSession('user_suscription') === false){
                echo '<div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">1 year suscription</h5>
                            <p class="card-text">You will have access to our entire catalog.</p>
                            <button class="btn btn-primary" name="suscription" value="year">Suscribe</button>
                        </div>
                        </div>
                    </div>';
                echo '<div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">1 month trial</h5>
                    <p class="card-text">Start your free trial to have access to the entire catalog.</p>
                    <button class="btn btn-primary" name="suscription" value="trial">Suscribe</button>
                </div>
                </div>
            </div>';
            }
            ?>
            
            <?php 
  
            if(Session::getSession('user_suscription') !== false ){
                if(Session::getSession('user_suscription')['is_active'] == 1){
                    echo '<div class="col-sm-12 mb-3 mb-sm-0">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Your suscription</h5>
                            <p class="card-text">Started: '.Session::getSession('user_suscription')['start_date'].'</p>
                            <p class="card-text">Ends: '.Session::getSession('user_suscription')['finish_date'].'</p>
                            <p class="card-text">Type: '.ucfirst(Session::getSession('user_suscription')['type']).'</p>
                            <button class="btn btn-danger" name="suscription" value="cancel">Cancel Suscription</button>
                        </div>
                        </div>
                    </div>';
                }
                else {
                    echo '<div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">1 year suscription</h5>
                            <p class="card-text">You will have access to our entire catalog.</p>
                            <button class="btn btn-primary" name="suscription" value="year">Suscribe</button>
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