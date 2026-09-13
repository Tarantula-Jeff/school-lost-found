<?php
session_start();
include("config/db.php");

/* 🔒 Check login */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

/* 🔒 Check if admin */
$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"SELECT role FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

if($user['role'] != 'admin'){
    echo "Access denied. Admins only.";
    exit();
}

$id = $_GET['id'];

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Only log once per load
    mysqli_query($conn,"
    INSERT INTO logs (user_id, action, item_id)
    VALUES ('$admin_id', 'Scanned QR Code', '$id')
    ");
}

$result = mysqli_query($conn,"SELECT * FROM items WHERE id='$id'");
$item = mysqli_fetch_assoc($result);

if(!$item){
    echo "Invalid QR Code.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify Item</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body style="text-align:center; font-family:Arial;">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">

    <a class="navbar-brand" href="#">Lost & Found</a>

    <div class="ms-auto">

      <a href="dashboard.php" class="btn btn-light btn-sm me-2">Dashboard</a>

      <a href="browse.php" class="btn btn-primary btn-sm me-2">Browse</a>

      <a href="report_item.php" class="btn btn-success btn-sm me-2">Report Item</a>

      <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>

    </div>

  </div>
</nav>


<h2>Item Verification</h2>

<p><strong>Item:</strong> <?php echo $item['item_name']; ?></p>
<p><strong>Status:</strong> <?php echo $item['status']; ?></p>

<?php if($item['status'] != 'returned'){ ?>

<a href="mark_returned.php?id=<?php echo $item['id']; ?>">
<button style="padding:10px 20px;background:green;color:white;border:none;">
Mark as Collected
</button>
</a>

<?php } else { ?>

<p style="color:green;font-weight:bold;">Already Collected</p>

<?php } ?>

</body>
</html>