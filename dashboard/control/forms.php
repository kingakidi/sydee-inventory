<?php 
    include "./functions.php";
    $userid = $_SESSION['eId'];
    // CREATE ADD CATEGORY FORM 
    if (isset($_POST['addCategoryForm'])) {
       echo '
            <div class="add-category" id="add-category">
            <form class="category-form" id="category-form">
                <div class="form-group">
                    <input type="text" placeholder="CATEGORY NAME" class="form-control" autocomplete="off" id="category-name">
                </div>
                <div class="error category-error form-group" id="category-error"></div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-category" id="btn-category">Submit</button>
                </div>
            </form>
            </div>
            ';
    }

    // CREATE SUB CATEGORY FORM 
    if (isset($_POST['subCategoryForm'])) {
       echo '
        <div class="add-category" id="add-category">
        <form class="sub-category-form" id="sub-category-form">
            <div class="form-group">
                <select name="category-name" id="category-name" class="form-control">
                    <option value="" disabled selected>Select Category</option>
        ';

            // BRINGS THE CATEGORIES 
            $cQuery = mysqli_query($conn, "SELECT * FROM category");
            if (!$cQuery) {
                die("CATEGORY FAILED");
            }
            while ($row = mysqli_fetch_assoc($cQuery)) {
               
                $id = $row['id'];
                $cName = strtoupper($row['category_name']);
                echo "<option value='$id'>$cName</option>";
            }
            
            echo '
                    </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Sub Category Name" id="sub-category-name">
                    </div>
                    <div class="error sub-category-error form-group" id="sub-category-error"></div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary btn-category" id="btn-sub-category">Submit</button>
                    </div>
                </form>
                </div>
            ';
    }

    // CREATE NEW ITEMS FORM 
    if (isset($_POST['newItemForm'])) {
      echo '
      <div class="item-container">
      <form class="item-form" id="item-form">
          <div class="row">
              <div class="col-sm">
                  <div class="form-group">
                    <label for="category">CATEGORY</label>
                      <select name="category" id="category" class="form-control category">
                          <option value="" selected disabled>SELECT CATEGORY</option>';
                          $catQuery = mysqli_query($conn, "SELECT * FROM category");
                        if(!$catQuery){
                            die("CATEGORY FAILED ");
                        }else if(mysqli_num_rows($catQuery) > 0){
                            while($row = mysqli_fetch_assoc($catQuery)){
                                $cName = strtoupper($row['category_name']);
                                $cId = $row['id'];
                                echo "<option value='$cId'>$cName</option>";
                            }
                            
                        }else{
                            echo "<option value=''>NO CATEGORY</option>";
                        }
        echo '</select>
                </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="sub-category">SUB CATEGORY</label>
                                <select name="sub-category" id="sub-category" class="form-control">
                                    <option value="">SELECT SUB CATEGORY</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                            <label for="item-name">ITEM NAME</label>
                        <input type="text" class="form-control" placeholder="ITEM NAME" id="item-name">
                    </div>
                    <div class="form-group">
                            <label for="qty">QUANTITY</label>
                            <input type="number" class="form-control" placeholder="QTY" id="qty">
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cost-price">COST PRICE</label>
                                <input type="number" class="form-control" placeholder="Cost Price" id="cost-price">
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                            <label for="selling-price">SELLING PRICE</label>
                            <input type="number" class="form-control" placeholder="Selling Price" id="selling-price">
                            </div>
                        </div>
                            
                    </div>
                    <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image">
                                <label class="custom-file-label" for="image">Choose Image</label>
                            </div>
                    </div> 
                    <div class="form-group error item-form-error" id="item-form-error"></div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary" id="btn-item">Submit</button>
                    </div>
                </form>
            </div>';
    }
    // CREATE BRANCH FORM 
    if (isset($_POST['createbranchForm'])) {
        echo '
            <div class="branch-container" id="branch-container">
            <form class="branch-form" id="branch-form">
                <label for="branch-name">Branch Name</label>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Branch Name" id="branch-name">
                </div>
                <div class="form-group">
                    <label for="address">Branch Address</label>
                    <textarea name="" id="address" cols="30" rows="3" class="form-control" placeholder="Branch Address"></textarea>
                </div>
                <div class="form-group">
                    <label for="facility-type">Select Facility Type</label>
                    <select name="facility-type" id="facility-type" class="form-control">
                        <option value="" selected disabled> Select Facility Type</option>
                        <option value="shop">Shop</option>
                        <option value="mall">Mall</option>
                        <option value="own">Own</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="number-of-shops">Number of Shops</label>
                    <input type="number" class="form-control" placeholder="Number of Shops" id="number-of-shops">
                </div>
                <div class="form-group">
                    <label for="rental-cost">Rental Cost</label>
                    <input type="number" class="form-control" placeholder="Rental Cost if rented" id="rental-cost">
                </div>
                <div class="form-group">
                    <label for="date">Last Rental Expiring Date</label>
                    <input type="date" class="form-control" id="date">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Password">
                </div>
                <div class="branch-form-error error" id="branch-form-error"></div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btn-branch">CREATE</button>
                </div>
        
            </form>
        </div>
        ';
    }
    
    // ADD ITEM TO BRANCH FORM 
    if (isset($_POST['addItemToBranch'])) {
       echo '
            <div class="item-to-branch" id="item-to-branch">
            <form class="item-to-branch-form" id="item-to-branch-form">
            
                <div class="form-group">
                    <label for="branch-name">Branch Name</label>
                    <select name="branch-name" id="branch-name" class="form-control">
                        <option value="" selected disabled>Branch Name</option>
            ';
            // BRING BRANCHES OPTIONS 
            $bQuery = mysqli_query($conn, "SELECT * FROM branch");
            if (!$bQuery) {
                die("BRANCH QUERY FAILED ");
            }else if(mysqli_num_rows($bQuery) > 0){
                while ($row = mysqli_fetch_assoc($bQuery)) {
                    $id = $row['id'];
                    $bName = strtoupper($row['branch_name']);
                    echo "<option value='$id'>$bName</option>";
                }
            }else{
                echo '<option value="">NO BRANCH UPLOADED</option>';
            }

        echo '
            </select>
            </div>';
            // BRING CATEGORY AND SUB CATEGORIES 
            echo '<div class="row">
            <div class="col-sm">
                <div class="form-group">
                  <label for="category">CATEGORY</label>
                    <select name="category" id="category" class="form-control category">
                        <option value="" selected disabled>SELECT CATEGORY</option>';
                        $catQuery = mysqli_query($conn, "SELECT * FROM category");
                      if(!$catQuery){
                          die("CATEGORY FAILED ");
                      }else if(mysqli_num_rows($catQuery) > 0){
                          while($row = mysqli_fetch_assoc($catQuery)){
                              $cName = strtoupper($row['category_name']);
                              $cId = $row['id'];
                              echo "<option value='$cId'>$cName</option>";
                          }
                          
                      }else{
                          echo "<option value=''>NO CATEGORY</option>";
                      }
      echo '</select>
                </div>
            </div>
            <div class="col-sm">
                <div class="form-group">
                   <label for="sub-category">SUB CATEGORY</label>
                    <select name="sub-category" id="sub-category" class="form-control">
                        <option value="">SELECT SUB CATEGORY</option>
                    </select>
                </div>
            </div>
        </div>';


            // END OF CATEGORY AND SUB CATEGORIES 
            echo '
            <div class="form-group">
                <label for="item-name">Select Item</label>
                <select name="item-name" id="item-name" class="form-control">
                    <option value="" disabled selected>Select Item</option>
            
            ';

            echo '</select>
                    </div>
                    <div class="show-item-info" id="show-item-info"></div>
                </form>
            </div>       
            ';
    }

    // ASSIGN 
    if (isset($_POST['userAssign'])) {
        echo '
            <form class="assign-form" id="assign-form">
                <div class="form-group">
                    <select name="action" id="action" class="form-control">
                        <option value="">Select Assign Action</option>
                        <option value="assignbranch">Assign Branch</option>
                        <option value="assignsection">Assign Section</option>
                    </select>
                </div>
                <div class="form-group" id="show-assign">
                    
                </div>
            </form>
        ';
    }

    // ASSIGN FORM 
    if (isset($_POST['assignBranchForm'])) {
        // BRINGS ALL BRANCH 
        $bQuery = mysqli_query($conn, "SELECT * FROM branch WHERE status='active'");
        if (!$bQuery) {
            die(error("BRANCH QUERY FAILS"));
        }else if(mysqli_num_rows($bQuery) > 0){
            echo '
                <div class="form-group">
                <select name="branch-name" id="branch-name" class="branch-name form-control">
                <option value="" selected disabled>Select Branch Name</option>
                ';
            while ($row = mysqli_fetch_assoc($bQuery)) {
                $id = $row['id'];
                $branchName = ucwords($row['branch_name']);
               echo "<option value='$id'>$branchName</option>";
            }
            echo '</select>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="Enter Password">
                </div>
                <div class="error branch-form-error" id="branch-form-error"></div>
                <div class="form-group text-right">
                    <button class="btn btn-primary" id="btn-assign-submit">
                        Assign
                    </button>
                </div>
            ';
        }else{
            echo '<option value="">NO BRANCH UPLOADED</option>';
        }
    }

    // EDUCATIONAL FORM 
    if (isset($_POST['personalform'])) {
      echo '
      <div class="profile" id="profile">
      <form class="personal-form" id="personal-form">
          <div class="form-group">
              <label for="title">Title</label>
              <select name="title" id="title" class="form-control">
                  <option value="" selected disabled>Select Title</option>
                  <option value="miss">Miss</option>
                  <option value="mr">Mr</option>
                  <option value="mrs">Mrs</option>
                  <option value="dr">Dr</option>
                  <option value="prof">Prof</option>
                  <option value="technician">Technician</option>
              </select>
          </div>
          <!-- STATE OF ORIGIN  -->
          <div class="form-group">
                  <label class="control-label">State of Origin</label>
              <select
                  onchange="toggleLGA(this);"
                  name="state"
                  id="state"
                  class="form-control"
                  >
                  <option value="" selected="selected">- Select -</option>
                  <option value="Abia">Abia</option>
                  <option value="Adamawa">Adamawa</option>
                  <option value="AkwaIbom">AkwaIbom</option>
                  <option value="Anambra">Anambra</option>
                  <option value="Bauchi">Bauchi</option>
                  <option value="Bayelsa">Bayelsa</option>
                  <option value="Benue">Benue</option>
                  <option value="Borno">Borno</option>
                  <option value="Cross River">Cross River</option>
                  <option value="Delta">Delta</option>
                  <option value="Ebonyi">Ebonyi</option>
                  <option value="Edo">Edo</option>
                  <option value="Ekiti">Ekiti</option>
                  <option value="Enugu">Enugu</option>
                  <option value="FCT">FCT</option>
                  <option value="Gombe">Gombe</option>
                  <option value="Imo">Imo</option>
                  <option value="Jigawa">Jigawa</option>
                  <option value="Kaduna">Kaduna</option>
                  <option value="Kano">Kano</option>
                  <option value="Katsina">Katsina</option>
                  <option value="Kebbi">Kebbi</option>
                  <option value="Kogi">Kogi</option>
                  <option value="Kwara">Kwara</option>
                  <option value="Lagos">Lagos</option>
                  <option value="Nasarawa">Nasarawa</option>
                  <option value="Niger">Niger</option>
                  <option value="Ogun">Ogun</option>
                  <option value="Ondo">Ondo</option>
                  <option value="Osun">Osun</option>
                  <option value="Oyo">Oyo</option>
                  <option value="Plateau">Plateau</option>
                  <option value="Rivers">Rivers</option>
                  <option value="Sokoto">Sokoto</option>
                  <option value="Taraba">Taraba</option>
                  <option value="Yobe">Yobe</option>
                  <option value="Zamfara">Zamafara</option>
                  </select>
              </div>
  
          <div class="form-group">
              <label class="control-label" selected disabled>LGA of Origin</label>
              <select
              name="lga"
              id="lga"
              class="form-control select-lga"
              required
              >
              </select>
          </div>
  
          <h4>WORKING EXPERIENCE</h4>
          <div class="form-group">
              <label for="place-of-work">Last Place of Work</label>
              <input type="text" placeholder="Name of Place of Work" class="form-control">
          </div>
          <div class="form-group">
              <input type="text" class="form-control position" id="position" placeholder="Position">
          </div>
          <div class="form-group">
              <label for="start-date">Start Date</label>
              <input type="date" id="start-date" class="form-control">
          </div>
          <div class="form-group">
              <label for="end-date">End Date </label>
              <input type="date" class="form-control" id="end-date">
          </div>
        </form>
    <div>     
        ';
    }
    // PERSONAL DETAILS 
    if (isset($_POST['educationForm'])) {
       echo '
            <div class="educational" id="education">
            <form>
            
            <div class="form-group">
                <label for="primary-name" id="primary-name">Primary School</label>
                <input type="text" id="primary-name" class="form-control" placeholder="Name of Primary School">
            </div>


            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="start-date">Start Date</label>
                        <input type="date" class="form-control" id="start-date" placeholder="Start Date">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="end-start">End Date</label>
                        <input type="date" class="form-control" id="start-date" placeholder="End Date">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="title">Certificate Title</label>
                <select name="title" id="title" class="title form-control">
                        <option value="" selected disabled>Certificate Type</option>
                        <option value="fslc">FSLC</option>
                        <option value="ssce">SSCE</option>
                        <option value="ond">OND</option>
                        <option value="nce">NCE</option>
                        <option value="hnd">HND</option>
                        <option value="bsc">BSC</option>
                        <option value="beng">B Eng</option>
                        <option value="master">Master</option>
                    </select>
            </div>

            <h4>SECONDARY SCHOOL CERTIFICATE</h4>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="start-date">Start Date</label>
                        <input type="date" class="form-control" id="start-date" placeholder="Start Date">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="end-start">End Date</label>
                        <input type="date" class="form-control" id="start-date" placeholder="End Date">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="title">Certificate Title</label>
                <select name="title" id="title" class="title form-control">
                        <option value="" selected disabled>Certificate Type</option>
                        <option value="fslc">FSLC</option>
                        <option value="ssce">SSCE</option>
                        <option value="ond">OND</option>
                        <option value="nce">NCE</option>
                        <option value="hnd">HND</option>
                        <option value="bsc">BSC</option>
                        <option value="beng">B Eng</option>
                        <option value="master">Master</option>
                    </select>
            </div>

            <h4>TERTIARY SCHOOL CERTIFICATE</h4>
            <div class="form-group">
                <label for="tertiary-school" id="tertiary-school">Tertiary School</label>
                <input type="text" id="tertiary-school" class="form-control" placeholder="Name of Tertiary School">
            </div>

            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="start-date">Start Date</label>
                        <input type="date" class="form-control" id="start-date" placeholder="Start Date">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="end-start">End Date</label>
                        <input type="date" class="form-control" id="start-date" placeholder="End Date">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="title">Certificate Title</label>
                <select name="title" id="title" class="title form-control">
                        <option value="" selected disabled>Certificate Type</option>
                        <option value="fslc">FSLC</option>
                        <option value="ssce">SSCE</option>
                        <option value="ond">OND</option>
                        <option value="nce">NCE</option>
                        <option value="hnd">HND</option>
                        <option value="bsc">BSC</option>
                        <option value="beng">B Eng</option>
                        <option value="master">Master</option>
                    </select>
            </div>
        </form>
        </div>';
    }

    // SALES
    if (isset($_POST['salesForm'])) {
        echo '<div class="search-container" id="search-container">
        <div class="search-form" id="search-form">
            <div class="form-group">
                <input type="text" placeholder="SEARCH ITEM" class="form-control" id="search-term">
            </div>
           
            <div class="show-search" id="show-search"></div>
        </div>
        
        </div>';
    }
    // BRING SALES FORM 
    if (isset($_POST['fetchSaleItem'])) {

        $itemId = $_POST['itemId'];
        $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$bQuery) {
            die("UNABLE TO GET ITEMS ".mysqli_error($conn));
            exit();
        }
        $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];
       
        $sIQuery = mysqli_query($conn, "SELECT branch_items.qty, branch_items.item_id, items.image, items.cost_price, items.selling_price, items.name  FROM `branch_items` JOIN items ON branch_items.item_id = items.id WHERE item_id =$itemId and branch_id =$branchId");
        $sIRow = mysqli_fetch_assoc($sIQuery);
        $branchQty = $sIRow['qty'];
        $itemId = $sIRow['item_id'];
        $image = $sIRow['image'];
        $costPrice = $sIRow['cost_price'];
        $sellingPrice = $sIRow['selling_price'];
        $fSellingPrice = number_format($sellingPrice);
        $name = strtoupper($sIRow['name']);
        // SHOW ITEM 
        echo "
            <div class='sale-container' id='sale-container'>
                    <table class='table table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td>$name</td>
                    </tr>
                    <tr>
                        <td>Qty in Stock</td>
                        <td>$branchQty</td>
            
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td>$fSellingPrice</td>
                    </tr>
                </table>
               
            <form id='sale-form' class='sale-form'>
                <div>
                    <input type='number' id='selling-price' placeholder='' value='$sellingPrice' hidden>
                </div>
                
                ";
        ?>
            <div class='form-group'>
                <input type='number' class='form-control' id='qty-purchase' placeholder='Qty Purchase' min='1' step="1" oninput="validity.valid||(value='1');" required>
                </div>
                <?php
                echo "
                <div class='form-group'>
                    Total Amount:  <span class='show-amount' id='show-amount'> $fSellingPrice</span>
                </div>
                <div>
                <label for='open-amount'>This sale has discount</label>
                    <input type='checkbox' id='open-amount'>
                </div>
                <div class='form-group'>
                    <input type='number' class='form-control' id='discounted-amount' placeholder='Discounted Price' disabled>
                </div>
                <div class='form-group'>
                    <label for='comment'>Comment</label>
                    <textarea name='comment' id='comment' class='form-control' required></textarea>
                </div>
                <div class='form-group'>
                    <label for='payment-type'>Payment Type </label>
                    <select name='payment-type' id='payment-type' class='form-control' required>
                        <option value='' selected disabled>Payment Type</option>
                        <option value='cash'>Cash</option>
                        <option value='unionbank'>Union Bank</option>
                        <option value='gtbank'>GT Bank</option>
                        
                    </select>
                </div>
                <div class='error form-sale-error' id='form-sale-error'></div>
                <div class='form-group text-right'>
                    <button class='btn btn-primary' id='sales-submit'>Submit</button>
                </div>
            </form>
        </div>
        ";
        
    }

    // BRING INTERNET FORM 
    if (isset($_POST['internetForm'])) {
        echo '<form id="sale-internet" class="sale-internet">
            <div class="form-group">
                <label for="type">TYPE</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="" selected disabled>Select Type</option>
                    <option value="photocopy">Photocopy</option>
                    <option value="laminating">Laminating</option>
                    <option value="registration">Registration</option>
                    <option value="navyreg">Navy Registration</option>
                    <option value="armyreg">Army Registration</option>
                    <option value="airforcereg">Airforce Registration</option>
                    <option value="remita">Remita</option>
                    <option value="waecreg">WAEC Registration</option>
                    <option value="necoreg">NECO Registration</option>
                    <option value="nabtebreg">NABTEB Registration </option>
                    <option value="resultcheck"> Result Check</option>
                    <option value="others">Others</option>
                </select>
            </div>
           ';
            ?>
             <div class="form-group">
                <label for="amountQty">Amount Per Qty</label>
                <input type="number" class="form-control" placeholder="Amount Per Qty" id="amountQty" min='1' step="1"  required>
            </div>
            <div class='form-group'>
                <label for="qty">Quantity</label>
                <input type='number' class='form-control' id='qty' value='1' placeholder='Quantity' min='1' step="1" oninput="validity.valid||(value='');" required>
            </div>
            <?php 
        echo "<div class='form-group'>
                Total Amount:  <span class='show-amount' id='show-amount'> </span>
            </div>
            <div>
                <label for='open-amount'>This sale has discount</label>
                <input type='checkbox' id='open-amount'>
            </div>
            <div class='form-group'>
                <input type='number' class='form-control' id='discounted-amount' placeholder='Discounted Price' disabled>
            </div>
            <div class='form-group'>
                <label for='comment'>If Discounted State Comment</label>
                <textarea name='comment' id='comment' class='form-control' required></textarea>
            </div>
            <div class='form-group'>
                <label for='payment-type'>Payment Type </label>
                <select name='payment-type' id='payment-type' class='form-control' required>
                    <option value='' selected disabled>Payment Type</option>
                    <option value='cash'>Cash</option>
                    <option value='unionbank'>Union Bank</option>
                    <option value='gtbank'>GT Bank</option>
                    
                </select>
            </div>
            <div class='error form-internet-error' id='form-internet-error'></div>
            <div class='form-group text-right'>
                <button class='btn btn-primary' id='internet-submit'>Submit</button>
            </div>
        </form>    ";
    }
    // ENGINEERING FORM 
    if (isset($_POST['engineeringForm'])) {
        echo '<form id="sale-engineering" class="sale-engineering">
            <div class="form-group">
                <label for="type">TYPE</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="" selected disabled>Select Type</option>
                    <option value="troubleshooting">Troubleshooting</option>
                    <option value="screen">Screen</option>
                    <option value="hdd">HDD</option>
                    <option value="formatting">Formatting</option>
                    <option value="installation">Installation</option>
                    <option value="driver">Drivers</option>
                    <option value="display">Display</option>
                    <option value="charging">Charging</option>
                    <option value="boardissues">Board Issues</option>
                    <option value="others">Others</option>
                    
                </select>
            </div>
           ';
            ?>
             <div class="form-group">
                <label for="amountQty">Amount Per Qty</label>
                <input type="number" class="form-control" placeholder="Amount Per Qty" id="amountQty" min='1' step="1" oninput="validity.valid||(value='');" required>
            </div>
            <div class='form-group'>
                <label for="qty">Quantity</label>
                <input type='number' class='form-control' id='qty' value='1' placeholder='Quantity' min='1' step="1" oninput="validity.valid||(value='');" required>
            </div>
            <?php 
        echo "<div class='form-group'>
                Total Amount:  <span class='show-amount' id='show-amount'> </span>
            </div>
            <div>
                <label for='open-amount'>This sale has discount</label>
                <input type='checkbox' id='open-amount'>
            </div>
            <div class='form-group'>
                <input type='number' class='form-control' id='discounted-amount' placeholder='Discounted Price' disabled>
            </div>
            <div class='form-group'>
                <label for='comment'>If Discounted State Comment</label>
                <textarea name='comment' id='comment' class='form-control' required></textarea>
            </div>
            <div class='form-group'>
                <label for='payment-type'>Payment Type </label>
                <select name='payment-type' id='payment-type' class='form-control' required>
                    <option value='' selected disabled>Payment Type</option>
                    <option value='cash'>Cash</option>
                    <option value='unionbank'>Union Bank</option>
                    <option value='gtbank'>GT Bank</option>
                    
                </select>
            </div>
            <div class='error form-internet-error' id='form-internet-error'></div>
            <div class='form-group text-right'>
                <button class='btn btn-primary' id='internet-submit'>Submit</button>
            </div>
        </form>    ";
    }
    // SHOW TRAINING CONTAINER 
    if (isset($_POST['trainingContainer'])) {
        echo '<div class="training-details-container" id="training-details-container">       
                    <button class="btn btn-primary" id="form">Form</button>
                    <button class="btn btn-primary" id="trainingfees">Training Fees</button>
                    <button class="btn btn-primary" id="certificate">Certificate</button>
            <div  id="show-training-form" class="m-4">
                
            </div>
            </div>';
    }
    // SHOW TRAINING FORM 
    if (isset($_POST['trainingForm'])) {
        echo '<form class="training-form" id="training-form">
                <div class="form-group">
                    <label for="regno"> Reg No </label>
                    <input type="text" class="form-control regno" id="regno" placeholder="Reg No" required>
                </div>
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control fullname capitalize" id="fullname" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="number" class="form-control phone" id="phone" placeholder="Phone Number" required>
                </div>
                <div class="form-group">
                    <label for="charge-price">Charge Amount</label>
                    <input type="number" class="charge-price form-control" id="charge-price" placeholder="Charge Amount" required>
                </div>
                <div class="form-group">
                    <label for="amount"> Amount Paid </label>
                    <input type="number" class="form-control" id="amount"  placeholder="Amount Paid" required>
                </div>
                <div class="form-group">
                    <label for="type">Select Program Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="" selected disabled>Select Program Type</option>
                        <option value="1-month-certificate">1-Month Certificate</option>
                        <option value="3-months-diploma">3-Months Diploma</option>
                        <option value="6-months-diploma">6-Months Diploma</option>
                        <option value="3-months-web-development">3-Months Web Development</option>
                        <option value="6-months-web-development">6-Months Web Development</option>
                        <option value="software-development">Software Development</option>
                        <option value="IT/Siwes">IT/Siwes</option>
                        <option value="1-year-repair">1-Year Repair</option>
                        <option value="special-program">Special Program</option>
                    </select>
            
                </div>
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="comment" placeholder="Enter Comment"  class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="payment-type">Payment Type</label>
                    <select name="payment-type" id="payment-type" class="form-control payment-type" required>
                        <option value="" selected disabled> Select Payment Type</option>
                        <option value="cash">Cash</option>
                        <option value="unionbank">Union Bank</option>
                        <option value="gtbank">GT Bank</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="payment-status">Payment Status</label>
                    <select name="payment-status" id="payment-status" class="form-control" required>
                        <option value="" selected>Select Payment Status</option>
                        <option value="complete">Complete</option>
                        <option value="deposit">Deposit</option>
                        <option value="schorlarship">schorlaship</option>
                    </select>
                </div>
                <div class="error training-form-error mt-3 mb-3" id="training-form-error"></div>
                <div class="form-group text-right">
                    <button type="submit" id="btn-training-form" class="btn btn-primary"> Submit </button>
                </div>
            </form>';
    }
    // TRAINING FEES FORM 
    if (isset($_POST['trainingFessForm'])) {
        // GET AVAILABLE FORMS 
      
        $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$bQuery) {
            die("UNABLE TO GET ITEMS ".mysqli_error($conn));
            exit();
        }
        $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];
        $regNoQuery = mysqli_query($conn, "SELECT * FROM forms WHERE status = 'pending' AND branch_id=$branchId ORDER BY forms.date DESC");
        // print_r(mysqli_fetch_assoc($regNoQuery));

       echo '
            <form class="trainingFees" id="trainingFees">
            <div class="form-group">';
            
        
       
            echo '<select name="regno" id="regno" class="form-control" required>
                    <option value="" Selected disabled>Select Reg No</option>
            ';
            if (!$regNoQuery) {
                die("REG NO FAILED ".mysqli_error($conn));
            }else if(mysqli_num_rows($regNoQuery) > 0){
               while ($row = mysqli_fetch_assoc($regNoQuery)) {
                $date = ($row['date']);
                $formId = $row['form_id'];
                $amount = $row['amount'];
                $regNo = strtoupper($row['reg_no']);
                $fullname = $row['fullname'];
                $phone = $row['phone'];
                $programType = $row['program_type'];
                $paymentStatus = $row['payment_status'];
                $form_status = $row['form_status'];
                echo "<option> $regNo </option>";
               }
               echo '</select>
               </div>';
            }else{
                echo '<option value="">NO PENDING FORM</option>';
            }
               
        echo '  <div class="show-reg-form" id="show-reg-form"></div>
            </form>';
    }
    // CERTIFICATE FORM 
    if (isset($_POST['certificateForm'])) {
        $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$bQuery) {
            die("UNABLE TO GET ITEMS ".mysqli_error($conn));
            exit();
        }
        $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];
 
       echo '
            <form class="trainingFees" id="trainingFess">
            <div class="form-group">';
            $regNoQuery = mysqli_query($conn, "SELECT *, forms.id as form_id, forms.status as form_status, revenue.status as payment_status FROM revenue JOIN forms ON revenue.item_name = forms.reg_no AND forms.status = 'completed' AND revenue.branch_id=$branchId");

        
       
            echo '<select name="regno" id="regno" class="form-control" required>
                    <option value="" Selected disabled>Select Reg No</option>
            ';
            if (!$regNoQuery) {
                die("REG NO FAILED ".mysqli_error($conn));
            }else if(mysqli_num_rows($regNoQuery) > 0){
               while ($row = mysqli_fetch_assoc($regNoQuery)) {
                $date = ($row['date']);
                $formId = $row['form_id'];
                $amount = $row['amount'];
                $regNo = strtoupper($row['reg_no']);
                $fullname = $row['fullname'];
                $phone = $row['phone'];
                $programType = $row['program_type'];
                $paymentStatus = $row['payment_status'];
                $form_status = $row['form_status'];
                echo "<option> $regNo </option>";
               }
               echo '</select>
               </div>';
            }else{
                echo '<option value="">NO PENDING FORM</option>';
            }
               
        // echo '<form class="form-certificate" id="certificate">
        //         <div class="form-group">
        //             <input type="text" class="form-control" placeholder="Type Student Reg No">
        //         </div>
        //     </form>';
    }
    if (isset($_POST['showRegForm'])) {
        $regNo = mysqli_real_escape_string($conn, $_POST['regNo']);
        // CHECK IF NOT EMPTY 
        if(!empty($regNo)){
            $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
            
            if (!$bQuery) {
                die("UNABLE TO GET ITEMS ".mysqli_error($conn));
                exit();
            }
            $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];
            $regNoQuery = mysqli_query($conn, "SELECT *, forms.id as form_id, forms.status as form_status, revenue.status as payment_status FROM revenue JOIN forms ON revenue.item_name = forms.reg_no AND forms.status = 'pending' AND forms.reg_no = '$regNo'");

            if (!$regNoQuery) {
                die("REG NO FAILED ".mysqli_error($conn));
            }else if(mysqli_num_rows($regNoQuery) > 0){
               $row = mysqli_fetch_assoc($regNoQuery);
                $date = ($row['date']);
                $formId = $row['form_id'];
                $amount = $row['amount'];
                $regNo = strtoupper($row['reg_no']);
                $fullname = $row['fullname'];
                $phone = $row['phone'];
                $programType = strtoupper($row['program_type']);
                $paymentStatus = strtoupper($row['payment_status']);
                $form_status = $row['form_status'];
               
                echo "<table class='table'>
                <tr>
                    <td>Date of Form Collection </td>
                    <td>$date</td>
                </tr>
                <tr>
                    <td>Program Type</td>
                    <td>$programType</td>
                </tr>
                <tr>
                    <td>Form Payment Status</td>
                    <td>$paymentStatus</td>
                </tr>
            </table>";

            if (strtolower($paymentStatus) === 'completed' OR strtolower($paymentStatus) === 'complete') {
                
                echo " 
                <div class='form-group'>
                    <label for='fullname'>Full Name</label>
                    <input type='text' id='fullname' placeholder='Student Full Name' class='form-control capitalize' value='$fullname'>
                </div>
                <div class='form-group'>
                    <label for='phone'>Phone Number</label>
                    <input type='number' id='phone' placeholder='Phone Number' class='form-control' value='$phone' required>
                </div>
                ";
                ?>
                <input type="text" value="<?php echo $regNo ?>" id="form-no" hidden> 
                <div class='form-group'>
                    <label for='email'>Email Address</label>
                    <input type='email' id='email' placeholder='Email Address' class='form-control lowercase' required>
                </div>
                <div class='form-group'>
                    <label for='student-address'>Student Address</label>
                    <textarea name='student-address' id='student-address' class='form-control capitalize' placeholder='Student Address' required></textarea>
                </div>
                <div class='form-group'>
                    <label for='guardian-name'>Guardian Name  <input type='checkbox' id='guardian-name-sameas'>
                    <label for='guardian-name-sameas'> Same as Student Name</label> </label>
                    <input type='text' id='guardian-name' placeholder='Guardian Name' class='form-control capitalize' required>
                </div>
             
                <div class='form-group'>
                    <label for='guardian-address'>Guardian Address   <input type='checkbox' id='guardian-address-sameas'>
                    <label for='guardian-address-sameas'> Same as Student Address </label></label>

                    <textarea name='guardian-address' id='guardian-address' class='form-control capitalize' placeholder='Guardian Address'></textarea>
                </div>
                <div class='form-group'>
                <label for='program-type'>Select Program Type</label>
                    <select name='program-type' id='program-type' class='form-control'>
                        <option value='' selected disabled>Select Program Type</option>
                        <option value='1-month-certificate'>1-Month Certificate</option>
                        <option value='3-months-diploma'>3-Months Diploma</option>
                        <option value='6-months-diploma'>6-Months Diploma</option>
                        <option value='3-months-web-development'>3-Months Web Development</option>
                        <option value='6-months-web-development'>6-Months Web Development</option>
                        <option value='software-development'>Software Development</option>
                        <option value='IT/Siwes'>IT/Siwes</option>
                        <option value='1-year-repair'>1-Year Repair</option>
                        <option value='special-program'>Special Program</option>
                    </select>
                </div>
                <div class='form-group'>
                    
                    <label for='amount-charged'>Amount Charge</label>
                    <input type='number' class='form-control' placeholder='Amount Charge' id='amount-charged'  min='1' step="1" oninput="validity.valid||(value='');" required>
                </div>
                <div class='form-group'>
                    <label for='amount-paid'>Amount Paid</label>
                    <input type='number' class='form-control' placeholder='Amount Paid' id='amount-paid' min='1' step="1" oninput="validity.valid||(value='');" required>
                </div>

                
                <div class='form-group'>
                    <label for='comment'>Comment</label>
                    <textarea name='comment' id='comment' class='form-control' placeholder='Enter Comment' required></textarea>
                </div>
                
                <div class='form-group'>
                    <label>Select form (PDF Only)</label>
                    <div class='custom-file'>
                        <input type='file' class='custom-file-input' id='fillForm' required>
                        <label class='custom-file-label' for='fillForm'>Select Filled Form</label>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='payment-status'>Payment Status</label>
                    <select name='payment-status' id='payment-status' class='form-control' required>
                        <option value='' selected disabled>Select Payment Status</option>
                        <option value='completed'>Completed</option>
                        <option value='deposit'>Deposit</option>
                        <option value='scholarship'>Scholarship</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment-type">Payment Type</label>
                    <select name="payment-type" id="payment-type" class="form-control">
                        <option value="" selected disabled> Select Payment Type </option>
                        <option value="cash">Cash</option>
                        <option value="gtbank">GT Bank</option>
                        <option value="unionbank">Union Bank</option>
                    </select>
                </div>
                <div class='error training-fees-error' id='training-fees-error'></div>
                <div class='form-group text-right mt-2'>
                    <button type='submit' class='btn btn-info' id='btn-training-fees'>Submit</button>
                </div>

                <?php
            }else{
                echo "<span class='text-info'> KINDLY COMPLETE YOUR FORM PAYMENT TO PROCEED </span>";
            }
               
            }else{
                echo 'NO DATA FOUND';
            }
        }else{
            echo "REG NO CANT BE EMPTY";
        }
    }

    // BRING DEBTOP SALES FORM 
    if (isset($_POST['debtorFetchSaleItem'])) {

        $itemId = $_POST['itemId'];
        $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$bQuery) {
            die("UNABLE TO GET ITEMS ".mysqli_error($conn));
            exit();
        }
        $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];
       
        $sIQuery = mysqli_query($conn, "SELECT branch_items.qty, branch_items.item_id, items.image, items.cost_price, items.selling_price, items.name  FROM `branch_items` JOIN items ON branch_items.item_id = items.id WHERE item_id =$itemId and branch_id =$branchId");
        $sIRow = mysqli_fetch_assoc($sIQuery);
        $branchQty = $sIRow['qty'];
        $itemId = $sIRow['item_id'];
        $image = $sIRow['image'];
        $costPrice = $sIRow['cost_price'];
        $sellingPrice = $sIRow['selling_price'];
        $fSellingPrice = number_format($sellingPrice);
        $name = strtoupper($sIRow['name']);
        // SHOW ITEM 
        echo "
            <div class='sale-container' id='sale-container'>
                    <table class='table table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td>$name</td>
                    </tr>
                    <tr>
                        <td>Qty in Stock</td>
                        <td>$branchQty</td>
            
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td>$fSellingPrice</td>
                    </tr>
                </table>
               
            <form id='sale-form' class='sale-form'>
                <div>
                    <input type='number' id='selling-price' placeholder='' value='$sellingPrice' hidden>
                </div>
                
                ";
        ?>
            <div class='form-group'>
                <input type='number' class='form-control' id='qty-purchase' placeholder='Qty Purchase' min='1' step="1" oninput="validity.valid||(value='1');" required>
                </div>
                <?php
                echo "
                <div class='form-group'>
                    Total Amount:  <span class='show-amount' id='show-amount'> $fSellingPrice</span>
                </div>
                <div>
                <label for='open-amount'>This sale has discount</label>
                    <input type='checkbox' id='open-amount'>
                </div>
                <div class='form-group'>
                    <input type='number' class='form-control' id='discounted-amount' placeholder='Discounted Price' disabled>
                </div>
                <div class='form-group'>
                    <label for='comment'>Comment</label>
                    <textarea name='comment' id='comment' class='form-control' placeholder='Enter Comment' required></textarea>
                </div>
                <div class='form-group'>
                    <label for='creditor-list'>Select Creditor</label>
                    <select name='creditor-list' id='creditor-list' class='form-control' required> 
                        <option value='' selected disabled>Select Creditor</option> ";
                        // GET THE CREDITOR 
                        $cQuery = mysqli_query($conn, "SELECT * FROM creditor WHERE status = 'active'");
                        if (!$cQuery) {
                            die("CREDITOR FAILED ");
                        }else if(mysqli_num_rows($cQuery) < 1){
                            echo "<option value='' disabled>NO CREDITOR ADDED ON THE SYSTEM</option> ";
                        }else{
                            while ($row = mysqli_fetch_assoc($cQuery)) {
                                $phone = $row['phone'];
                                $id = $row['id'];
                                $name = ucwords($row['name']) ." ". $phone;
                                echo "<option value='$id'> $name </option> ";
                            }
                           
                        }
                       
                echo "
                    </select>
                </div>
                <div class='form-group'>
                    <label for='payment-type'>Payment Type </label>
                    <select name='payment-type' id='payment-type' class='form-control' required>
                        <option value='credit' selected disabled>Credit</option>
                        
                        
                    </select>
                </div>
                <div class='error form-sale-error' id='form-sale-error'></div>
                <div class='form-group text-right'>
                    <button class='btn btn-primary' id='sales-submit'>Submit</button>
                </div>
            </form>
        </div>
        ";
        
    }

    // CREDITORS 
    if (isset($_POST['creditors'])) {
        // SHOW CREDITOR CONTAINERS 
        echo ' <div class="creditor" id="creditor">
             <button class="view-creditor btn btn-primary" id="view-creditor">View Creditor</button>
             <button class="add-creditor btn btn-primary" id="add-creditor">Add Creditor</button>
             <div id="creditor-form-container" class="mt-3"></div>
     
      
     </div>';
    }

    // CREDITOR FORM 
    if (isset($_POST['creditorForm'])) {
       echo '<form class="creditor-form" id="creditor-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Full name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Email Address" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="number" class="form-control" id="phone" placeholder="Phone Number" max-length="11" min-length="11" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="" selected disabled>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>

                </div>
                <div class="form-group">
                    <label for="organization">Orgainization</label>
                    <input type="text" class="form-control" id="organization"  placeholder="Organization" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" class="form-control" placeholder="Address" required></textarea>
                </div>
                <div class="error creditor-form-error" id="creditor-form-error"></div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btn-creditor">Submit</button>
                </div>
            </form>';
    }

    // PROGRAM 
    if (isset($_POST['programs'])) {
        echo '<div class="item-link-container" id="program">
                    
                            <button class="view-program btn btn-primary" id="view-program">View Program</button>
                            <button class="add-program btn btn-primary" id="add-program">Add Program</button>
                   
                    <div class="program-form-container mt-3" id="program-form-container"></div>
            </div>';
    }

    // PROGRAM FORM 
    if (isset($_POST['addProgramForm'])) {
      echo '<form class="program" id="program-form">  
                <div class="form-group">
                    <label for="program-name"> Program Name</label>
                    <input type="text" id="program-name" placeholder="Program Name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="duration">Program Duration (in Months) </label>
                    <input type="number" id="duration" placeholder="Program Duration" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fees">Program Cost</label>
                    <input type="number" id="fees" placeholder="Program Cost" class="form-control" required>
                </div>
                <div class="error program-form-error" id="program-form-error"></div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btn-program">Submit</button>
                </div>
            </form>';
    }

    // PAYMENT 
    if (isset($_POST['payments'])) {
        echo '<div class="payments-container" id="payment-container">
                <button class="btn btn-primary view-payment" id="view-payment">View Payment</button>
                <button class="btn btn-primary add-payment" id="add-payment">Add Payment</button>
        
                <div class="payment-form-container mt-3" id="payment-form-container">
                    
                </div>
            </div>';
    }

    // PAYMENT FORM 
    if (isset($_POST['paymentTypeForm'])) {
        echo '<form class="payments-form" id="payments-form">
                <div class="form-group">
                    <input type="text" id="type-name" placeholder="Cash or Bank Name" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="number" id="account-number" placeholder="Account Number if Bank" class="form-control">
                </div>
                <div class="error payment-form-error" id="payment-form-error"></div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btn-payment">Submit</button>
                </div>
            </form>';
    }
    if (isset($_POST['revenueSearchForm'])) {
       echo '<form class="search-form" id="search-form">
                <div class="form-group">
                    <label for="by">Search By</label>
                    <select id="by" class="form-control by">
                        <option value="" disabled selected>Select Search By</option>
                        <option value="all"> All </option>
                        <option value="branch"> Branch </option>
                    </select>
                </div>
            </form>';
    }

    // BRANCH ITEMS 
    if (isset($_POST['branchItemForm'])) {
     
        $aBQuery = mysqli_query($conn, "SELECT * FROM branch WHERE status='active'");
        if (!$aBQuery) {
            die("BRANCH ITEMS FAILED ".mysqli_error($conn));
        }else if(mysqli_num_rows($aBQuery) > 0){
            
            echo "<div class='form-group'>
            <label for='branch'>Select Branch</label>
            <select name='branch' id='branch' class='select form-control'>
            <option  value='' selected disabled> Select Branch</option>";
            while ($row = mysqli_fetch_assoc($aBQuery)) {
                $id = $row['id'];
                $name = ucwords($row['branch_name']);
                    echo "
                           
                            <option value='$id'>$name</option>
                      
                    ";

            }
            echo "</select>
                </div>
                <div id='show-branch-items'></div>";
        }else{
            echo info("NO BRANCH ON THE SYSTEM");
        }

    }

    // ALL REVENUE RECORDS 
    if (isset($_POST['allRevenueRecords'])) {
        echo '<div class="all-revenue-form mt-3" id="all-revenue-form">
                <button class="btn btn-primary" name="btn-revenue" id="all-records">All Records</button>
                <button class="btn btn-primary" name="btn-revenue" id="record-by-branch">Records by Branch</button>
                <button class="btn btn-primary" name="btn-revenue" id="search-record">Search Records</button>
            </div>
            <div class="show-all-revenue mt-3" id="show-all-revenue"></div>';
    }

    // BRANCH RECORDS 
    if(isset($_POST['recordByBranch'])){
        $aBQuery = mysqli_query($conn, "SELECT * FROM branch WHERE status='active'");
        if (!$aBQuery) {
            die("BRANCH ITEMS FAILED ".mysqli_error($conn));
        }else if(mysqli_num_rows($aBQuery) > 0){
            
            echo "<div class='form-group'>
            <label for='branch'>Select Branch</label>
            <select name='branch' id='branch' class='select form-control'>
            <option  value='' selected disabled> Select Branch</option>";
            while ($row = mysqli_fetch_assoc($aBQuery)) {
                $id = $row['id'];
                $name = ucwords($row['branch_name']);
                    echo "
                           
                            <option value='$id'>$name</option>
                      
                    ";

            }
            echo "</select>
                </div>
                <div id='show-branch-record'></div>";
        }else{
            echo info("NO BRANCH ON THE SYSTEM");
        }
    }

    // SEARCH RECORD 
    if(isset($_POST['searchRecord'])){
        $aBQuery = mysqli_query($conn, "SELECT * FROM branch WHERE status='active'");
        if (!$aBQuery) {
            die("BRANCH ITEMS FAILED ".mysqli_error($conn));
        }else if(mysqli_num_rows($aBQuery) > 0){
            
            echo "<form class='search-form' id='search-form'><div class='row'> 
                <div class='col-sm'>
                <div class='form-group'>
                    <label for='branch'>Select Branch</label>
                    <select name='branch' id='branch' class='select form-control'>
                    <option  value='' selected disabled> Select Branch</option>";
                    while ($row = mysqli_fetch_assoc($aBQuery)) {
                        $id = $row['id'];
                        $name = ucwords($row['branch_name']);
                            echo "
                                
                                    <option value='$id'>$name</option>
                            
                            ";

                    }
                echo "</select>
                    </div>
                    </div>
                    <div class='col-sm'>
                        <div class='form-group'>
                            <label>Enter Search Keywords </label>
                            <input type='text' class='form-control search-term' id='search-term' placeholder='Enter Search Term'>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-sm'>
                        <div class='form-group'>
                            <label for='start-date'>Start Date</label>
                            <input type='date' class='form-control' placeholder='Start Date'>
                        </div>
                    </div>
                    <div class='col-sm'>
                        <div class='form-group'>
                            <label for='end-date'>End Date</label>
                            <input type='date' class='form-control'placeholder='End Date'>
                        </div>
                    </div>
                </div>
                <div class='form-group text-right'>
                        <button type='submit' id='btn-search' class='btn btn-primary'>Search</button>
                </div>
                </form>


                <div id='show-branch-record'></div>";
        }else{
            echo info("NO BRANCH ON THE SYSTEM");
        }
    }

    if(isset($_POST['expenses'])){
        echo '<div class="form-group">
            <button class="btn btn-primary" id="daily-expenses" name="btn-expenses">Daily Expenses</button>
            <button class="btn btn-primary" id="all-expenses" name="btn-expenses">All Expenses</button>
            <button class="btn btn-primary" id="add-expenses" name="btn-expenses">Add Expenses</button>
            <button class="btn btn-primary" id="expenses-by-branch" name="btn-expenses">Expenses By Branch</button>
        </div>
        <div class="show-sub" id="sub-show"></div>';
    }

    if (isset($_POST['expensesForm'])) {
        echo '<h4 class="text-center text-primary"> EXPENSES FORM </h4><form class="expenses-form" id="expenses-form">
        <div class="form-group">
            <label for="section">Select Section</label>
            <select name="" id="section" class="select form-control" required>
                <option value="" selected disabled>Select Section</option>
                <option value="general">general</option>
                <option value="sales">Sales</option>
                <option value="internet">Internet</option>
                <option value="engineering">Engineering</option>
                <option value="training">Training</option>
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" id="amount" placeholder="Enter amount" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea  id="description"  class="form-control" placeholder="Enter Description" required></textarea>
        </div>
        <div class="error error-expenses" id="error-expenses"></div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
        </div>
        </form>';
    }


    if(isset($_POST['expensesByBranchForm'])){
        echo '<form class="ebb-form" id="ebb-form">';     
            //  GET ALL THE BRANCH 

        $aBQuery = mysqli_query($conn, "SELECT * FROM branch WHERE status='active'");
        if (!$aBQuery) {
            die("BRANCH ITEMS FAILED ".mysqli_error($conn));
        }else if(mysqli_num_rows($aBQuery) > 0){
            
            echo "<div class='form-group'>
            <label for='branch'>Select Branch</label>
            <select name='branch' id='branch' class='select form-control'>
            <option  value='' selected disabled> Select Branch</option>";
            while ($row = mysqli_fetch_assoc($aBQuery)) {
                $id = $row['id'];
                $name = ucwords($row['branch_name']);
                    echo "
                           
                            <option value='$id'>$name</option>
                      
                    ";

            }
            echo "</select>
                </div>
                <div class='form-group'>
                    <label for='range'>Select Range</label>
                    <select name='range' id='range' class='form-control'>
                        
                        <option value=''>Select Range</option>
                        <option value='daily'>Daily</option>
                        <option value='weekly'>Weekly</option>
                        <option value='monthly'>Monthly</option>
                        
                    </select>
                </div>
                <div class='form-group text-right'>
                 
                    <button type='submit' id='btn-submit' class='btn btn-primary'> Get </button>
                </div>

                <div id='show-branch-expenses'></div>";
   
    }
    }

    // CATEGORY EDIT FORM 
    if (isset($_POST['editCategoryForm'])) {
      $id = $_POST['id'];
        //   GET THE CATEGORY 
        $gQuery = mysqli_query($conn, "SELECT * FROM category WHERE id=$id");

        if (!$gQuery) {
            die("FAILED TO GET CATEGORY");
        }else{
            $row = mysqli_fetch_assoc($gQuery);
            $cName =ucwords($row['category_name']);
        }
      
        echo "<form class='edit-category-form' id='edit-category-form'>
        <div class='form-group'>
            
            <input type='text' class='form-control' id='catName' value='$cName' required>
        </div>
        <div class='error edit-category-error form-group' id='edit-category-error'></div>
        <div class='form-group text-right'>
            <button type='submit'  class='btn btn-primary' id='btn-edit-category'>Update</button>
        </div>
    </form>";
    }


    // EDIT ITEMS 
    if (isset($_POST['editItemsForm'])) {

        $id = checkForm($_POST['id']);
        $iQuery = mysqli_query($conn, "SELECT * FROM items WHERE id=$id");     
        
        if (!$iQuery) {
            die("FAILED TO GET ITEMS ".mysqli_error($conn));
        }else{
            $row = mysqli_fetch_assoc($iQuery);
            $id = $row['id'];
            $catId = $row['category_id'];
            $subCatId = $row['sub_category_id'];
            $name = strtoupper($row['name']);
            $qty = $row['qty'];
            $costPrice = $row['cost_price'];
            $sellingPrice = $row['selling_price'];
            $image = $row['image'];
            $userid = $row['user_id'];
       
        echo '
        <div class="item-container">
        <form class="item-form" id="item-form">
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                      <label for="category">CATEGORY</label>
                        <select name="category" id="category" class="form-control category">';
                            $catQuery = mysqli_query($conn, "SELECT * FROM category WHERE id=$catId");
                          if(!$catQuery){
                              die("CATEGORY FAILED ");
                          }else if(mysqli_num_rows($catQuery) > 0){
                              while($row = mysqli_fetch_assoc($catQuery)){
                                  $cName = strtoupper($row['category_name']);
                                  $cId = $row['id'];
                                  echo "<option value='$cId' selected disabled>$cName</option>";
                              }
                          }else{
                              echo "<option value=''>NO CATEGORY</option>";
                          }

                        //   REMAINING CATEGORY 
                        $rCatQuery = mysqli_query($conn, "SELECT * FROM category WHERE id !=$catId");
                        if(!$rCatQuery){
                            die("CATEGORY FAILED ");
                        }else if(mysqli_num_rows($rCatQuery) > 0){
                            while($row = mysqli_fetch_assoc($rCatQuery)){
                                $cName = strtoupper($row['category_name']);
                                $cId = $row['id'];
                                echo "<option value='$cId'>$cName</option>";
                            }
                        }else{
                            echo "<option value=''>NO CATEGORY</option>";
                        }
          echo "</select>
                  </div>
                          </div>
                          <div class='col-sm'>
                              <div class='form-group'>
                                  <label for='sub-category'>SUB CATEGORY</label>
                                  <select name='sub-category' id='sub-category' class='form-control'>";
                                    //   GET THE SUB CATEGORY 
                                    $subCatQuery = mysqli_query($conn, "SELECT * FROM sub_category WHERE id=$subCatId");
                                    if(!$subCatQuery){
                                        die("CATEGORY FAILED ");
                                    }else if(mysqli_num_rows($subCatQuery) > 0){
                                        while($row = mysqli_fetch_assoc($subCatQuery)){
                                            $cName = strtoupper($row['sub_category_name']);
                                            $cId = $row['id'];
                                            echo "<option value='$cId' selected>$cName</option>";
                                        }
                                    }else{
                                        echo "<option value=''>NO CATEGORY</option>";
                                    }


                                    // GET THE REMAINING SUB CATEGORY 

                                    $rSubCatQuery = mysqli_query($conn, "SELECT * FROM sub_category WHERE id !=$subCatId AND category_id=$catId");
                                    if(!$rSubCatQuery){
                                        die("CATEGORY FAILED ");
                                    }else if(mysqli_num_rows($rSubCatQuery) > 0){
                                        while($row = mysqli_fetch_assoc($rSubCatQuery)){
                                            $cName = strtoupper($row['sub_category_name']);
                                            $cId = $row['id'];
                                            echo "<option value='$cId'>$cName</option>";
                                        }
                                    }else{
                                        echo "<option value=''>NO CATEGORY</option>";
                                    }
                                echo "  </select>
                              </div>
                          </div>
                      </div>
                      <div class='form-group'>
                              <label for='item-name'>ITEM NAME</label>
                          <input type='text' class='form-control' placeholder='ITEM NAME' id='item-name' value='$name'>
                      </div>
                      <div class='form-group'>
                              <label for='qty'>QUANTITY</label>
                              <input type='number' class='form-control' placeholder='QTY' id='qty' value='$qty'>
                      </div>
                      <div class='row'>
                          <div class='col-sm'>
                              <div class='form-group'>
                                  <label for='cost-price'>COST PRICE</label>
                                  <input type='number' class='form-control' placeholder='Cost Price' id='cost-price' value='$costPrice'>
                              </div>
                          </div>
                          <div class='col-sm'>
                              <div class='form-group'>
                              <label for='selling-price'>SELLING PRICE</label>
                              <input type='number' class='form-control' placeholder='Selling Price' id='selling-price' value='$sellingPrice'>
                              </div>
                          </div> 
                      </div>
                      <div class='form-group'>
                              <div class='custom-file'>
                                  <input type='file' class='custom-file-input' id='image'>
                                  <label class='custom-file-label' for='image'>Choose Image</label>
                              </div>
                      </div> 
                      <div class='form-group error item-form-error' id='item-form-error'></div>
                      <div class='form-group text-right'>
                          <button type='submit' class='btn btn-primary' id='btn-item'>Submit</button>
                      </div>
                  </form>
              </div>";
            }


      }


    // RETURN ITEM FORM 
    if (isset($_POST['returnForm'])) {
        $id = checkForm($_POST['id']);
        $revenueQuery = mysqli_query($conn, "SELECT * FROM `revenue` WHERE id=$id AND status != 'return'");
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
                        <th>DATE </th>
                        <th>BY</th>
                        <th>RECEIPT</th>
                       
                    </tr>
                </thead>
                <tbody>';
                $sn = 1;
                $totalSales = 0;
                
                $row = mysqli_fetch_assoc($revenueQuery);

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
                    <td>$date</td>
                    <td>$fullname</td>
                    <td>
                        <a class='btn btn-success' id='$id' name='download-receipt' href='./dompdf/receipt.php?rid=$id' target='_blank'> <i class='fa fa-download' aria-hidden='true'></i> Receipt</a>
                    </td>
                    
                </tr>";
               
                $totalSales = number_format($totalSales);
                echo "</tbody>
                </table>";
                
                echo "<div class='form-group'>
                    <input type='number' class='form-control' value='$qty' id='qty' disabled hidden>
                </div>
                <div class='form-group'>
                    <input type='number' class='form-control' value='$amount' id='amount' disabled hidden>
                </div>";
                echo '<form class="return-form" id="return-form">
                <!-- GET THE ITEM INFO  -->
                <div class="form-group">
                    <textarea name="comment" id="comment" placeholder="Enter comment" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Enter Your Password" class="form-control" required>
                </div>
                <div class="error return-error form-group" id="return-error"></div>
                <div class="form-group text-right">
                    <button class="btn btn-primary"> Return </button>
                </div>
            </form>';

            }else{
                echo "THIS SALES IS ALREADY RETURNED";
            }
    }
?>

