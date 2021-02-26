<!-- Content Row -->
<?php 
     $userid = $_SESSION['eId'];
  // FUNCTIONS FOR NUM ROWS 
  function rNumRows($sql){
    global $conn;
    $query = mysqli_query($conn, $sql);
    if (!$query) {
       return die(("GETTING VALUE FAILED").mysqli_error($conn));
    }else{
        return mysqli_num_rows($query);
    }
   
}

    // TOTAL REVENUE 
    function totalRevenue($sql){
        global $conn;
        $query = mysqli_query($conn, $sql);
        if (!$query) {
           return die(("REVENUE FAILED ".mysqli_error($conn)));
        }else{
          return (mysqli_fetch_assoc($query)['total']);
        }
    }
?>

<div class="row">
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            No of Branches</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?php echo rNumRows("SELECT * FROM branch"); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-bar-chart text-primary fa-2x" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        No of Items</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo rNumRows("SELECT * FROM items"); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-bar-chart text-success fa-2x" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">No of Users
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                   <?php 
                                          echo rNumRows("SELECT * FROM users");
                                   ?>
                                </div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-bar-chart text-info fa-2x" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                      No of Students</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo rNumRows("SELECT * FROM training"); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-money text-gray fa-2x" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Row -->

<!-- Content Row -->
<div class="row">
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                           No of Forms</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo rNumRows("SELECT * FROM forms"); ?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-hand-o-left fa-2x text-success" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
        <a href="./dompdf/daily.php" class="link">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Today Stats</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800"> Sales
                        <?php  $sql = "SELECT sum(amount) as total FROM revenue WHERE CAST( date AS Date ) = CAST( NOW() AS Date ) AND (revenue.status = 'paid' OR revenue.status = 'completed' OR revenue.status = 'deposit')";
                             $dailySales = totalRevenue($sql);
                             echo '<del style="text-decoration-style: double;">N</del>'." ".  number_format($dailySales); ?> <br>

                            Expenses:   <?php  $dSQL = "SELECT sum(amount) as total FROM expenses WHERE CAST( date AS Date ) = CAST( NOW() AS Date )";
                            $dailyExpenses = totalRevenue($dSQL);
                            echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($dailyExpenses); ?><br>
                            Diff:
                            <?php $wDiff = ($dailySales - $dailyExpenses); echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($wDiff); ?> 
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-hand-o-left fa-2x text-success" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>

    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
        <a href="./dompdf/week.php" class="link">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                           WEEKLY STATS
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Sales: 
                             <?php  $sql = "SELECT sum(amount) as total FROM revenue WHERE (WEEK(date) = WEEK(now())) AND (revenue.status = 'paid' OR revenue.status = 'completed' OR revenue.status = 'deposit')";
                             $weekSales = totalRevenue($sql);
                             echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($weekSales); ?>
                             <br>

                             Expenses:   <?php  $wESQL = "SELECT sum(amount) as total FROM expenses WHERE (WEEK(date) = WEEK(now()))";
                             $weekExpenses = totalRevenue($wESQL);
                             echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($weekExpenses); ?><br>
                                Diff:
                             <?php $wDiff = ($weekSales - $weekExpenses); echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($wDiff); ?>

                              
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-bars fa-2x text-success" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
        <a href="./dompdf/month.php" class="link">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                           Monthly STATS</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Sales<?php  $sql = "SELECT sum(amount) as total FROM revenue WHERE (MONTH(date) = MONTH(now())) AND (revenue.status = 'paid' OR revenue.status = 'completed' OR revenue.status = 'deposit')";
                             $monthSales = totalRevenue($sql);
                             echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($monthSales); ?>
                            <br>

                            Expenses:   <?php  $wESQL = "SELECT sum(amount) as total FROM expenses WHERE (MONTH(date) = MONTH(now()))";
                            $monthExpenses = totalRevenue($wESQL);
                            echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($monthExpenses); ?><br>
                            Diff:
                            <?php $wDiff = ($monthSales - $monthExpenses); echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($wDiff); ?> 
                            </div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-hand-o-left fa-2x text-success" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </a>
        </div>
    </div>

 
</div>
<!-- Content Row -->

<!-- Content Row -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
        <a href="./dompdf/all.php" class="link">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            TOTAL STATS</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800"><?php
                             $sql = "SELECT SUM(amount) as total FROM `revenue` WHERE revenue.status = 'paid' OR revenue.status = 'deposit' or revenue.status = 'completed'";
                             $totalSales = totalRevenue($sql);
                             echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($totalSales);
                        
                             
                        
                        ?> <br>

                        Expenses:   <?php  $totalSQL = "SELECT sum(amount) as total FROM expenses";
                        $totalExpenses = totalRevenue($totalSQL);
                        echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($totalExpenses); ?><br>
                        Diff:
                        <?php $tDiff = ($totalSales - $totalExpenses); echo '<del style="text-decoration-style: double;">N</del>'." ". number_format($tDiff); ?> </div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-hand-o-left fa-2x text-success" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </a>
        </div>
    </div>

    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                           My Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php  $sql = "SELECT sum(amount) as total FROM revenue WHERE (user_id = $userid) AND (revenue.status = 'paid' OR revenue.status = 'completed' OR revenue.status = 'deposit')";
                             
                             echo '<del style="text-decoration-style: double;">N</del>'." ". number_format(totalRevenue($sql)); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-bars fa-2x text-success" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
</div>
<!-- Content Row -->



        
 