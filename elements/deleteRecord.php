<?php
 require './db_connector.php';

    // To delete record
    // was getting data from url - get method but now using ajax wooohooo
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $id = $_POST['studentId'];
        $delete_std = "DELETE FROM `students` WHERE `students`.`id`='$id';";
        $delete_std_res = mysqli_query($conn, $delete_std);
        if ($delete_std_res) {
            echo "1";
        }
        else{
            echo "0";
        }
        mysqli_close($conn);
    }
    else{
        echo "0";
        mysqli_close($conn);
    }


?>