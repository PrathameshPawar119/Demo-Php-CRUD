<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_demo";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    echo("Error". mysqli_connect_error());
    exit();
}

?>