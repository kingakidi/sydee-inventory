<?php 
    require('./conn.php');
    require('./functions.php');
 
// CHECK USERNAME AVAILABILITY 
if (isset($_POST['checkUsername'])) {
   $u = checkForm($_POST['u']);

    //    CHECK FOR EMPTY FIELDS 
    if (empty($u)) {
        echo white("USERNAME IS REQUIRED");
    }else if(is_numeric($u[0])){
        echo white("USERNAME CAN'T START WITH NUMBER");
    }else if(strlen($u) < 5){
        echo white("MINIMUM OF 5 CHARACTER ");
    }else{
        $query = mysqli_query($conn, "SELECT * FROM users WHERE username ='$u'");
        if (!$query) {
            die(white("USERNAME CHECK FAILED"));
        }else if(mysqli_num_rows($query) > 0){
            echo white("USERNAME IS TAKEN");
        }else{
            echo white('Ok');
        }
    }
   
}

// SIGNUP 
if (isset($_POST['signup'])) {
    
   $u = checkForm($_POST['u']);
   $e = checkForm($_POST['e']);
   $fn = checkForm($_POST['fn']);
   $p = checkForm($_POST['p']);
   $g = checkForm($_POST['g']);
   $password = checkForm($_POST['password']); 
   $acode = checkForm( $_POST['acode']);

    //    CHECK FOR EMPTY FIELDS 
    if (empty($u) OR empty($e) OR empty($fn) OR empty($p) OR empty($g) OR empty($password) OR empty($acode)) {
        echo error("ALL FIELDS REQUIRED");
    }else if(is_numeric($u[0])){
        echo error("USERNAME CAN'T START WITH NUMBER");
    }else if(strlen($u) < 5){
        echo error("USERNAME: MINIMUM OF 5 CHARACTER");
    }else if(!filter_var($e, FILTER_VALIDATE_EMAIL)){
        echo error("INVALID EMAIL ADDRESS");
    }else if(strlen($p) < 11){
        echo error("INVALID PHONE NUMBER");

    }else if(strlen($password) < 8){
        echo error("PASSWORD: MINIMUM OF 8 CHARACTER");
    }else{

        $uQuery = mysqli_query($conn, "SELECT * FROM users WHERE username ='$u'");
        $eQuery = mysqli_query($conn, "SELECT * FROM users WHERE email ='$e'");
        $pQuery = mysqli_query($conn, "SELECT * FROM users WHERE phone ='$p'");

        if (!$uQuery || !$eQuery || !$pQuery) {
            die(error('ERROR VALIDATING FIELDS').mysqli_error($conn));
        }else{
            if (mysqli_num_rows($uQuery) > 0) {
                echo error("USERNAME IS TAKEN");
            }else if (mysqli_num_rows($eQuery) > 0) {
                echo error("EMAIL IS TAKEN");
            }else if (mysqli_num_rows($pQuery) > 0) {
                echo error("PHONE NUMBER IS TAKEN");
            }else if(strtolower($acode) !== 'esphem'){
                echo error("INVALID AUTH CODE");
            }else{
                // SEND TO DATABASE 
                $ph = password_hash($password, PASSWORD_DEFAULT);
                $v = $u.$e;
                $vcode =  password_hash($v, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users`( `username`, `fullname`, `email`, `phone`, `gender`, `password`, `type`, `verification_code`, `status`) VALUES ('$u', '$fn', '$e', '$p', '$g', '$ph', 'user', '$vcode', 'active')";
                $sQuery = mysqli_query($conn, $sql);

                if (!$sQuery) {
                    die(error("REGISTRATION FAILED"));
                }else{
                    if (!file_exists("../users/sydeestack_$p")) {
                        mkdir("../users/sydeestack_$p", 0777, true);
                        echo success('Registered Successfully');
                    }else{
                        echo "ERRO SUBMITTING YOUR FORM";
                    }
                 
                }
            }
        }
        
        
    }

   

   
}
// LOGIN

if (isset($_POST['login'])) {
    $u = checkForm($_POST['u']);
    $p = checkForm($_POST['p']);

    if (empty($u) || empty($p)) {
        echo error("ALL Field(s) Required");
    }else{
        $lQuery = mysqli_query($conn, "SELECT * FROM users WHERE username='$u' OR phone='$u' OR email='$u'");
        if (!$lQuery) {
            die(error("VERIFICATION FAILED ").mysqli_error($conn));
        }else if(mysqli_num_rows($lQuery) < 1){
            echo error("INVALID USER");
        }else{
            $row = mysqli_fetch_assoc($lQuery);
            $dbPassword = $row['password'];
           
            if ( password_verify($p, $dbPassword)) {
                
              $id = $row['id'];
              $username = $row['username'];
              $phone = $row['phone'];
              $email = $row['email'];
                $_SESSION['eId'] = $id;
                $_SESSION['eEmail'] = $email;
                $_SESSION['ePhone'] = $phone;
                echo success("LOGIN SUCCESSFULLY");
            }else{
                echo error("INVALID PASSWORD");
            }
        }
    }

}

// SEARCH ITEM 
if (isset($_POST['searchItem'])) {
    $userid = $_SESSION['eId'];
    $searchTerm = $_POST['searchTerm'];

    // GET USER BRANCH ID 
    $uPQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
    if (!$uPQuery) {
        die(error("PASSWORD VERIFICATION FAILED"));
    }else{
        
        $bId = mysqli_fetch_assoc($uPQuery)['branch_id'];
        
        // SEND SEARCH QUERY FOR ITEM 
        if (!$bId) {
            die("USER BRANCH VERIFICATION FAILED");
        }
        $iBQuery = mysqli_query($conn, "SELECT * FROM `branch_items` JOIN items ON branch_items.item_id = items.id WHERE branch_id=$bId AND items.name LIKE '%$searchTerm%'");
        if (!$iBQuery) {
            die(error("ITEM FAILES"));
        }else if(mysqli_num_rows($iBQuery) > 0){
            echo '
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>IMAGE</th>                      
                    <th>ITEM NAME</th>
                    <th>QTY</th>
                    <th>PRICE</th>
                    <th>STATUS</th>  
                    <th>CART</th>                      
                </tr>
            </thead>
            <tbody>
            ';
            $sn = 0;
            while ($row = mysqli_fetch_assoc($iBQuery)) {
                $sn++;
                $id = $row['id'];
                $user_id = $row['user_id'];
                $itemName = strtoupper($row['name']);
                $qty = $row['qty'];
                $sp =$row['selling_price'];
                $image = $row['image'];
                $uId = $row['user_id'];
                $status = $row['status'];
                $date = $row['date'];

                $phoneQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id");
                if (!$phoneQuery) {
                    die("IMAGE FETCH FAILS");
                }else{
                    $p = mysqli_fetch_assoc($phoneQuery)['phone'];
                }
                
                echo "                   
                    <tr>
                        <td>$sn</td>
                        <td><img src='./users/sydeestack_$p/$image' alt='' style='width: 40px; height: 40px'></td>
                        
                        
                        <td><a href='' name='itemaction' id='$id'>$itemName</a></td>
                        <td>$qty</td>
                        
                        <td>$sp</td>
                        <td>$status</td>
                        <td><button class='buyitem btn btn-info' id='buyitem'>Sale</button> </td>
                        
                    </tr>
                ";
                
                
            }
        }else{
            echo success("$searchTerm NOT AVAILABLE");
        }
        
    }


}