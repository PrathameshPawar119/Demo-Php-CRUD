<?php
    require "./db_connector.php";
    $std_exists = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // For adding new Student
        $name = ucwords($_POST['name']);
        $age = $_POST['age'];
        $phone = $_POST['phone'];
        $subject = ucwords($_POST['subject']);

        $check_exists_sql = "SELECT * FROM `students` WHERE `phone`='$phone';";
        $check_exists_res = mysqli_query($conn, $check_exists_sql);
        $total_existing_std = mysqli_num_rows($check_exists_res);
        if ($total_existing_std == 1) {
            $std_exists = true;
        }
        else {
            $std_exists = false;
        }

        // student with same mobile number -->show alert
        if ($std_exists == false)
         {
            $insert_std_sql = "INSERT INTO `students` (`id`, `name`, `age`, `phone`, `subject`) VALUES (NULL, '$name', '$age', '$phone', '$subject');";
            $insert_std_result = mysqli_query($conn, $insert_std_sql);
            $addRecordResult = 1;

        }
        else {
            $addRecordResult = 0;
        }
    
    }

    mysqli_close($conn);
    echo $addRecordResult;

?>