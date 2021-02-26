<?php 
        $output = "  <style>
            table {
                border-collapse: collapse;
                }

                caption {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
                color: #858796;
                text-align: left;
                caption-side: bottom;
                }

                th {
                text-align: inherit;
                text-align: -webkit-match-parent;
                }

                .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #423f3f;
                }

                .table th,
                .table td {
                padding: 0.5rem;
                vertical-align: top;
                border-top: 1px solid #e3e6f0;
                }

                .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #e3e6f0;
                }

                .table tbody + tbody {
                border-top: 2px solid #e3e6f0;
                }
                .table-bordered {
                    border: 1px solid #e3e6f0;
                    }

                    .table-bordered th,
                    .table-bordered td {
                    border: 1px solid #e3e6f0;
                    }

                    .table-bordered thead th,
                    .table-bordered thead td {
                    border-bottom-width: 2px;
                    }

            </style>
            ";
            
            include('../../control/conn.php');
            $userid = $_SESSION['eId'];


            $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
            if (!$bQuery) {
                die("UNABLE TO GET ITEMS ".mysqli_error($conn));
              
            }
            $branchId = mysqli_fetch_assoc($bQuery)['branch_id']; 

            $revenueQuery = mysqli_query($conn, "SELECT * FROM `revenue` WHERE branch_id = $branchId  ORDER BY date DESC");
            if (!$revenueQuery) {
                die("REVENUE FETCH FAILED");
            }else if(mysqli_num_rows($revenueQuery) > 0){
                $output .= '<table class="table table-bordered table-responsive" id="revenue-table">
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
                    $output .= "<tr>
                    <td>$sn</td>
                    <td>$itemNewName</td>
                    <td>$qty</td>
                    <td>$amount</td>
                    <td>$section</td>
                    <td>$date</td>
                    <td>$status</td>
                    <td>$fullname</td>
                   
                </tr>";
                $sn++;
                    
                }
                $totalSales = number_format($totalSales);
                $output .= "</tbody>
                </table>
                
                <div style='text-align: right'> <strong> TOTAL SALES N $totalSales </strong></div>";

            }
            require_once('dompdf/autoload.inc.php');
    
            use Dompdf\Dompdf;
        
            $pdf = new Dompdf();
            $pdf-> loadHtml($output);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            $pdf-> stream('receipt.pdf', Array('Attachment'=> 0));
         ?>