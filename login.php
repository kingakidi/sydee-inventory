<?php
    include './control/conn.php';
    if (isset($_SESSION['eId'])) {
        header("Location: ./dashboard/");
    }

 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESPHEM SIGNUP</title>
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon//favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="./vendor/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="login-container">
        <form class="login-form" id="login-form">
           
            
            <div class="form-group text-right header">
                <span>Login</span>
            </div>
            <div>
                <?php 
                    if (isset($_GET['register'])) {
                       echo '<div class="text-center text-info form-group">Account Registered Successfully Proceed to Login</div>';
                    }

                ?>
            </div>
            <div class="form-group">
                <input type="text" class="form-control username" id="username" placeholder="Username, Phone Number or Email" autocomplete="off">
                <div class="username-error error" id="username-error">

                </div>
            </div>
           
            <div class="form-group">
                <input type="password" class="password form-control" id="password" placeholder="Password">
            </div>
            <div class="error login-error" id="login-error"></div>
            <div class="form-group text-right">
                <button class="btn btn-primary" id="btn-login">Create</button>
            </div>
            <div class="action text-center">
                <span>Doesn't have an account? </span> <a href="./signup.php" class=" link text-success">Signup</a>

            </div>
        </form>

    </div>
    <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="./js/sydeestack.js"></script>
    <script src="./js/functions.js"></script>
    <script src="./js/login.js"></script>
</body>
</html>