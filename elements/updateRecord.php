<?php
require './db_connector.php'; 
$std_exists = false;

if ($_SERVER['REQUEST_METHOD']=='POST') {
    // For Updating Student
    $id = $_POST['id'];
    $name = ucwords($_POST['name']);
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $subject = ucwords($_POST['subject']);

    $check_exists_sql = "SELECT * FROM `students` WHERE `phone`='$phone';";
    $check_exists_res = mysqli_query($conn, $check_exists_sql);

    if ( mysqli_num_rows($check_exists_res)> 2) {
        $std_exists = true;
    }
    else {
        $std_exists = false;
    }

    if ($std_exists == false)
    {
        $update_std = "UPDATE `students` SET `name`='$name', `age`='$age', `phone`='$phone', `subject`='$subject' WHERE `students`.`id`='$id'"; 
        $update_std_res = mysqli_query($conn, $update_std);
        echo "1";
        mysqli_close($conn);
    }
    else {
        echo "0";
        mysqli_close($conn);
    }
}
else{
    echo "<script>console.log('No Post bro');</script>";
}

?>