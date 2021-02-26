<?php 
    $_SESSION['id'] = NULL;
    session_unset();
    session_destroy();
    header("Location: ../login.php");