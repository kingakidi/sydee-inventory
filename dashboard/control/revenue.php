<?php
    $userid = $_SESSION['eId'];
?>

<div class="item" id="item">
    <div class="item-link-container" id="item-link-container">
        <div>
            <a href="?p=revenue" class="item-link" id="todaysales">RECORD</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="all-records">ALL RECORDS</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="sales">SALES</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="internet">INTERNET</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="engineering">ENGINEERING</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="training">TRAINING</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="credit">CREDIT</a>
        </div> 
        <div>
            <a class="item-link" name="p-link" id="expenses">EXPENSES</a>
        </div>   
        <div>
            <a class="item-link" name="p-link" id="return">RETURN ITEMS</a>
        </div>       
        <div>
            <a class="item-link" name="p-link" id="search">SEARCH</a>
        </div>  
    </div>
    <div class="show-item mt-3" id="show-item">
         <?php 
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
                        <a class='btn btn-success' id='$id' name='download-receipt' href='./dompdf/receipt.php?rid=$id' target='_blank'> <i class='fa fa-download' aria-hidden='true'></i> Receipt</a>
                    </td>
                    <td>
                        <select name='action' id='action'>
                            <option selected disabled>Select Action </option>
                        
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
         ?>
    </div>
</div>

