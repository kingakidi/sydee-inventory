<?php



    include('../../control/conn.php');

    
    require_once 'dompdf/autoload.inc.php';
    // reference the Dompdf namespace
    use Dompdf\Dompdf;

    // instantiate and use the dompdf class
    $pdf = new pdf();
    

    // Output the generated PDF to Browser
    $pdf->stream("test.php", Array('Attachment' =>0));
    if (isset($_GET['testId'])) {
        $testId = $_GET['testId'];
        // SELECT ENROL USERS 
        $testTitle = mysqli_fetch_assoc( mysqli_query($conn, "SELECT title FROM test WHERE id=$testId"))['title'];
        $enrolQuery = mysqli_query($conn, "SELECT * FROM enrol WHERE testid=$testId AND attendance_status='attend'");
        ;
        
        
        if (!$enrolQuery) {
            die("CAN'T GET THE RESULT AT THE MOMENT ".mysqli_error($conn));
        }else{
            $output =  '<div class="container mt-3">
            <table class="table table-bordered" id="resultTable" style="border: 1px solid #e3e6f0; width: 100%; margin-bottom: 1rem;color: #858796; margin-bottom: 1rem; color: #858796; border-collapse: collapse; border: 1px solid #dee2e6;" >
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Score</th>                   
                </tr>
          
            <tbody>
            ';
            $sn = 1;
            foreach ($enrolQuery as $row) {
                $userId = $row['userid'];
                // GET THE USER DETAILS 
                $uDQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userId");
                if (!$uDQuery) {
                    die("UNABLE TO GET USER DETAILS ");
                }else {
                    $uDRow = mysqli_fetch_assoc($uDQuery);
                    $fullname = ucwords($uDRow['fullname']);
                    $e = $uDRow['email'];
                    $phone = $uDRow['phone'];
                    $output .= "
                        <tr>
                            <td>$sn</td>
                            <td>$fullname</td>
                            <td>$phone</td>
                            <td>$e</td>
                    ";

                }
                // GET ALL QUESTION ANSWER MY THIS USER
                $sumQuery = mysqli_query($conn, "SELECT SUM(mark) as mark, time FROM `user_answer` WHERE testid=$testId AND userid=$userId ORDER BY mark ASC" );
                             
                if (!$sumQuery) {
                    die("GET SET TOTAL SCORE ".mysqli_error($conn));
                }else {
                    $sumRow = mysqli_fetch_assoc($sumQuery);
                    $sum = $sumRow['mark'];
                    $time = $sumRow['time'];
                    $output .="
                        <td>$sum</td>
                        <td>$time</td>
                       
                    </tr>
                    ";
                  
                }
                $sn++;
            }
            $output .="
            </tbody>
            </table>
            </div>
            ";           
        }
    }

    $pdf->loadHtml('hello world');

    // (Optional) Setup the paper size and orientation
    $pdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $pdf->render();

?>