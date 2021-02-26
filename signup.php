
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
    
    <div class="signup-container">
        <form class="signup-form" id="signup-form">
            <div class="form-group text-right header">
                <span>Sign Up </span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control username" id="username" placeholder="Username" autocomplete="off">
                <div class="username-error error" id="username-error">

                </div>
            </div>
            <div class="form-group">
                <input type="text" class="fullname form-control" id="fullname" placeholder="Fullname" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="email" class="form-control email" id="email" placeholder="Email Address" autocomplete="off">
                <div class="error email-error" id="email-error"></div>
            </div>
            <div class="form-group">
                <input type="number" class="form-control phone" id="phone" minlength="11" maxlength="11" placeholder="Phone Number" autocomplete="off">
            </div>
            <div class="form-group">
                
                <select name="gender" id="gender" class="form-control gender">
                    <option value="" selected disabled>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <input type="password" class="password form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="text" class="form-control activation" id="activation" placeholder="Authorization Code">
            </div>
            <div class="signup-error error" id="signup-error">

            </div>
            <div class="form-group text-right">
                <button class="btn btn-primary" id="btn-signup">Create</button>
            </div>
            <div class="action text-center">
                <span>Already have an Account? </span> <a href="./login.php" class=" link text-success">Login</a>

            </div>
        </form>

    </div>
    <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="./js/sydeestack.js"></script>
    <script src="./js/functions.js"></script>
    <script src="./js/signup.js"></script>
</body>
</html>