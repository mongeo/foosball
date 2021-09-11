<?php
session_start();

//checks whether user has logged in
if (isset($_SESSION['username'])) {
    header('Location: ../dash/dash.php'); //sends users to login screen if they haven't logged in
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
        <script src="../js/form-validation.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/signin.css">
    </head>
    <body class="text-center">
        <div class="form-signin">
            <h1 class='title'>Lordofthepickem</h1>
            <form method="POST" action="register_process.php" name="registration">
                <h1 class="h3 mb-3 font-weight-normal">Register</h1>
                
                <label for="username" class="sr-only">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
                
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                
                <label for="cpassword" class="sr-only">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" required>
                
                <label for="email" class="sr-only">Email</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
                
                <button class="btn btn-lg btn-primary btn-block" id="registerBtn" type="submit">Register</button>
                <div id="responseMsg"></div>
            </form>
            <a class="strong" href="sign_in.php"> Sign in </a>
        </div>
    </body>
</html>