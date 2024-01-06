<?php
include_once 'partials/header.tpl.php';
?>

<body>
    <div class="vh-100 register-form h-100 d-flex justify-content-center align-items-center flex-column">
        <h1>Register</h1>
        <form action="/register/edit" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name='password' required>
            </div>
            <div class="mb-3">
                <label for="confirmpass" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmpass" name='confirmpass' required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    
</body>

</html>