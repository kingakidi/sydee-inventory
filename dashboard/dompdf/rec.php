<?php
include('../../control/conn.php');
if (isset($_GET['rid'])) {
    $rid = $_GET['rid'];
    // GET DETAILS FROM REVENUE TABLE
    $rQuery = mysqli_query($conn, "SELECT * FROM `revenue` WHERE id = $rid");
    if (!$rQuery) {
        die("RECEIPT FAILED ".mysqli_error($conn));
    }else if(mysqli_num_rows($rQuery) > 0){

        $row = mysqli_fetch_assoc($rQuery);
        $bId = $row['branch_id'];
        $itemName = $row['item_name'];
        $qty = $row['qty'];
        $amount = number_format($row['amount']);
        $section = $row['section'];
        $paymentType = $row['payment_type'];
        $status = $row['status'];
        $date = $row['date'];
        $uId = $row['user_id'];
      
        $output = "<div id='invoice-POS'>

        <div id='top'>
          <div class='logo'></div>
          <div class='info'> 
            <h2>Esphem Computers</h2>
          </div><!--End Info-->
        </div><!--End InvoiceTop-->
        
        <div id='mid'>
          <div class='info'>
            <h3>Contact Info</h3>
            <p> 
                Address : Suite 1, Destiny Garden Plaza, Lokoja, Kogi State</br>
                Branch  : $bId <br>
                Sales Rep : $uId
            </p>
          </div>
        </div><!--End Invoice Mid-->
        
        <div id='bot'>
    
         
    
                        <div id='table'>
                            <table>
                                <tr class='tabletitle'>
                                    <td class='item'><h2>Item</h2></td>
                                    <td class='Hours'><h2>Qty</h2></td>
                                    <td class='Rate'><h2>Sub Total</h2></td>
                                </tr>
    
                        
    
                                <tr class='service'>
                                    <td class='tableitem'><p class='itemtext'>$itemName</p></td>
                                    <td class='tableitem'><p class='itemtext'>$qty</p></td>
                                    <td class='tableitem'><p class='itemtext'>N $amount</p></td>
                                </tr>					
    
                            </table>
                        </div><!--End Table-->
    
                        <div id='legalcopy'>
                            <p class='legal'>
                                Email   : esphemcomputes@gmail.com</br>
                                Phone   : 08185345123</br>
                                <strong>Thank you for your patronage!</strong>   
                            </p>
                        </div>
    
                    </div><!--End InvoiceBot-->
      </div>
        <style>
        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 5mm;
            margin: 0 auto;
            width: 70mm;
            background: #fff;
          }
          #invoice-POS ::selection {
            background: #f31544;
            color: #fff;
          }
          #invoice-POS ::moz-selection {
            background: #f31544;
            color: #fff;
          }
          #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
          }
          #invoice-POS h2 {
            font-size: 0.9em;
          }
          #invoice-POS h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
          }
          #invoice-POS p {
            font-size: 0.7em;
            color: #666;
            line-height: 1.2em;
          }
          #invoice-POS #top,
          #invoice-POS #mid,
          #invoice-POS #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #eee;
          }
          #invoice-POS #top {
            min-height: 100px;
          }
          #invoice-POS #mid {
            min-height: 80px;
          }
          #invoice-POS #bot {
            min-height: 50px;
          }
          #invoice-POS #top .logo {
            height: 60px;
            width: 60px;
            background: url(./logo.png) no-repeat;
            background-size: 60px 60px;
          }
          #invoice-POS .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background: url(./logo.png) no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
          }
          #invoice-POS .info {
            display: block;
            margin-left: 0;
          }
          #invoice-POS .title {
            float: right;
          }
          #invoice-POS .title p {
            text-align: right;
          }
          #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
          }
          #invoice-POS .tabletitle {
            font-size: 0.5em;
            background: #eee;
          }
          #invoice-POS .service {
            border-bottom: 1px solid #eee;
          }
          #invoice-POS .item {
            width: 24mm;
          }
          #invoice-POS .itemtext {
            font-size: 0.5em;
          }
          #invoice-POS #legalcopy {
            margin-top: 5mm;
          }
          #top {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
          }
          
        </style>
      ";
    }else {
        echo "SALES NOT AVAILABLE IN THE SYSTEM";
    }
}
  

    require_once('dompdf/autoload.inc.php');
    
    use Dompdf\Dompdf;

    $pdf = new Dompdf();
    $pdf-> loadHtml($output);
    $pdf->setPaper('A4', 'landscape');
    $pdf->render();
    $pdf-> stream();
?>