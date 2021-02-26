<?php 
    include('../../control/conn.php');
    $userid = $_SESSION['eId'];
    function checkForm ($data){
        global $conn;
        return strtolower(trim(mysqli_escape_string($conn, $data)));
    }
    function checkPass ($data)   {
        global $conn;
        return mysqli_escape_string($conn, $data);
    }
    function truncate($text, $chars = 25) {
        if (strlen($text) <= $chars) {
            return $text;
        }
        $text = $text." ";
        $text = substr($text,0,$chars);
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."...";
        return $text;
    }
        // ERROR PRINTING FUNCTION 
    function error($text)    {
        return "<div class='text-danger'>$text</div>";
    }
        // INFO PRINTING FUNCTION 
    function info($text)
    {
        return "<div class='text-info'>$text</div>";
    }

    // SUCCESS PRINTING FUNCTION 
    function success($text) {
        return "<div class='text-success'>$text</div>";
    }

    // CHECK VALUE FUNCTION 

    function dbValCheck($val, $col, $table) {
        global $conn;
            $query = mysqli_query($conn, "SELECT * FROM $table WHERE $col='$val'");
            if (!$query) {
            return die("UNABLE TO FETCH QUERY ".mysqli_error($conn));

            }else{
            $numRow = mysqli_num_rows($query);
            if ($numRow > 0) {
                return true;
            }else{
                return false;
            }

        }

    }
    // BRANCH ID 
    function branchId(){
        global $conn;
        global $userid;
        $bQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$userid");
        if (!$bQuery) {
            die("UNABLE TO GET ITEMS ".mysqli_error($conn));
            exit();
        }
       return $branchId = mysqli_fetch_assoc($bQuery)['branch_id'];
    }

    function userFulName($uId){
        global $conn;
        $userNameQuery = mysqli_query($conn, "SELECT * FROM users WHERE id=$uId");

        if (!$userNameQuery) {
            return die("FAILED TO GET BRANCH");
          
        }else if(mysqli_num_rows($userNameQuery) > 0){
           return $uName = ucwords(mysqli_fetch_assoc($userNameQuery)['fullname']);
        }else{
            return "USER NOT FOUND";
        }
    }
