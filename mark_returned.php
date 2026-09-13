<?php
session_start();
include("config/db.php");

/* 🔒 Check if user is logged in */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

/* 🔒 Check if user is admin */
$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"SELECT role FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

if($user['role'] != 'admin'){
    echo "Access denied.";
    exit();
}

/* ✅ Continue logic */
if(isset($_GET['id'])){
    $id = $_GET['id'];

    /* 🔍 Check current status */
    $check = mysqli_query($conn,"SELECT status FROM items WHERE id='$id'");
    $item = mysqli_fetch_assoc($check);

    if(!$item){
        echo "Item not found.";
        exit();
    }

    if($item['status'] == 'returned'){
        echo "Item is already marked as returned.";
        exit();
    }

    /* ✅ Update item status */
    $sql = "UPDATE items SET status='returned' WHERE id='$id'";

    if(mysqli_query($conn,$sql)){

        /* ✅ Audit Log (AFTER success) */
        $admin_id = $_SESSION['user_id'];

        $log = mysqli_query($conn,"
        INSERT INTO logs (user_id, action, item_id)
        VALUES ('$admin_id', 'Marked as Returned', '$id')
        ");

        if(!$log){
            echo "Log error: " . mysqli_error($conn);
            exit();
        }

        /* 📧 OPTIONAL: Email user */
        $getUser = mysqli_query($conn,"
            SELECT users.email 
            FROM items 
            JOIN users ON items.reported_by = users.id 
            WHERE items.id='$id'
        ");

        $userData = mysqli_fetch_assoc($getUser);

        if($userData && !empty($userData['email'])){
            $email = $userData['email'];

            // (May not work locally)
            @mail($email, "Item Returned", "Good news! Your lost item has been returned.");
        }

        header("Location: browse.php");
        exit();

    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>