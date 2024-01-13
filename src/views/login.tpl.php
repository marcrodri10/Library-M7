<?php
include_once 'partials/header.tpl.php';
use App\Session;
?>

<body>
    <div class="vh-100 register-form h-100 d-flex justify-content-center align-items-center flex-column">
        <h1>Login</h1>
        <a href="/register">REGISTER</a>
        <?php
            if(Session::checkSession('error')) {
                echo '<div class="error">'.Session::getSession('error').'</div>';
                Session::deleteSession('error');
            }
        ?>
        <form action="/login/formHandler" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name='password'>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    
</body>

</html>