<div class="item" id="item">
    
    <div class="item-link-container" id="item-link-container">
        <div>
            <a href="?p=items" class="item-link" id="items">ITEMS</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="newitem">NEW ITEM</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="createbranch"> BRANCH</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="itemtobranch">ITEM TO BRANCH</a>

        </div>   
        <div>
            <a class="item-link" name="p-link" id="branchitems">BRANCH ITEMS</a>
        </div> 
        <div>
            <a class="item-link" name="p-link" id="search">SEARCH</a>
        </div> 
    </div>
    <div class="show-item mt-3" id="show-item">
        <div class="item-more m-3" id="item-more">
            <button class="btn btn-primary" name="btn-item-more" id="store-items">Store Items</button>  <button class="btn btn-primary" name="btn-item-more" id="all-items">All Items</button>
        </div>
      <div class="sub-show" id="sub-show">
      <?php
            $iQuery = mysqli_query($conn, "SELECT * FROM `items` ORDER BY date DESC");
            if (!$iQuery) {
                die(("FAILD TO FETCH ITEMS ").mysqli_error($conn));

            }else if(mysqli_num_rows($iQuery)){
                // PRINT ITEMS 
                echo '
                <table class="table table-bordered table-responsive">
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
                            echo "</tr>
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
                echo ("NO ITEM UPLOADED YET ");
            }
        ?>
        
       </div>
           
         
    </div>
</div>


<!-- <th>CATEGORY</th> -->
<!-- <td>$catName</td> -->
 





