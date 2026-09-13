<?php

$host = "localhost";
$user = "root";
$password = "1111";  // default is empty for local MySQL
$database = "school_lost_found";

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>


