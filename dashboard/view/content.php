<?php 

    if (isset($_GET['p'])) {
        $p = $_GET['p'];
        include "./control/$p.php";
    }else{
        include "./control/index.php";
    }