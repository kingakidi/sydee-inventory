
<?php include "./control/conn.php"; 
     if (!isset($_SESSION['eId'])) {
        header("Location: ./login.php");
      }
   
    //   CHECK FOR USERTYPE       
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESPHEM COMPUTERS</title>
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
    
  
        <div class="search-container" id="search-container">
            <form class="search-form" id="search-form">
                <div class="form-group">
                    <input type="text" placeholder="SEARCH ITEM" class="form-control" id="search-term">
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
                <div class="show-search" id="show-search"></div>
            </form>
            
        </div>
        
 
    <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="./js/sydeestack.js"></script>
    <script src="./js/functions.js"></script>
    <script src="./js/index.js"></script>
</body>
</html>