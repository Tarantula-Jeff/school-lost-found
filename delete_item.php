<?php
session_start();
include("config/db.php");

/* 🔒 Check if user is admin */
$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"SELECT role FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

if($user['role'] != 'admin'){
    echo "Access denied.";
    exit();
}

/* ✅ Continue with delete logic */
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Delete image file
    $sql_select = "SELECT image FROM items WHERE id='$id'";
    $res = mysqli_query($conn,$sql_select);
    $row = mysqli_fetch_assoc($res);

    if($row && $row['image'] != ""){
        @unlink("uploads/".$row['image']);
    }

// Delete database record 
$sql = "DELETE FROM items WHERE id='$id'";
if(mysqli_query($conn, $sql)){

    //  Audit log
    $admin_id = $_SESSION['user_id'];
    mysqli_query($conn, "
        INSERT INTO logs (user_id, action, item_id)
        VALUES ('$admin_id', 'Deleted Item', '$id')
    ");

    // Redirect after logging
    header("Location: browse.php");
    exit();

} else {
    echo "Error: " . mysqli_error($conn);
}
}
?>