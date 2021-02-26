<?php 
    include('./conn.php');
    function checkForm ($data)
    {
        global $conn;
        return strtolower(trim(mysqli_escape_string($conn, $data)));
    }
    function checkPass ($data)
    {
        global $conn;
        return mysqli_escape_string($conn, $data);
    }

// ERROR PRINTING FUNCTION 
    function error($text)
    {
        return "<div class='text-danger'>$text</div>";
    }

    // INFO PRINTING FUNCTION 
    function info($text)
    {
        return "<div class='text-info'>$text</div>";
    }

    // SUCCESS PRINTING FUNCTION 
    function success($text)
    {
        return "<div class='text-success'>$text</div>";
    }

    function white($text)
    {
        return "<div class='text-white'>$text</div>";
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