<?php
 require './db_connector.php';

    $id = $_GET['id'];
    $name = $_GET['name'];
        $delete_std = "DELETE FROM `students` WHERE `students`.`id`='$id';";
        $delete_std_res = mysqli_query($conn, $delete_std);
        if ($delete_std_res) {
            header("Location: http://localhost/crud-php-recruitnx-demo/index.php");
        }


?>