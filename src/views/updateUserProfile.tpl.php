<?php
    include_once 'partials/header.tpl.php';
?>
<body>
    <h1>User Profile</h1>
    <a href="/catalog">Catalog</a>
    <div class="vh-100 register-form h-100 d-flex justify-content-center align-items-center flex-column">
        <h1>User Profile</h1>
        <form action="/updateUserProfile/edit" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value=<?php echo $userData['username']?>>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name='email' value=<?php echo $userData['email']?>>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>