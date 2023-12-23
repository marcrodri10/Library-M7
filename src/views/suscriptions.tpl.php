<?php
include_once 'partials/header.tpl.php';
use App\Session;

?>

<body>
    <div class="vh-100 register-form h-100 d-flex justify-content-center align-items-center flex-column">
        <h1>Suscriptions plans</h1>
        <form action="/suscriptions/edit" method="post">
        <div class="row">
            <?php 
            if(Session::getSession('user_suscription') === false || Session::getSession('user_suscription')['is_active'] == 0){
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
            ?>
            
            <?php 
            if(Session::getSession('user_suscription') === false){
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
          
        </div>
        </form>
    </div>
    
</body>

</html>