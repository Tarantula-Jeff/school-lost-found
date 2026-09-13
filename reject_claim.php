<?php
include("config/db.php");

$id = $_GET['id'];

mysqli_query($conn,"UPDATE claims SET status='rejected' WHERE id='$id'");

header("Location: admin_claims.php");
?>