<?php 
    include "./functions.php";
    $userid = $_SESSION['eId'];
    // ADD CATEGORY 
    if (isset($_POST['AddCategory'])) {
        $cName = checkForm($_POST['cName']);
        if (!empty($cName)) {
            // CHECK IF CATEGORY DOES NOT EXIST IN DB
            $cCQuery = mysqli_query($conn, "SELECT * FROM category WHERE category_name='$cName'");
            if (!$cCQuery) {
                die(error("CATEGORY FAILS"));
            }else if(mysqli_num_rows($cCQuery) > 0){
                echo error("CATEGORY ALREADY EXIST");
            }else{
                // SEND VALUE TO DB
                $aCQuery = mysqli_query($conn, "INSERT INTO `category`( `category_name`, `user_id`) VALUES ('$cName', $userid)");
                if (!$aCQuery) {
                    die("CATEGORY FAILED");
                }else{
                    echo success("CATEGORY ADDED SUCCESSFULLY");
                }
            }
        }
    }
    // ADD SUB CATEGORY 
    if (isset($_POST['addSubCategory'])) {
        $cName = checkForm($_POST['cName']);
        $sCName = checkForm($_POST['sCName']);
        
        // CHECK FOR EMPTY FIELDS
        if (empty($cName) || empty($sCName)) {
            echo error("ALL FIELDS(s) REQUIRED");
        }else{
             // CHECK IF SUB CATEGORY ALREADY EXIST ON THE USING CATEGORY ID 
             $sCQuery = mysqli_query($conn, "SELECT * FROM sub_category WHERE sub_category_name='$sCName' AND category_id=$cName");
             if (!$sCQuery) {
                 die("SUB CATEGORY CHECK FAILED ");
             }else{
                 if (mysqli_num_rows($sCQuery) > 0) {
                    echo error("SUB CATEGORY ALREADY EXIST FOR THIS CATEGORY");
                 }else{
                      // SEND TO SUB CATEGORY IF NULL 
                     
                      $sSCQuery = mysqli_query($conn, "INSERT INTO `sub_category`(`category_id`, `sub_category_name`, `user_id`) VALUES ($cName, '$sCName', $userid)");
                      if (!$sSCQuery) {
                          die("FAILED TO UPLOAD SUB CATEGORY");
                      }else{
                          echo success("SUB CATEGORY ADDED SUCCESSFULLY");
                      }
                 }
             }
        }
       
       

    }
    // SUB CATEGORY QUERY 
    if (isset($_POST['subCategoryList'])) {
       $catId = $_POST['subCategoryList'];

       $sBQuery = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id=$catId");
       
       if (!$sBQuery) {
           die("SUB CATEGORY FAILED ");
       }else if(mysqli_num_rows($sBQuery) > 0){
        echo "<option value='' selected disabled>SELECT SUB CATEGORY </option>";
            while ($row = mysqli_fetch_assoc($sBQuery)) {
                $sCName = strtoupper($row['sub_category_name']);
                $sCId = $row['id'];
                echo "<option value='$sCId'>$sCName</option>";
            }
       }else{
        echo "<option value='' selected disabled>NO SUB CATEGORY </option>";
       }
       
    }
    // ADDING ITEMS 
    if (isset($_POST['submitItemForm'])) {

        $cat = checkForm($_POST['category']);
        $subCat = checkForm($_POST['subCategory']);
        $itemName = checkForm($_POST['itemName']);
        $qty = checkForm($_POST['qty']);
        $cP = checkForm($_POST['costPrice']);
        $sP = checkForm($_POST['sellingPrice']);
        $fName = $_FILES['image']['name'];
        $size = $_FILES['image']['size'];
        $type = $_FILES['image']['type'];
        $tmp = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($fName, PATHINFO_EXTENSION));
  
        $extArray = ['jpeg', 'JPG', 'jpg', 'JPG', 'png', 'PNG'];
        
        
        if (!in_array($ext, $extArray)) {
            echo error("INVALID FILE TYPE ");
        }elseif (!empty($cat) && !empty($subCat) && !empty($itemName) && !empty($qty) && !empty($cP) && !empty($sP) && !empty($_FILES)) {
        //    CHECK IF ITEM ALREADY EXIST 
            $cIQuery = mysqli_query($conn, "SELECT * FROM `items` WHERE category_id=$cat AND sub_category_id=$subCat and name ='$itemName'");
            if (!$cIQuery) {
                die("ITEM CHECK FAILED ");
            }else if(mysqli_num_rows($cIQuery) > 0){
                echo error("ITEM ALREADY EXIST ");
            }else{
                // IF NULL SEND DETAILS TO DB AND MOVE FILED TO LOGIN USER FOLDER 
                  
                $nCFName = $userid."_".$itemName."_".date("Y-m-d").".".$ext;
                $cd = dirname(__DIR__, 2);
                $p = $_SESSION['ePhone'];
                if (move_uploaded_file($tmp, $cd."/users/sydeestack_$p/$nCFName")) {

                    $sql = "INSERT INTO `items`(`category_id`, `sub_category_id`, `name`, `qty`, `cost_price`, `selling_price`, `image`, `user_id`) VALUES ($cat, $subCat, '$itemName', $qty, $cP, $sP, '$nCFName', $userid)";


                    $aIQuery = mysqli_query($conn, $sql);
                    if (!$aIQuery) {
                        die(error("ADDING ITEM FAILED "));
                    }else{
                        
                        echo success("ITEM ADDED SUCCESSFULLY");
                    }
                }


                
            }
        
        }else{
            echo erro("ALL FILLED REQUIRED");
        }
    }
    // CREATE BRANCH QUERY 
    if (isset($_POST['createBranch'])) {
        // GET && CLEAN ALL THE VARIABLES 
      
        $bName = checkForm($_POST['bName']);
        $address = checkForm($_POST['address']);
        $fType = checkForm($_POST['fType']);
        $nOfShops = checkForm($_POST['nOfShops']);
        $rentalCost = checkForm($_POST['rentalCost']);
        $expringDate = checkForm($_POST['expiringDate']);
        $password = checkForm($_POST['password']);
      
        $pCQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$pCQuery) {
            die(error("PASSWORD VERIFICATION FAILED"));
        }else{
            $dbPassword = mysqli_fetch_assoc($pCQuery)['password'];
             // CHECK IF PASSWORD IS CORRECT 
           if(password_verify($password, $dbPassword)){
                 // CHECK BRANCH EXISTENCE
            $bVQuery = mysqli_query($conn, "SELECT * FROM branch WHERE branch_name='$bName'");
            if (!$bVQuery) {
                die("BRANCH NAME VERIFICATION FAILED");
            }else if(mysqli_num_rows($bVQuery) > 0){
                echo error("BRANCH NAME ALREADY EXIST");
            }else{
                // SEND BRANCH TO DATABASE 
                $sql = "INSERT INTO `branch`( `branch_name`, `branch_address`, `facility_type`, `user_id`, `number_of_shops`, `rental_cost`, `rental_expiring_date`, `status`) VALUES ('$bName', '$address', '$fType', $userid, $nOfShops, $rentalCost, '$expringDate', 'active')";
                $bQuery = mysqli_query($conn, $sql);
                if (!$bQuery) {
                    die("BRANCH OPERATION FAILED ");
                }else{
                    echo success("BRANCH ADDED SUCCESSFULLY");
                }
            }
           }else{
               echo error("INVALID PASSWORD");
           }
        }
       
        
        
        
    }
    // ITEM ON SUB CATEGORY 
    if (isset($_POST['itemSubCategoryList'])) {
        $subCatId = $_POST['itemSubCategoryList'];
        if (!empty($subCatId)) {
            $iQuery = mysqli_query($conn, "SELECT * FROM items WHERE sub_category_id=$subCatId");
            if (!$iQuery) {
                die(error("<option value=''>FAILED TO GET ITEMS </option>"));
            }else if(mysqli_num_rows($iQuery) > 0){
                echo "<option value='' disabled selected>SELECT ITEM</option>";
                while ($row = mysqli_fetch_assoc($iQuery)) {
                    $id = $row['id'];
                    $name = strtoupper($row['name']);
                    echo "<option value='$id'>$name</option>";
                }
            }else{
                echo "<option value=''>NO ITEM UPLOADED </option>";
            }
        }

    }
    // ITEM TO FETCH 
    if (isset($_POST['itemIdToFetch'])) {
      $id = $_POST['itemIdToFetch'];

      $iQuery = mysqli_query($conn, "SELECT * FROM items WHERE id=$id AND status='active'");
      if (!$iQuery) {
          die(error("FAILED TO FETCH ITEM"));
      }else{
        //   SHOW ITEM DETAILS
        $row = mysqli_fetch_assoc($iQuery);

 
        $iId = $row['id'];
        $name = strtoupper($row['name']);
        $qty = $row['qty'];
        $costPrice = $row['cost_price'];
        $sellingPrice = $row['selling_price'];
        $image = $row['image']; 
        $p = $_SESSION['ePhone'];
        echo "

        
    
        <div class='form-group'>
            <input type='text' class='form-control' value='$iId' id='item-id' disabled hidden>
        </div>

        <div class='form-group'>
            <label for='qty'>QTY IN STOCK</label>
            <input type='number' class='form-control' value='$qty' id='qty' disabled>
        </div>
        <div class='form-group'>
            <label for='cost-price'>COST PRICE</label>
            <input type='number' value='$costPrice' class='form-control' id='cost-price' disabled>
        </div>
        <div class='form-group'>
            <label for='selling-price'>SELLING PRICE</label>
            <input type='number' class='form-control' id='selling-price' value='$sellingPrice' disabled >
        </div>
        <div class='form-group'>
            <img src='../users/sydeestack_$p/$image' alt='' style='width: 40px; height: 40px'>
        </div>
        <div class='form-group'>
            <input type='number' class='form-control' placeholder='Enter Qty to Assign' id='qty-to-assign' max='$qty' min='1' required>
        </div>
        <div class='qty-error' id='qty-error'></div>
        <div class='item-form-error error' id='item-form-error'></div>
        <div class='form-group text-right'>
            <button type='submit' class='btn btn-primary' id='btn-item-form'>Add to Branch</button>
        </div>
    
       
        ";
   
      }
    }
    // SEND ITEM TO BRANCH 
    if (isset($_POST['sendItemToBranch'])) {
        
        $branchId = checkForm($_POST['iBranchName']);
        $itemId = checkForm($_POST['iItemName']);
        $qta = checkForm($_POST['qta']);

        // CHECK FOR EMPTY FIELDS 
        if (empty($branchId) OR empty($itemId)  OR empty($qta)) {
            echo error("ALL FIELD(S) IS REQUIRED");
        }else{
            // CHECK IF ITEM ALREADY EXIST ON BRANCH 
            $iBCQuery = mysqli_query($conn, "SELECT * FROM branch_items WHERE branch_id=$branchId AND item_id=$itemId");
            if (!$iBCQuery) {
                die(error("FAILED TO VERIFIY ITEM ON BRANCH"));
            }else if(mysqli_num_rows($iBCQuery) > 0){
                echo error("ITEM ALREADY EXIST ON THIS BRANCH!");
            }else{
                // SEND TO SERVER 
                $sql = "INSERT INTO `branch_items`(`user_id`, `branch_id`, `item_id`, `qty`) VALUES ($userid, $branchId, $itemId, $qta);";
                $sql .=  "UPDATE `items` SET `qty`= qty - $qta WHERE id = $itemId";
                if (!mysqli_multi_query($conn, $sql)) {
                    die(error("ADDING ITEM TO BRANCH FAILED ".mysqli_error($conn)));
                }else{
                    echo success('<div class="text-center">ITEM ADDED TO BRANCH SUCCESSFULLY</div>');
                }
            }
        }
        
       
        
    }
    // ASSIGNING BRANCH TO USER 
    if (isset($_POST['assingBranchUser'])) {
        $password = ($_POST['password']);
        $uId = checkForm($_POST['userId']);
        $branchId = checkForm($_POST['branch']);

         // CHECK FOR EMPTY FIELDS 
         if (!empty($password) && !empty($uId) && !empty($branchId) ) {
           
            $uPQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
            if (!$uPQuery) {
                die(error("PASSWORD VERIFICATION FAILED"));
            }else{
                $dbPassword = mysqli_fetch_assoc($uPQuery)['password'];
            
                 // CHECK IF PASSWORD IS CORRECT 
               if(password_verify($password, $dbPassword)){
                     // CHECK BRANCH EXISTENCE
                    $bAQuery = mysqli_query($conn, "UPDATE `users` SET `branch_id`=$branchId WHERE id=$uId");
                    if (!$bAQuery) {
                        die(error("BRANCH ASSIGNMENT FAILED"));
                    }else{
                        echo success("BRANCH ASSIGN SUCCESSFULLY");
                    }
               }else{
                   echo error("INVALID PASSWORD");
               }
            }
         }else{
             echo erro("ALL FIELD(s) REQUIRED");
         }  
    }
    // SEARCH ITEM 

    if (isset($_POST['searchItem'])) {
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
            // $iBQuery = mysqli_query($conn, "SELECT * FROM `branch_items` JOIN items ON branch_items.item_id = items.id WHERE branch_id=$bId AND items.name LIKE '%$searchTerm%'");

            $iBQuery = mysqli_query($conn, "SELECT * FROM `items` JOIN branch_items ON items.id = branch_items.item_id WHERE branch_items.branch_id=$bId AND items.name LIKE '%$searchTerm%'");
            if (!$iBQuery) {
                die(error("ITEM FAILES"));
            }else if(mysqli_num_rows($iBQuery) > 0){
                // print_r(mysqli_fetch_assoc($iBQuery))
                echo '
                <table class="table table-bordered table-responsive" id="page-table">
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
                            <td><img src='../users/sydeestack_$p/$image' alt='' style='width: 40px; height: 40px'></td>
                           
                            
                            <td><a >$itemName</a></td>
                            <td>$qty</td>
                          
                            <td>$sp</td>
                            <td>$status</td>
                            <td><button class='buyitem btn btn-info' name='saleaction' id='$id'>Sale</button> </td>
                           
                        </tr>
                    ";
                    
                  
                }
            }else{
                echo success("$searchTerm NOT AVAILABLE");
            }
           
        }


    }
    // SELLING ITEM 
    if (isset($_POST['sellItem'])) {
        $qty = checkForm($_POST['qty']);
        $comment = checkForm( $_POST['comment']);
        $discounted = checkForm($_POST['discounted']);
        $sp = checkForm($_POST['sp']); 
        $pt = checkForm($_POST['pt']);
        $itemId = checkForm($_POST['itemId']);
        $userid = $_SESSION['eId'];
        // GET THE BRACH ID OF THE USER
        $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$bQuery) {
            die("UNABLE TO GET ITEMS ".mysqli_error($conn));
            exit();
        }
        $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];

        // CHECK IF THE QUANTITY REQUEST FOR IS AVAILABLE IN THE BRANCH 
        $branchQtyQuery = mysqli_query($conn, "SELECT * FROM branch_items WHERE branch_id = $branchId AND item_id=$itemId");
        if (!$branchQtyQuery) {
            die("QUANTITY CONFIRMATION FAILED ");
        }else{
            $bQty = mysqli_fetch_assoc($branchQtyQuery)['qty'];
           if ($bQty >= $qty) {
                // CHECK FOR EMPTY FIELDS 
                if (!empty($sp) && !empty($pt) && !empty($itemId) ) {
                    // CHECK IF DISCOUNT PRICE NOT IS EMPTY 
                    if (!empty($discounted)) {
                        if (!empty($discounted) && empty($comment)) {
                            echo error("Comment can't be empty when dicount is giving");
                        }else{
                            // SEND THE QUERY, USE DISCOUNTED PRICE AS TOTAL AMOUNT, SEND QTY AS QUANTITY 
                            $discountQuery = mysqli_multi_query($conn, "INSERT INTO `revenue`(`branch_id`, `item_id`, `selling_price`, `user_id`, `qty`, `amount`, `section`, `payment_type`,  `comment`) VALUES ($branchId, $itemId, $sp, $userid, $qty, $discounted, 'sales', '$pt', '$comment'); UPDATE `branch_items` SET `qty` = qty - $qty WHERE item_id =$itemId AND branch_id =$branchId");
                            if (!$discountQuery) {
                                die("FAILED TO SEND SALES DETAILS");
                            }else{
                                echo success('Sales Submitted Successfully');
                            }
            
                        }
                    }else if(empty($discounted)){
                        // CALCULATE THE QTY AND SELLING PRICE AND SEND 
                        $amount = $sp*$qty;
                        // SEND THE QUERY, USE DISCOUNTED PRICE AS TOTAL AMOUNT, SEND QTY AS QUANTITY 
                        $amountQuery = mysqli_multi_query($conn, "INSERT INTO `revenue`(`branch_id`, `item_id`, `selling_price`, `user_id`, `qty`, `amount`, `section`, `payment_type`,  `comment`) VALUES ($branchId, $itemId, $sp, $userid, $qty, $amount, 'sales', '$pt', '$comment'); UPDATE `branch_items` SET `qty` = qty - $qty WHERE item_id =$itemId AND branch_id =$branchId");

                        if (!$amountQuery) {
                            die("FAILED TO SEND SALES DETAILS ".mysqli_error($conn));
                        }else{
                            echo success('Sales Submitted Successfully');
                        }
                    }
                    
                }else{
                    echo error('All fields required');
                }
           }else{
               echo error("INSUFFICIENT QUANTITY.. You can't sale more than you have");
           }
            

        }
       
        
        
    }
    // INTERNET SALE 
    if (isset($_POST['internetSale'])) {
        $qty = checkForm($_POST['qty']);
        $comment = checkForm( $_POST['comment']);
        $discounted = checkForm($_POST['discounted']);
        $sp = checkForm($_POST['sp']); 
        $pt = checkForm($_POST['pt']);
        $name = checkForm($_POST['name']);
        $userid = $_SESSION['eId'];
        // GET THE BRACH ID OF THE USER
        $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$bQuery) {
            die("UNABLE TO GET ITEMS ".mysqli_error($conn));
            exit();
        }
        $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];

           
        // CHECK FOR EMPTY FIELDS 
        if (!empty($sp) && !empty($pt) && !empty($comment) && !empty($name) && !empty($qty)) {
            // CHECK IF DISCOUNT PRICE NOT IS EMPTY 
            if (!empty($discounted)) {
                if (!empty($discounted) && empty($comment)) {
                    echo error("Comment can't be empty when dicount is giving");
                }else{
                    // SEND THE QUERY, USE DISCOUNTED PRICE AS TOTAL AMOUNT, SEND QTY AS QUANTITY 
                    $discountQuery = mysqli_multi_query($conn, "INSERT INTO `revenue`(`branch_id`, `item_name`, `selling_price`, `user_id`, `qty`, `amount`, `section`, `payment_type`,  `comment`) VALUES ($branchId, '$name', $sp, $userid, $qty, $discounted, 'internet', '$pt', '$comment')");
                    if (!$discountQuery) {
                        die("FAILED TO SEND SALES DETAILS");
                    }else{
                        echo success('Sales Submitted Successfully');

                    }
    
                }

                // echo "AM NOT EMPTY";
            }else if(empty($discounted)){
                // CALCULATE THE QTY AND SELLING PRICE AND SEND 
                $amount = $sp*$qty;
                // SEND THE QUERY, USE DISCOUNTED PRICE AS TOTAL AMOUNT, SEND QTY AS QUANTITY 
                $amountQuery = mysqli_multi_query($conn, "INSERT INTO `revenue`(`branch_id`, `item_name`, `selling_price`, `user_id`, `qty`, `amount`, `section`, `payment_type`,  `comment`) VALUES ($branchId, '$name', $sp, $userid, $qty, $amount, 'internet', '$pt', '$comment')");

                if (!$amountQuery) {
                    die("FAILED TO SEND SALES DETAILS ".mysqli_error($conn));
                }else{
                    echo success('Sales Submitted Successfully');
                }
                // echo "am empty";
            }
            
        }else{
            echo error('All fields required');
        }            
    }  
    // ENGINEERING SALES 
    if (isset($_POST['engineering'])) {
        $qty = checkForm($_POST['qty']);
        $comment = checkForm( $_POST['comment']);
        $discounted = checkForm($_POST['discounted']);
        $sp = checkForm($_POST['sp']); 
        $pt = checkForm($_POST['pt']);
        $name = checkForm($_POST['name']);
        $userid = $_SESSION['eId'];

        // GET THE BRACH ID OF THE USER
        $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$bQuery) {
            die("UNABLE TO GET ITEMS ".mysqli_error($conn));
            exit();
        }
        $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];

           
        // CHECK FOR EMPTY FIELDS 
        if (!empty($sp) && !empty($pt) && !empty($comment) && !empty($name) && !empty($qty)) {
            // CHECK IF DISCOUNT PRICE NOT IS EMPTY 
            if (!empty($discounted)) {
                if (!empty($discounted) && empty($comment)) {
                    echo error("Comment can't be empty when dicount is giving");
                }else{
                    // SEND THE QUERY, USE DISCOUNTED PRICE AS TOTAL AMOUNT, SEND QTY AS QUANTITY 
                    $discountQuery = mysqli_multi_query($conn, "INSERT INTO `revenue`(`branch_id`, `item_name`, `selling_price`, `user_id`, `qty`, `amount`, `section`, `payment_type`,  `comment`) VALUES ($branchId, '$name', $sp, $userid, $qty, $discounted, 'engineering', '$pt', '$comment')");
                    if (!$discountQuery) {
                        die("FAILED TO SEND SALES DETAILS ".mysqli_error($conn));
                    }else{
                        echo success('Sales Submitted Successfully');

                    }
    
                }
                // echo "AM NOT EMPTY";
            }else if(empty($discounted)){
                // CALCULATE THE QTY AND SELLING PRICE AND SEND 
                $amount = $sp*$qty;
                // SEND THE QUERY, USE DISCOUNTED PRICE AS TOTAL AMOUNT, SEND QTY AS QUANTITY 
                $amountQuery = mysqli_multi_query($conn, "INSERT INTO `revenue`(`branch_id`, `item_name`, `selling_price`, `user_id`, `qty`, `amount`, `section`, `payment_type`,  `comment`) VALUES ($branchId, '$name', $sp, $userid, $qty, $amount, 'engineering', '$pt', '$comment')");

                if (!$amountQuery) {
                    die("FAILED TO SEND SALES DETAILS ".mysqli_error($conn));
                }else{
                    echo success('Sales Submitted Successfully');
                }
               
            }
            
        } else{
            echo error('All fields required');
        }            
    }

    // TRAINING FORM SALES 
    if (isset($_POST['saleTrainingForm'])) {
        $regNo = checkForm($_POST['regNo']);
        $fullname = checkForm($_POST['fullname']);
        $phone = checkForm($_POST['phone']);
        $amount = checkForm($_POST['amount']);
        $programType = checkForm($_POST['programType']);
        $comment = checkForm($_POST['comment']);
        $paymentType = checkForm($_POST['paymentType']);
        $chargePrice  = checkForm($_POST['chargePrice']);
        $npaymentStatus = checkForm($_POST['paymentStatus']);

       
        // CHECK FOR EMPTY
        if (empty($regNo) OR empty($fullname) OR empty($phone) OR empty($amount) OR empty($programType) OR empty($comment) OR empty($paymentType) OR empty($chargePrice) OR empty($npaymentStatus)) {
            echo error("ALL FIELDS REQUIRED");
        }else if($amount > $chargePrice){
            echo error("AMOUNT PAID IS HIGHER THAN AMOUNT CHARGED");
        }else{
            if($amount < $chargePrice){
                $paymentStatus = 'deposit';
            }else {
                $paymentStatus = 'completed';
            }
            $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
            if (!$bQuery) {
                die("UNABLE TO GET ITEMS ".mysqli_error($conn));
                exit();
            }
            $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];
            // CHECK IF REGNO IS IN USE 
            $regNoQuery = mysqli_query($conn, "SELECT * FROM `forms` WHERE reg_no='$regNo'");
            if (!$regNoQuery) {
                die(error("FAILED TO CHECK REG NO"));
            }else if(mysqli_num_rows($regNoQuery) > 0){
                echo error("<span class='text-info'>$regNo </span> Already in used by another student");
            }else{
                 $formSaleQuery = mysqli_multi_query($conn, "INSERT INTO `revenue`(`branch_id`, `item_name`, `selling_price`, `user_id`, `qty`, `amount`, `section`, `payment_type`,  `comment`, status) VALUES ($branchId, '$regNo', $chargePrice, $userid, 1, $amount, 'form', '$paymentType', '$comment', '$paymentStatus'); INSERT INTO `forms`(`reg_no`, branch_id, `fullname`, `phone`, `program_type`, `amount`, `comment`, `user_id`, `status`) VALUES ('$regNo', $branchId, '$fullname', '$phone', '$programType', '$amount', '$comment', $userid, 'pending')");
                 if (!$formSaleQuery) {
                     die("FAILED TO SEND SALES DETAILS ".mysqli_error($conn));
                 }else{
                     if ($formSaleQuery) {
                         $fRegNo = str_replace("/", "", $regNo);
                        if (!file_exists("../../users/student/$fRegNo")) {
                            mkdir("../../users/student/$fRegNo", 0777, true);
                            echo success('Form Submitted Successfully');
                        }else{
                            echo error("ERROR SUBMITING YOUR FORM ".mysqli_error($conn));
                        }
                     }
                 }
            }
        }      


    }
    
    // TRAINING FEES SUBMIT 
    if (isset($_POST["trainingFeesSubmit"])) { 
        $regNo = checkForm($_POST['regNo']);
        $fullname = checkForm($_POST['fullname']);
        $phone = checkForm($_POST['phone']);
        $email = checkForm($_POST['email']);
        $address = checkForm($_POST['studentAddress']);
        $guardianName = checkForm($_POST['guardianName']);
        $guardianAddress = checkForm($_POST['guardianAddress']);
        $programType = checkForm($_POST['programType']);
        $amountCharge = checkForm($_POST['amountCharge']);
        $paymentStatus = checkForm($_POST['paymentStatus']);
        $amountPaid = checkForm($_POST['amountPaid']);
        $comment = checkForm($_POST['comment']);
        $paymentType = checkForm($_POST['paymentType']);
        // FILLED FORM
        $fileName = $_FILES['fillFile']['name'];
        $fileSize = $_FILES['fillFile']['size'];
        $fileType = $_FILES['fillFile']['type'];
        $fileError = $_FILES['fillFile']['error'];
        $tmp = $_FILES['fillFile']['tmp_name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
         // CHECK FOR EMPTY 
        if (empty($fullname) OR empty($phone) OR empty($email) OR empty($address) OR empty($guardianName) OR empty($guardianAddress) OR empty($programType) OR empty($amountCharge) OR empty($paymentStatus) OR empty($amountPaid) OR empty($comment) OR empty($_FILES['fillFile']) OR empty($regNo)) {
           echo error("All Field(s) Required");
           exit();
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo error("INVALID EMAIL ADDRESS");
            exit();
        }else if($amountPaid > $amountCharge){
            echo error("AMOUNT PAID CAN'T BE HIGER THAN AMOUNT CHARGE");
            exit();
        }else {
            // CHECK FILE ISSUES 
            if($fileError !== 0 ){
                echo error("ISSUE WITH FILE SELECTED ");
                exit();
            }else if($fileType !== "application/pdf" ){
                echo error("INVALID FILE TYPE (PDF ONLY)");
                exit();
            }else if($fileSize > 2000000){
                echo error("FILE IS TOO LARGE MAXIMUM OF 2MB");
            }else{
                // CHECK FOR IF STUDENT ALREADY REGISTERED 
                $rNCQuery = mysqli_query($conn, "SELECT * FROM `training` WHERE reg_no='$regNo'");
                if (!$rNCQuery) {
                    die(error("REGNO CHECK FAILED "));
                }else if(mysqli_num_rows($rNCQuery) > 0){
                    echo error("$regNo Already Exist");
                    exit();
                }else{
                    $branchId = branchId();
                    // SEND TO DB 
                    if ($amountCharge < $amountPaid) {
                        $nPaymentStatus = 'deposit';
                    }else{
                        $nPaymentStatus = 'completed';
                    }
                    $fRegNo = str_replace("/", "", $regNo);
                    $nSFileName = $fRegNo."_".date("Y-m-d").".".$ext;
                    
                    // TRAINING SQL 
                    $trainingSQL = "INSERT INTO `training`(`reg_no`, `user_id`, `fullname`, `email`, `phone`, `address`, `guardian_name`, `guardian_address`, `program_type`, `amount_charge`, `amount_paid`, `comment`, `fill_form`) VALUES ('$regNo', $userid, '$fullname', '$email', '$phone', '$address', '$guardianName', '$guardianAddress', '$programType', $amountCharge, $amountPaid, '$comment', '$nSFileName')";

                    // REVENUE SQL 
                    $trainingRevenueSQL = "INSERT INTO `revenue`(`branch_id`, `user_id`, `item_name`, `selling_price`, `qty`, `amount`, `section`, `payment_type`, `status`, `comment`) VALUES ($branchId, $userid, '$regNo', $amountCharge, 1, $amountPaid, 'training ', '$paymentType', '$nPaymentStatus', '$comment')";

                    // UPDATE FORM STATUS 
                    $updateFormSQL = "UPDATE `forms` SET status = 'training_commence' WHERE reg_no = '$regNo'";

                    $trainingFeesQuery = mysqli_multi_query($conn, "$trainingSQL;$trainingRevenueSQL;$updateFormSQL");
                    if (!$trainingFeesQuery) {
                        die(error("TRAINING FEES FAILED ").mysqli_error($conn));
                    }else{
                       if ( move_uploaded_file($tmp, "../../users/student/$fRegNo/$nSFileName")) {
                        echo success("Details Submited Successfully");
                       }else{
                           echo "TRAINING FEES SUBMITION FAILED";
                       }
                        
                    }
                }
            }

        }
      
    }

    // PROGRAM FORM 
    if (isset($_POST['submitProgramForm'])) {
        $name = checkForm($_POST['name']);
        $duration = checkForm($_POST['duration']);
        $fees = checkForm($_POST["fees"]);

        if (!empty($name) && !empty($duration) && !empty($fees) ) {
        //    CHECK FOR PROGRAM NAME EXISTENCE 
            $cNQuery = mysqli_query($conn, "SELECT * FROM `program` WHERE name = '$name'");
            if (!$cNQuery) {
                die(error("PROGRAM NAME FAILED "));
                exit();
            }else if(mysqli_num_rows($cNQuery) > 0){
                echo error("PROGRAM ALREADY EXIST");
                exit();
            }else{
                // SEND PROGRAM TO DB 
                $pQuery = mysqli_query($conn, "INSERT INTO `program`(`user_id`, `name`, `duration`, `fees`) VALUES ($userid, '$name', $duration, $fees)");

                if (!$pQuery) {
                    die(error("SUBMITING PROGRAM FAILED").mysqli_error($conn));
                    exit();
                }else{
                    echo success("PROGRAM ADDED SUCCESSFULLY");
                }
            }
          
        }else{
            echo error("ALL FIELD(s) REQUIRED");
        }
    }

    // GET PROGRAMS 
    if(isset($_POST['getPrograms'])){
        $pQuery = mysqli_query($conn, "SELECT * FROM `program`");
        if (!$pQuery) {
            die(error("GETTING PROGRAMS FAILED "));
        }else if(mysqli_num_rows($pQuery)< 1){
            echo info("NO REGISTERED PROGRAM");
        }else{
            // SHOW PROGRAM TABLE
            echo "<table class='table table-bordered table-responsive' id='page-table'>
            <thead>
                <tr>
                    <td>SN</td>
                    <td>NAME</td>
                    <td>FEES</td>
                    <td>DURATION</td>
                    <td>DATE</td>
                    <td>ACTION</td>
                </tr>
            </thead>
            <tbody>";
            $sn = 1;
            while ($row = mysqli_fetch_assoc($pQuery)) {
            
                $id = $row['id'];
                $userId = $row['user_id'];
                $name = strtoupper($row['name']);
                $duration = $row['duration'];
                $status = $row['status'];
                $date = $row['date'];
                $fees = number_format($row['fees']);
                echo "<tr>
                <td>$sn</td>
                <td>$name</td>
                <td>$fees</td>
                <td>$duration</td>
                <td>$date</td>
                <td><select name='action' id='action' class='action'>
                    <option value=''>Select Action</option>
                    <option value='view'>View</option>
                    <option value='edit'>Edit</option>
                    <option value='deactivate'>Deactivate</option>
                </select></td>
            </tr>";
            $sn++;
            }
            echo "  </tbody>
            </table>";
        }
    }
    // PAYMENT FORM 
    if (isset($_POST["submitPaymentForm"])) {

        $typeName = checkForm($_POST["typeName"]);
        $accountNumber = checkForm($_POST["accountNumber"]);
        
        // CHECK EMPTY 
        if (!empty($typeName)) {
                // CHECK IF ALREADY EXIT 
                $paymentCheckQuery = mysqli_query($conn, "SELECT * FROM `payment` WHERE name='$typeName' AND account_number ='$accountNumber'");
                if (!$paymentCheckQuery) {
                    die(error("PAYMENT NAME CHECK FAILED ").mysqli_error($conn));

                }else if(mysqli_num_rows($paymentCheckQuery)){
                    echo error("Payment Details Already Exist");
                }else{
                    // SEND TO DB 
                    $paymentQuery = mysqli_query($conn, "INSERT INTO `payment`(`name`, `account_number`, `user_id`) VALUES ('$typeName', '$accountNumber', $userid)");

                    if (!$paymentQuery) {
                        die(error("SUBMITION FAIELD").mysqli_error($conn));
                    }else{
                        echo success("PAYMENT TYPE ADDED SUCCESSFULLY");
                    }
                }
        }else{
            echo error("All Field(s) Required");
        }

    }
    // PAYMENT LIST 
    if (isset($_POST['getPaymentList'])) {
        $paymentQuery = mysqli_query($conn, "SELECT * FROM payment");

        if (!$paymentQuery) {
            die(error("FAILED TO GET PAYMENTS LIST"));
        }else if(mysqli_num_rows($paymentQuery) < 1){
            echo info("NO PAYMENT TYPE UPLOADED YET");
        }else{
            echo "   <table class='table table-bordered table-responsive'>
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>NAME</th>
                    <th>ACCOUNT NUMBER</th>
                    <th>DATE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>";
            $sn = 1;
            while ($row = mysqli_fetch_assoc($paymentQuery)) {
             
                $id = $row['id'];
                $name = $row['name'];
                $accountNumber = $row['account_number'];
                $date = $row['date'];
                $status = $row['status'];
                echo "  <tr>
                <td>$sn</td>
                <td>$name</td>
                <td>$accountNumber</td>
                <td>$date</td>
                <td><select name='action' id='action' class='action'>
                    <option value='' selected disabled>Select Action</option>
                    <option value='view'>View</option>
                    <option value='edit'>Edit</option>
                    <option value='deactivate'>Deactivate</option>
                </select></td>
            </tr>";
            $sn++;
            }

            echo '  </tbody>
            </table>';
        }
    }
    // CREDITOR FORM 
    if (isset($_POST["addCreditorForm"])) {
      
        $name = checkForm($_POST['name']);
        $email = checkForm($_POST['email']);
        $phone = checkForm($_POST['phone']);
        $gender = checkForm($_POST['gender']);
        $organization = checkForm($_POST['organization']);
        $address = checkForm($_POST['address']);

        // CHECK FOR EMPTY FIELDS 
        if (!empty($name) && !empty($email) && !empty($phone) && !empty($gender) && !empty($organization) && !empty($address)) {
        //    CHECK IF PHONE NUMBER OR EMAIL ALREADY EXIT 
            $pEQuery = mysqli_query($conn, "SELECT * FROM `creditor` WHERE email='$email' OR phone ='$phone'");
            if (!$pEQuery) {
                die(error("FAILED TO VERIFY EMAIL AND PHONE NUMBER ").mysqli_error($conn));

            }else if(mysqli_num_rows($pEQuery) > 0){
                echo error("EMAIL OR PHONE NUMBER ALREADY EXIST");
            }else{
                // SEND DATA TO DB 
                $creditorQuery = mysqli_query($conn, "INSERT INTO `creditor`(`user_id`, `name`, `phone`, `email`, `gender`, `organization`, `address`) VALUES ($userid, '$name', '$phone', '$email', '$gender', '$organization', '$address')");

                if (!$creditorQuery) {
                    die(error("FAILED TO ADD CREDITOR"));
                }else{
                    echo success("CREDITOR ADDED SUCCESSFULLY");
                }
            }
        }else{
            echo error("ALL FIELD(S) REQUIRED");
        }
    }
    // GET ALL CREDITORS 
    if (isset($_POST["getCreditors"])) {
        $cQuery = mysqli_query($conn, "SELECT * FROM creditor");
        if (!$cQuery) {
            die(error("FAILED TO GET CREDITORS LIST"));
        }else if(mysqli_num_rows($cQuery) < 1){
            echo info("NO REGISTERED CREDITOR ON THE SYSTEM ");
        }else {
            echo "<table class='table table-bordered table-responsive' id='page-table'>
            <thead>
                <tr>
                    <td>SN</td>
                    <td>NAME</td>
                    <td>PHONE NUMBER</td>
                    <td>EMAIL ADDRESS</td>
                    <td>GENDER</td>
                    <td>ADDRESS</td>
                    <td>ACTION</td>
                   
                </tr>
            </thead>
            <tbody>";
            $sn = 1;
            while ($row = mysqli_fetch_assoc($cQuery)) {
                $id = $row['id'];
                $userId = $row['user_id'];
                $name = strtoupper($row['name']);
                $phone = $row['phone'];
                $email = $row['email'];
                $gender = strtoupper($row['gender']);
                $organization = strtoupper($row['organization']);
                $address = $row['address'];
                $status = $row['status'];
                $date = $row['date'];
                echo "<tr>
                    <td>$sn</td>
                    <td>$name</td>
                    <td>$phone</td>
                    <td>$email</td>
                    <td>$gender</td>
                    <td>$address</td>
                    <td><select name='action' id='action' class='action'>
                        <option value='' selected disabled>Select Action</option>
                        <option value='view'>View</option>
                        <option value='deactivate'>Deactivate</option>
                        
                    </select></td>
        
                </tr>
                ";
                $sn++;
            }
            echo "</tbody>
            </table>";
        }
    }

        // DEBTORS SALES 
        // SELLING ITEM 
    if (isset($_POST['sellDebtor'])) {
        $qty = checkForm($_POST['qty']);
        $comment = checkForm( $_POST['comment']);
        $discounted = checkForm($_POST['discounted']);
        $sp = checkForm($_POST['sp']); 
        $pt = checkForm($_POST['pt']);
        $itemId = checkForm($_POST['itemId']);
        $userid = $_SESSION['eId'];
        // GET THE BRACH ID OF THE USER
        $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$bQuery) {
            die("UNABLE TO GET ITEMS ".mysqli_error($conn));
            exit();
        }
        $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];

        // CHECK IF THE QUANTITY REQUEST FOR IS AVAILABLE IN THE BRANCH 
        $branchQtyQuery = mysqli_query($conn, "SELECT * FROM branch_items WHERE branch_id = $branchId AND item_id=$itemId");
        if (!$branchQtyQuery) {
            die("QUANTITY CONFIRMATION FAILED ");
        }else{
            $bQty = mysqli_fetch_assoc($branchQtyQuery)['qty'];
           if ($bQty >= $qty) {
                // CHECK FOR EMPTY FIELDS 
                if (!empty($sp) && !empty($pt) && !empty($itemId) ) {
                    // CHECK IF DISCOUNT PRICE NOT IS EMPTY 
                    if (!empty($discounted)) {
                        if (!empty($discounted) && empty($comment)) {
                            echo error("Comment can't be empty when dicount is giving");
                        }else{
                            // SEND THE QUERY, USE DISCOUNTED PRICE AS TOTAL AMOUNT, SEND QTY AS QUANTITY 
                            $discountQuery = mysqli_multi_query($conn, "INSERT INTO `revenue`(`branch_id`, `item_id`, `selling_price`, `user_id`, `qty`, `amount`, `section`, `payment_type`,  `comment`, status) VALUES ($branchId, $itemId, $sp, $userid, $qty, $discounted, 'sales', '$pt', '$comment', ); UPDATE `branch_items` SET `qty` = qty - $qty WHERE item_id =$itemId AND branch_id =$branchId");
                            if (!$discountQuery) {
                                die("FAILED TO SEND SALES DETAILS");
                            }else{
                                echo success('Sales Submitted Successfully');
                            }
            
                        }
                    }else if(empty($discounted)){
                        // CALCULATE THE QTY AND SELLING PRICE AND SEND 
                        $amount = $sp*$qty;
                        // SEND THE QUERY, USE DISCOUNTED PRICE AS TOTAL AMOUNT, SEND QTY AS QUANTITY 
                        $amountQuery = mysqli_multi_query($conn, "INSERT INTO `revenue`(`branch_id`, `item_id`, `selling_price`, `user_id`, `qty`, `amount`, `section`, `payment_type`,  `comment`, status) VALUES ($branchId, $itemId, $sp, $userid, $qty, $amount, 'sales', '$pt', '$comment', 'credit'); UPDATE `branch_items` SET `qty` = qty - $qty WHERE item_id =$itemId AND branch_id =$branchId");

                        if (!$amountQuery) {
                            die("FAILED TO SEND SALES DETAILS ".mysqli_error($conn));
                        }else{
                            echo success('Sales Submitted Successfully');
                        }
                    }
                    
                }else{
                    echo error('All fields required');
                }
           }else{
               echo error("INSUFFICIENT QUANTITY.. You can't sale more than you have");
           }
            

        }
       
        
        
    }

    // INDIVIDUAL BRANCH ITEMS 

    if(isset($_POST['individualBranchItems'])){
        $bId = $_POST['bId'];
        $iQuery = mysqli_query($conn, "SELECT * FROM `branch_items` JOIN items ON branch_items.item_id = items.id WHERE branch_items.branch_id = $bId");
        if (!$iQuery) {
            die(("FAILD TO FETCH ITEMS ").mysqli_error($conn));

        }else if(mysqli_num_rows($iQuery)){
            // PRINT ITEMS 
            echo '
            <table class="table table-bordered table-responsive" id="page-table">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>IMAGE</th>
                  
                    <th>SUB CATEGORY</th>
                    <th>ITEM</th>
                    <th>QTY</th>
                    <th>CP</th>
                    <th>SP</th>
                    <th>STATUS</th>
                    <th>DATE</th>
                    <th>TOTAL CP</th>
                    <th>TOTAL SP</th>
                    <th>PROFIT</th>
                    <th> Action </th>
                    
                </tr>
            </thead>
            <tbody>
            ';
            $sn = 0;
            $totalCostPrice = 0;
            $totalSellingPrice = 0;
            while ($row = mysqli_fetch_assoc($iQuery)) {
                $sn++;
                $id = $row['id'];
                $catId = $row['category_id'];
                $sCatId = $row['sub_category_id'];
                $itemName = strtoupper($row['name']);
                $qty = $row['qty'];
                $cp = $row['cost_price'];
                $sp =$row['selling_price'];
                $image = $row['image'];
                $uId = $row['user_id'];
                $status = $row['status'];
                $date = $row['date'];
                $tCp = $qty*$cp;
                $tSp = $qty*$sp;
                $profit = $tSp-$tCp;
                $totalCostPrice += $tCp;
                $totalSellingPrice +=$tSp;
                $p = $_SESSION['ePhone'];

                // CATEGORY NAME 
                $catNameQuery = mysqli_query($conn, "SELECT category_name FROM category WHERE id=$catId");
               
                if (!$catNameQuery) {
                    die("FAILED TO VERIFY CATEGORY");
                }else{
                    $catName = strtoupper( mysqli_fetch_assoc($catNameQuery)['category_name']);
                }
                 // SUB CATEGORY QUERY 
                 $sCatNameQuery = mysqli_query($conn, "SELECT sub_category_name FROM sub_category WHERE id=$sCatId");

                if (!$sCatNameQuery) {
                    die("FAILED TO VERIFY CATEGORY");
                }else{
                    $sCatName = strtoupper( mysqli_fetch_assoc($sCatNameQuery)['sub_category_name']);
                }

                echo "                   
                    <tr>
                        <td>$sn</td>
                        <td><img src='../users/sydeestack_$p/$image' alt='' style='width: 40px; height: 40px'></td>
                       
                        <td>$sCatName</td>
                        <td><a href='' name='itemaction' id='$id'>$itemName</a></td>
                        <td>$qty</td>
                        <td>$cp</td>
                        <td>$sp</td>
                        <td>$status</td>
                        <td>$date</td>
                        <td>$tCp</td>
                        <td>$tSp</td>
                        <td>$profit</td>
                        <td>
                            <div class='form-group'>
                                <select id='action' class='action'>
                                    <option value='' selected disabled>Select Action</option>
                                    <option value='edit'>Edit</option>
                                    <option value='view'>View</option>
                                    <option value='deactivate'>Delete</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                ";
             
            }
            $totalProfit = number_format($totalSellingPrice - $totalCostPrice);
            $totalCostPrice = number_format($totalCostPrice);
            $totalSellingPrice = number_format($totalSellingPrice);
            echo "  
                 <tr>
                    <td colspan='2'>Total Cost: <strong>$totalCostPrice</strong></td>
                    <td colspan='2'>Total Selling Cost: <strong>$totalSellingPrice</strong></td>
                    <td colspan='2'>Profit: <strong>$totalProfit</strong></td>
                </tr>  
            </tbody>
        </table>";
        }else{
            echo info("NO ITEM UPLOADED YET ");
        }
    }
    
    // STORE ITEMS 
    if(isset($_POST["allStoreItems"])){
        $iQuery = mysqli_query($conn, "SELECT * FROM `items` ORDER BY date DESC");
        if (!$iQuery) {
            die(("FAILD TO FETCH ITEMS ").mysqli_error($conn));

        }else if(mysqli_num_rows($iQuery)){
            // PRINT ITEMS 
            echo '
            <table class="table table-bordered table-responsive" id="page-table">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>IMAGE</th>
                  
                    <th>SUB CATEGORY</th>
                    <th>ITEM</th>
                    <th>QTY</th>
                    <th>CP</th>
                    <th>SP</th>
                    <th>STATUS</th>
                    <th>DATE</th>
                    <th>TOTAL CP</th>
                    <th>TOTAL SP</th>
                    <th>PROFIT</th>
                    <th> ACTIONS </th>
                    
                </tr>
            </thead>
            <tbody>
            ';
            $sn = 0;
            $totalCostPrice = 0;
            $totalSellingPrice = 0;
            while ($row = mysqli_fetch_assoc($iQuery)) {
                $sn++;
                $id = $row['id'];
                $catId = $row['category_id'];
                $sCatId = $row['sub_category_id'];
                $itemName = strtoupper($row['name']);
                $qty = $row['qty'];
                $cp = $row['cost_price'];
                $sp =$row['selling_price'];
                $image = $row['image'];
                $uId = $row['user_id'];
                $status = $row['status'];
                $date = $row['date'];
                $tCp = $qty*$cp;
                $tSp = $qty*$sp;
                $profit = $tSp-$tCp;
                $totalCostPrice += $tCp;
                $totalSellingPrice +=$tSp;
                $p = $_SESSION['ePhone'];

                // CATEGORY NAME 
                $catNameQuery = mysqli_query($conn, "SELECT category_name FROM category WHERE id=$catId");
               
                if (!$catNameQuery) {
                    die("FAILED TO VERIFY CATEGORY");
                }else{
                    $catName = strtoupper( mysqli_fetch_assoc($catNameQuery)['category_name']);
                }
                 // SUB CATEGORY QUERY 
                 $sCatNameQuery = mysqli_query($conn, "SELECT sub_category_name FROM sub_category WHERE id=$sCatId");

                if (!$sCatNameQuery) {
                    die("FAILED TO VERIFY CATEGORY");
                }else{
                    $sCatName = strtoupper( mysqli_fetch_assoc($sCatNameQuery)['sub_category_name']);
                }

                echo "                   
                    <tr>
                        <td>$sn</td>
                        <td><img src='../users/sydeestack_$p/$image' alt='' style='width: 40px; height: 40px'></td>
                       
                        <td>$sCatName</td>
                        <td><a href='' name='itemaction' id='$id'>$itemName</a></td>
                        <td>$qty</td>
                        <td>$cp</td>
                        <td>$sp</td>
                        <td>$status</td>
                        <td>$date</td>";
                        ?>

                        <td><?php echo number_format($tCp); ?></td>
                        <td><?php echo number_format($tSp); ?></td>
                        <td> <?php echo number_format($profit); ?></td>
                        <?php
                        echo "
                        <td>
                            <div class='form-group'>
                                <select name='actions' class='actions' id='$id'>
                                    <option value='' selected disabled>Select Action</option>
                                    <option value='edit'>Edit</option>
                                    <option value='view'>View</option>
                                    <option value='deactivate'>Delete</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                ";
             
            }
            $totalProfit = number_format($totalSellingPrice - $totalCostPrice);
            $totalCostPrice = number_format($totalCostPrice);
            $totalSellingPrice = number_format($totalSellingPrice);
            echo "  
                 <tr>
                    <td colspan='2'>Total Cost: <strong>$totalCostPrice</strong></td>
                    <td colspan='2'>Total Selling Cost: <strong>$totalSellingPrice</strong></td>
                    <td colspan='2'>Profit: <strong>$totalProfit</strong></td>
                </tr>  
            </tbody>
        </table>";
        }else{
            echo info("NO ITEM UPLOADED YET ");
        }
    }

    // ALL COMPANY ITEMS 
    if (isset($_POST['allItems'])) {
        // GET ALL ITEMS 
        $iQuery = mysqli_query($conn, "SELECT * FROM `items` ORDER BY date DESC");
        if (!$iQuery) {
            die(("FAILD TO FETCH ITEMS ").mysqli_error($conn));

        }else if(mysqli_num_rows($iQuery)){
            // PRINT ITEMS 
            echo '
            <table class="table table-bordered table-responsive" id="page-table">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>IMAGE</th>
                  
                    <th>SUB CATEGORY</th>
                    <th>ITEM</th>
                    <th>QTY</th>
                    <th>CP</th>
                    <th>SP</th>
                    <th>STATUS</th>
                    <th>DATE</th>
                    <th>TOTAL CP</th>
                    <th>TOTAL SP</th>
                    <th>PROFIT</th>
                    
                </tr>
            </thead>
            <tbody>
            ';
            $sn = 0;
            $totalCostPrice = 0;
            $totalSellingPrice = 0;
            while ($row = mysqli_fetch_assoc($iQuery)) {
                $sn++;
                $id = $row['id'];
                $catId = $row['category_id'];
                $sCatId = $row['sub_category_id'];
                $itemName = strtoupper($row['name']);
                $qty = $row['qty'];
                $cp = $row['cost_price'];
                $sp =$row['selling_price'];
                $image = $row['image'];
                $uId = $row['user_id'];
                $status = $row['status'];
                $date = $row['date'];
                $tCp = $qty*$cp;
                $tSp = $qty*$sp;
                $profit = $tSp-$tCp;
                $totalCostPrice += $tCp;
                $totalSellingPrice +=$tSp;
                $p = $_SESSION['ePhone'];

                // CATEGORY NAME 
                $catNameQuery = mysqli_query($conn, "SELECT category_name FROM category WHERE id=$catId");
               
                if (!$catNameQuery) {
                    die("FAILED TO VERIFY CATEGORY");
                }else{
                    $catName = strtoupper( mysqli_fetch_assoc($catNameQuery)['category_name']);
                }
                 // SUB CATEGORY QUERY 

                //  GET THE SUM OF ALL ITEMS FROM BRANCHES 
                $sumQuery = mysqli_query($conn, "SELECT SUM(qty) as branchQty FROM branch_items WHERE item_id = $id");
                if (!$sumQuery) {
                    die("FAILED TO GET BRANCH DETAILS ".mysqli_error($conn));
                }else {
                    
                    $branchQty = mysqli_fetch_assoc($sumQuery)['branchQty'];
                    $totalQty = number_format($qty+$branchQty);

                    
                }
                 $sCatNameQuery = mysqli_query($conn, "SELECT sub_category_name FROM sub_category WHERE id=$sCatId");

                if (!$sCatNameQuery) {
                    die("FAILED TO VERIFY CATEGORY");
                }else{
                    $sCatName = strtoupper( mysqli_fetch_assoc($sCatNameQuery)['sub_category_name']);
                }

                echo "                   
                    <tr>
                        <td>$sn</td>
                        <td><img src='../users/sydeestack_$p/$image' alt='' style='width: 40px; height: 40px'></td>
                       
                        <td>$sCatName</td>
                        <td><a href='' name='itemaction' id='$id'>$itemName</a></td>
                        <td>$totalQty</td>
                        <td>$cp</td>
                        <td>$sp</td>
                        <td>$status</td>
                        <td>$date</td>";
                        ?>

                        <td><?php echo number_format($tCp); ?></td>
                        <td><?php echo number_format($tSp); ?></td>
                        <td> <?php echo number_format($profit); ?></td>
                        <?php
                        echo "
                    </tr>
                ";
             
            }
            $totalProfit = number_format($totalSellingPrice - $totalCostPrice);
            $totalCostPrice = number_format($totalCostPrice);
            $totalSellingPrice = number_format($totalSellingPrice);
            echo "  
                 <tr>
                    <td colspan='2'>Total Cost: <strong>$totalCostPrice</strong></td>
                    <td colspan='2'>Total Selling Cost: <strong>$totalSellingPrice</strong></td>
                    <td colspan='2'>Profit: <strong>$totalProfit</strong></td>
                </tr>  
            </tbody>
        </table>";
        }else{
            echo info("NO ITEM UPLOADED YET ");
        }
    }
    
    // ALL RECORDS 

    if (isset($_POST['fetchAllRevenueRecords'])) {
         // SHOW THE SALES TABLE HERE 
        
            $revenueQuery = mysqli_query($conn, "SELECT * FROM `revenue` ORDER BY date DESC");
            if (!$revenueQuery) {
                die("REVENUE FETCH FAILED");
            }else if(mysqli_num_rows($revenueQuery) > 0){
                echo '<table class="table table-bordered table-responsive" id="page-table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>ITEM NAME</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>SECTION</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th>BY</th>
                        <th>RECEIPT</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>';
                $sn = 1;
                $totalSales = 0;
                
                while ($row = mysqli_fetch_assoc($revenueQuery)) {
                    $id = $row['id'];
                    $branchid = $row['branch_id'];
                    $itemId = $row['item_id'];
                    $itemName = ucwords($row['item_name']);
                    $sp = $row['selling_price'];
                    $qty = $row['qty'];
                    $amount = $row['amount'];
                    $section = ucwords($row['section']);
                    $pt  = $row['payment_type'];
                    $status = $row['status'];
                    $date = $row['date'];
                    $comment = $row['comment'];
                    $sellerId = $row['user_id'];
                    $sellerQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$sellerId");
                    
                    $totalSales += $amount;
                    if (!isset($sellerQuery)) {
                        die("FAILED TO VERIFY SELLER");
                    }else{
                        $fullname = ucwords(mysqli_fetch_assoc($sellerQuery)['fullname']);
                    }
                    // GET THE SALER NAME 

                    if (strtolower($section) === 'sales') {
                        // $itemNewName = $itemId;
                         $itemNameQuery = mysqli_query($conn, "SELECT *  FROM items WHERE id=$itemId");
                      
                        if (!$itemNameQuery) {
                            die("FAILED TO GET ITEM NAME ");
                        }else if(mysqli_num_rows($itemNameQuery) > 0){
                            $itemNewName = strtoupper(mysqli_fetch_assoc($itemNameQuery)['name']);
                           
                        }else{
                            $itemNewName = 'ITEM NOT FOUND';
                        }
                        
                    }else{
                        $itemNewName = $itemName;
                    }
                    echo "<tr>
                    <td>$sn</td>
                    <td>$itemNewName</td>
                    <td>$qty</td>
                    <td>$amount</td>
                    <td>$section</td>
                    <td>$date</td>
                    <td>$status</td>
                    <td>$fullname</td>
                    <td>
                        <a class='btn btn-success' id='$id' name='download-receipt' href='./dompdf/receipt.php?rid=$id'> <i class='fa fa-download' aria-hidden='true' ></i> Receipt</a>
                    </td>
                    <td>
                        <select name='action' id='action'>
                            <option selected disabled>Select Action </option>
                            <option value='return'>Return</option>
                            <option value='query'>Query</option>
                            <option value='edit'>Edit</option>
                        </select>
                    </td>
                </tr>";
                $sn++;
                    
                }
                $totalSales = number_format($totalSales);
                echo "</tbody>
                </table>
                <div mb-4> TOTAL SALES $totalSales </div>
                ";

            }else{
                echo "NO SALES ON THIS BRANCH YET";
            }
    }

    // BRANCH RECORDS 
    if (isset($_POST['showBranchRecord'])) {
        $branchId = checkForm($_POST['bId']);
         
            $revenueQuery = mysqli_query($conn, "SELECT * FROM `revenue` WHERE branch_id = $branchId ORDER BY date DESC");
            if (!$revenueQuery) {
                die("REVENUE FETCH FAILED");
            }else if(mysqli_num_rows($revenueQuery) > 0){
                echo '<table class="table table-bordered table-responsive" id="page-table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>ITEM NAME</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>SECTION</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th>BY</th>
                        <th>RECEIPT</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>';
                $sn = 1;
                $totalSales = 0;
                
                while ($row = mysqli_fetch_assoc($revenueQuery)) {
                    $id = $row['id'];
                    $branchid = $row['branch_id'];
                    $itemId = $row['item_id'];
                    $itemName = ucwords($row['item_name']);
                    $sp = $row['selling_price'];
                    $qty = $row['qty'];
                    $amount = $row['amount'];
                    $section = ucwords($row['section']);
                    $pt  = $row['payment_type'];
                    $status = $row['status'];
                    $date = $row['date'];
                    $comment = $row['comment'];
                    $sellerId = $row['user_id'];
                    $sellerQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$sellerId");
                    
                    $totalSales += $amount;
                    if (!isset($sellerQuery)) {
                        die("FAILED TO VERIFY SELLER");
                    }else{
                        $fullname = ucwords(mysqli_fetch_assoc($sellerQuery)['fullname']);
                    }
                    // GET THE SALER NAME 

                    if (strtolower($section) === 'sales') {
                        // $itemNewName = $itemId;
                         $itemNameQuery = mysqli_query($conn, "SELECT *  FROM items WHERE id=$itemId");
                      
                        if (!$itemNameQuery) {
                            die("FAILED TO GET ITEM NAME ");
                        }else if(mysqli_num_rows($itemNameQuery) > 0){
                            $itemNewName = strtoupper(mysqli_fetch_assoc($itemNameQuery)['name']);
                           
                        }else{
                            $itemNewName = 'ITEM NOT FOUND';
                        }
                        
                    }else{
                        $itemNewName = $itemName;
                    }
                    echo "<tr>
                    <td>$sn</td>
                    <td>$itemNewName</td>
                    <td>$qty</td>
                    <td>$amount</td>
                    <td>$section</td>
                    <td>$date</td>
                    <td>$status</td>
                    <td>$fullname</td>
                    <td>
                        <a class='btn btn-success' id='$id' name='download-receipt' href='./dompdf/receipt.php?rid=$id' target='_blank'> <i class='fa fa-download' aria-hidden='true' ></i> Receipt</a>
                    </td>
                    <td>
                        <select name='action' id='action'>
                            <option selected disabled>Select Action </option>
                            <option value='return'>Return</option>
                            <option value='query'>Query</option>
                            <option value='edit'>Edit</option>
                        </select>
                    </td>
                </tr>";
                $sn++;
                    
                }
                $totalSales = number_format($totalSales);
                echo "</tbody>
                </table>
                <div mb-4> TOTAL SALES $totalSales </div>
                ";

            }else{
                echo "NO SALES ON THIS BRANCH YET";
            }
 
    }
    
    // EXPESES 
        // ADDING EXPENSES 
    if(isset($_POST['addingExpenses'])){
        $section = checkForm($_POST['section']);
        $description = checkForm($_POST['description']);
        $amount = checkForm($_POST['amount']);

        // CHECK FOR EMPTY FIELDS 
        if (!empty($amount) && !empty($section) && !empty($description)) {
            // SEND TO DATA BASE 
            $branchId = branchId();
            $eQuery = mysqli_query($conn, "INSERT INTO `expenses`(`branch_id`, `user_id`, `section`, `amount`, `description`) VALUES ($branchId, $userid, '$section', $amount, '$description')");

            if (!$eQuery) {
                die(error("EXPENSES FAILED ".mysqli_error($conn)));
            }else{
                echo success("EXPENSES SUBMITTED SUCCESSFULLY");
            }
        }else{
            echo error("ALL FIELDS REQUIRED");
        }
    }
        // ALL EXPENSES 
    if (isset($_POST['allExpenses'])) { 
        // SEND FOR EXPENSES 
        $eQuery = mysqli_query($conn, "SELECT * FROM `expenses` ORDER BY date DESC");
        if(!$eQuery){
            die(error("GETTING EXPENSES FAILED "));
        }else if(mysqli_num_rows($eQuery) > 0){
            $sn = 1;
            $totalExpenses = 0;
            echo "<h4 class='text-center text-primary'>ALL EXPENSES </h4><table class='table table-bordered table-responsive' id='page-table'>   <thead>
                <tr>
                    <th>S/N</th>
                    <th>AMOUNT</th>
                    <th>BRANCH</th>
                    <th>SECTION</th>
                    <th>DESCRIPTION</th>
                    <th>USER</th>
                    <th>DATE</th>
                </tr>
            </thead>
            <tbody>";

            while($row = mysqli_fetch_assoc($eQuery)){
                $id = $row['id'];
                $bId = $row['branch_id'];
                $uId = $row['user_id'];
                $section = ucwords($row['section']);
                $amount = $row['amount'];
                $description =  $row['description'];
                $date = $row['date'];
                $sAmount = number_format($amount);
                $userFullname = userFulName($uId);
                // BRANCH NAME 

                $bNameQuery = mysqli_query($conn, "SELECT * FROM `branch` WHERE id = $bId");
                if (!$bNameQuery) {
                    die("FAILED TO GET BRANCH");
                    
                }else if(mysqli_num_rows($bNameQuery) > 0){
                    $bName = ucwords(mysqli_fetch_assoc($bNameQuery)['branch_name']);
                }
                $totalExpenses += $amount;
                    echo "
                        <tr>
                            <td>$sn</td>
                            <td>$sAmount</td>
                            <td>$bName</td>
                            <td>$section</td>
                            <td>$description</td>
                            <td>$userFullname</td>
                            <td>$date</td>
                        </tr>
                   ";
            $sn++;
            }
            $totalExpenses = number_format($totalExpenses);

            echo " </tbody>
            </table> <div class='text-right text-success'> <strong>  Total Expenses: N $totalExpenses </strong></div>";
        }else{
            echo info("NO EXPENSES AVAILABLE IN THE SYSTEM");
        }
    }

    // DAILY EXPENSES 
    if (isset($_POST['dailyExpenses'])) { 
        // SEND FOR EXPENSES 
        $bId = branchId();
        $eQuery = mysqli_query($conn, "SELECT * FROM `expenses` WHERE branch_id=$bId AND   CAST( date AS Date ) = CAST( NOW() AS Date )  ORDER BY date DESC");
        if(!$eQuery){
            die(error("GETTING EXPENSES FAILED "));
        }else if(mysqli_num_rows($eQuery) > 0){
            $sn = 1;
            $totalExpenses = 0;
            echo "<h4 class='text-center text-primary'>DAILY EXPENSES </h4><table class='table table-bordered table-responsive' id='page-table'>   <thead>
                <tr>
                    <th>S/N</th>
                    <th>AMOUNT</th>
                    <th>BRANCH</th>
                    <th>SECTION</th>
                    <th>DESCRIPTION</th>
                    <th>USER</th>
                    <th>DATE</th>
                </tr>
            </thead>
            <tbody>";

            while($row = mysqli_fetch_assoc($eQuery)){
                $id = $row['id'];
                $bId = $row['branch_id'];
                $uId = $row['user_id'];
                $section = ucwords($row['section']);
                $amount = $row['amount'];
                $description =  $row['description'];
                $date = $row['date'];
                $sAmount = number_format($amount);
                // FULLNAME 
                $userFullname = userFulName($uId);
                // BRANCH NAME 

                $bNameQuery = mysqli_query($conn, "SELECT * FROM `branch` WHERE id = $bId");
                if (!$bNameQuery) {
                    die("FAILED TO GET BRANCH");
                    
                }else if(mysqli_num_rows($bNameQuery) > 0){
                    $bName = ucwords(mysqli_fetch_assoc($bNameQuery)['branch_name']);
                }
                $totalExpenses += $amount;
                    echo "
                        <tr>
                            <td>$sn</td>
                            <td>$sAmount</td>
                            <td>$bName</td>
                            <td>$section</td>
                            <td>$description</td>
                            <td>$userFullname</td>
                            <td>$date</td>
                        </tr>
                   ";
            $sn++;
            }
            $totalExpenses = number_format($totalExpenses);

            echo " </tbody>
            </table> <div class='text-right text-success'> <strong>  Total Expenses: N $totalExpenses </strong></div>";
        }else{
            echo info("NO EXPENSES AVAILABLE IN THE SYSTEM");
        }
    }

    // EXPENSES BY BRANCH SEARCH 
    if(isset($_POST['expensesByBranch'])){
        $branch = checkForm($_POST['branch']);
        $range = checkForm($_POST['range']);
        // CHECK FOR EMPTY FIELDS 

        if(!empty($branch) && !empty($range)){

            if (strtolower($range) === 'daily') {
             $eSQL = "SELECT * FROM expenses WHERE branch_id=$branch && CAST( date AS Date ) = CAST( NOW() AS Date ) ORDER BY date DESC";
            }elseif (strtolower($range) === 'weekly') {
                $eSQL = "SELECT * FROM expenses WHERE branch_id=$branch && (WEEK(date) = WEEK(now())) ORDER BY date DESC";
            }else if (strtolower($range) === 'monthly') {
                $eSQL = "SELECT * FROM expenses WHERE branch_id=$branch && (MONTH(date) = MONTH(now())) ORDER BY date DESC";
            }
           $eQuery = mysqli_query($conn, $eSQL);
            if (!$eSQL) {
                die("FAILED TO GET EXPENSES");
            }else if(mysqli_num_rows($eQuery) > 0){

                // BRING THE TABLE 
                $sn = 1;
                $totalExpenses = 0;
                $range = strtoupper($range);
                echo "<h4 class='text-center text-primary'>$range EXPENSES </h4><table class='table table-bordered table-responsive' id='page-table'>   <thead>
                    <tr>
                        <th>S/N</th>
                        <th>AMOUNT</th>
                        <th>BRANCH</th>
                        <th>SECTION</th>
                        <th>DESCRIPTION</th>
                        <th>USER</th>
                        <th>DATE</th>
                    </tr>
                </thead>
                <tbody>";
    
                while($row = mysqli_fetch_assoc($eQuery)){
                    $id = $row['id'];
                    $bId = $row['branch_id'];
                    $uId = $row['user_id'];
                    $section = ucwords($row['section']);
                    $amount = $row['amount'];
                    $description =  $row['description'];
                    $date = $row['date'];
                    $sAmount = number_format($amount);
                    $userFullname = userFulName($uId);
                    // BRANCH NAME 
    
                    $bNameQuery = mysqli_query($conn, "SELECT * FROM `branch` WHERE id = $bId");
                    if (!$bNameQuery) {
                        die("FAILED TO GET BRANCH");
                        
                    }else if(mysqli_num_rows($bNameQuery) > 0){
                        $bName = ucwords(mysqli_fetch_assoc($bNameQuery)['branch_name']);
                    }
                    $totalExpenses += $amount;

                        echo "
                            <tr>
                                <td>$sn</td>
                                <td>$sAmount</td>
                                <td>$bName</td>
                                <td>$section</td>
                                <td>$description</td>
                                <td>$userFullname</td>
                                <td>$date</td>
                            </tr>
                       ";
                $sn++;
                }
                $totalExpenses = number_format($totalExpenses);
    
                echo " </tbody>
                </table> <div class='text-right text-success'> <strong>  Total Expenses: N $totalExpenses </strong></div>";
            //    END OF TABLE 
            }else{
                echo info("NO EXPENSES AT THE MOMENT");
            }

        }else{
            echo error("ALL FIELDS REQUIRED");
        }
    }
    
    // UPDATE CATEGORY FORM 
    if (isset($_POST["categoryUpdate"])) {
        $cName = $_POST['cName'];
        $id = $_POST['cId'];
        
        // CHECK FOR EMPTY FIELDS 
        if(!empty($cName)){
        
            // CHECK FOR AVAILABILITY IN DB
            $checkCatQuery = mysqli_query($conn, "SELECT * FROM category WHERE category_name = '$cName'");
            if (!$checkCatQuery) {
                die(error("FAILED TO VERIFY CATEGORY"));
            }else if(mysqli_num_rows($checkCatQuery) < 1){
                // SEND UPDATE QUERY 
                $uCQuery = mysqli_query($conn, "UPDATE category SET category_name='$cName' WHERE id=$id");
                if (!$uCQuery) {
                    die(error("UNABLE TO UPDATE CATEGORY"));
                }else{
                    echo success("CATEGORY UPDATED SUCCESSFULLY");
                }
            }else{
                echo error("CATEGORY NAME ALREADY EXIST");
            }
        }else{
            echo error("ALL FIELDS REQUIRED");
        }
        
    }
    
    // UPDATE ITEMS
    if (isset($_POST['editItemForm'])) {
        $itemId = checkForm($_POST['itemId']);
        $cat = checkForm($_POST['category']);
        $subCat = checkForm($_POST['subCategory']);
        $itemName = checkForm($_POST['itemName']);
        $qty = checkForm($_POST['qty']);
        $cP = checkForm($_POST['costPrice']);
        $sP = checkForm($_POST['sellingPrice']);
        $fName = $_FILES['image']['name'];
        $size = $_FILES['image']['size'];
        $type = $_FILES['image']['type'];
        $tmp = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($fName, PATHINFO_EXTENSION));
  
        $extArray = ['jpeg', 'JPG', 'jpg', 'JPG', 'png', 'PNG'];
        
        
        if (!in_array($ext, $extArray)) {
            echo error("INVALID FILE TYPE ");
            }elseif (!empty($cat) && !empty($subCat) && !empty($itemName) && !empty($qty) && !empty($cP) && !empty($sP) && !empty($_FILES)) {
            //    CHECK IF ITEM ALREADY EXIST 
                $cIQuery = mysqli_query($conn, "SELECT * FROM `items` WHERE category_id=$cat AND sub_category_id=$subCat and name ='$itemName'");
                if (!$cIQuery) {
                    die("ITEM CHECK FAILED ");
                }else if(mysqli_num_rows($cIQuery) > 0){
                    // IF NULL SEND DETAILS TO DB AND MOVE FILED TO LOGIN USER FOLDER 
                    
                    $nCFName = $userid."_".$itemName."_".date("Y-m-d").".".$ext;
                    $cd = dirname(__DIR__, 2);
                    $p = $_SESSION['ePhone'];
                    if (move_uploaded_file($tmp, $cd."/users/sydeestack_$p/$nCFName")) {

                        // $sql = "INSERT INTO `items`(`category_id`, `sub_category_id`, `name`, `qty`, `cost_price`, `selling_price`, `image`, `user_id`) VALUES ($cat, $subCat, '$itemName', $qty, $cP, $sP, '$nCFName', $userid)";

                        $sql = "UPDATE items SET category_id=$cat, sub_category_id=$subCat, items.name='$itemName', qty=$qty, cost_price=$cP, selling_price=$sP, `image` = '$nCFName', `user_id`=$userid WHERE id = $itemId";


                        $aIQuery = mysqli_query($conn, $sql);
                        if (!$aIQuery) {
                            die(error("ADDING ITEM FAILED ".mysqli_error($conn)));
                        }else{
                            
                            echo success("ITEM UPDATED SUCCESSFULLY");
                        }
                    }
                }
            
            }else{
                echo erro("ALL FILLED REQUIRED");
            }
    }

    // ITEM RETURN 
    if (isset($_POST["itemReturn"])) {
        // SHOW THE SALES TABLE HERE 
            // GET THE BRANCH ID OF THE USERS
            // GET THE BRACH ID OF THE USER
            $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
            if (!$bQuery) {
                die("UNABLE TO GET ITEMS ".mysqli_error($conn));
              
            }
            $branchId = mysqli_fetch_assoc($bQuery)['branch_id']; 
            $revenueQuery = mysqli_query($conn, "SELECT * FROM `revenue` WHERE branch_id = $branchId ORDER BY date DESC");
            if (!$revenueQuery) {
                die("REVENUE FETCH FAILED");
            }else if(mysqli_num_rows($revenueQuery) > 0){
                echo '<table class="table table-bordered table-responsive" id="revenue-table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>ITEM NAME</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>SECTION</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th>BY</th>
                        <th>RECEIPT</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>';
                $sn = 1;
                $totalSales = 0;
                
                while ($row = mysqli_fetch_assoc($revenueQuery)) {
                    $id = $row['id'];
                    $branchid = $row['branch_id'];
                    $itemId = $row['item_id'];
                    $itemName = ucwords($row['item_name']);
                    $sp = $row['selling_price'];
                    $qty = $row['qty'];
                    $amount = $row['amount'];
                    $section = ucwords($row['section']);
                    $pt  = $row['payment_type'];
                    $status = $row['status'];
                    $date = $row['date'];
                    $comment = $row['comment'];
                    $sellerId = $row['user_id'];
                    $sellerQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$sellerId");
                    
                    $totalSales += $amount;
                    if (!isset($sellerQuery)) {
                        die("FAILED TO VERIFY SELLER");
                    }else{
                        $fullname = ucwords(mysqli_fetch_assoc($sellerQuery)['fullname']);
                    }
                    // GET THE SALER NAME 

                    if (strtolower($section) === 'sales') {
                        // $itemNewName = $itemId;
                         $itemNameQuery = mysqli_query($conn, "SELECT *  FROM items WHERE id=$itemId");
                      
                        if (!$itemNameQuery) {
                            die("FAILED TO GET ITEM NAME ");
                        }else if(mysqli_num_rows($itemNameQuery) > 0){
                            $itemNewName = strtoupper(mysqli_fetch_assoc($itemNameQuery)['name']);
                           
                        }else{
                            $itemNewName = 'ITEM NOT FOUND';
                        }
                        
                    }else{
                        $itemNewName = $itemName;
                    }
                    echo "<tr>
                    <td>$sn</td>
                    <td>$itemNewName</td>
                    <td>$qty</td>
                    <td>$amount</td>
                    <td>$section</td>
                    <td>$date</td>
                    <td>$status</td>
                    <td>$fullname</td>
                    <td>
                        <a class='btn btn-success' name='download-receipt' href='./dompdf/receipt.php?rid=$id' target='_blank'> <i class='fa fa-download' aria-hidden='true'></i> Receipt</a>
                    </td>
                    <td>
                        <select name='action' id='$id'>
                            <option selected disabled>Select Action </option>
                            <option value='return'>Return</option>
                            <option value='query'>Query</option>
                            <option value='edit'>Edit</option>
                        </select>
                    </td>
                </tr>";
                $sn++;
                    
                }
                $totalSales = number_format($totalSales);
                echo "</tbody>
                </table>
                <div mb-4> TOTAL SALES $totalSales </div>
                ";

            }else{
                echo "NO SALES ON THIS BRANCH YET";
            }
     
    }
    ?>          
    