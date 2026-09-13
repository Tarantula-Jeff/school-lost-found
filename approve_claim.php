<?php
session_start();
include("config/db.php");

$id = $_GET['id'];

/* get claim info */
$query = mysqli_query($conn,"
SELECT claims.*, users.email, items.item_name
FROM claims
JOIN users ON claims.user_id = users.id
JOIN items ON claims.item_id = items.id
WHERE claims.id='$id'
");

$data = mysqli_fetch_assoc($query);

$email = $data['email'];
$item_name = $data['item_name'];
$item_id = $data['item_id'];


// check if already approved 
if($data['status'] == 'approved'){
    header("Location: admin_claims.php");
    exit();
}

// check if item already claimed (excluding this claim)
$checkItem = mysqli_query($conn,"
SELECT * FROM claims 
WHERE item_id='$item_id' 
AND status='approved' 
AND id != '$id'
");

if(mysqli_num_rows($checkItem) > 0){
    echo "This item has already been claimed.";
    exit();
}

/* update claim status */
mysqli_query($conn,"UPDATE claims SET status='approved' WHERE id='$id'");

/* 🔥 update item status */
mysqli_query($conn,"UPDATE items SET status='claimed' WHERE id='$item_id'");

$admin_id = $_SESSION['user_id'];

mysqli_query($conn,"
INSERT INTO logs (user_id, action, item_id)
VALUES ('$admin_id', 'Approved Claim', '$item_id')
");

/* email notification */
$subject = "Lost & Found Claim Approved";
$message = "Good news! Your claim for the item '$item_name' has been approved. Please visit the school office to collect it.";
$headers = "From: school@lostfound.com";

mail($email,$subject,$message,$headers);

header("Location: admin_claims.php");
?>