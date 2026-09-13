<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);
$role = $user['role'];

$search = isset($_GET['search']) ? $_GET['search'] : "";
$status_filter = isset($_GET['status']) ? $_GET['status'] : "";
$location = isset($_GET['location']) ? $_GET['location'] : "";
$date = isset($_GET['date']) ? $_GET['date'] : "";

$sql = "SELECT * FROM items WHERE 1";

if (!empty($search)) {
    $sql .= " AND (item_name LIKE '%$search%' OR category LIKE '%$search%')";
}

if (!empty($status_filter)) {
    $sql .= " AND status='$status_filter'";
}

if (!empty($location)) {
    $sql .= " AND location LIKE '%$location%'";
}

if (!empty($date)) {
    $sql .= " AND DATE(created_at) = '$date'";
}

$sql .= " ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

function badge_class($status)
{
    if ($status === 'lost') {
        return 'status-badge status-lost';
    }
    if ($status === 'found') {
        return 'status-badge status-found';
    }
    if ($status === 'returned') {
        return 'status-badge status-returned';
    }
    if ($status === 'claimed') {
        return 'status-badge status-claimed';
    }
    return 'status-badge status-pending';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Items</title>
    <script src="js/qrcode.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-shell">
                <div class="container-fluid px-0">
                    <a class="navbar-brand brand-mark" href="dashboard.php">Campus<span>Collect</span></a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#browseNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="browseNav">
                        <div class="nav-actions">
                            <a href="dashboard.php" class="nav-pill">Dashboard</a>
                            <a href="browse.php" class="nav-pill active">Browse</a>
                            <a href="report_item.php" class="nav-pill accent">Report Item</a>
                            <a href="logout.php" class="nav-pill danger">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="page-shell stack">
        <section class="hero-panel">
            <div class="page-header">
                <div>
                    <span class="eyebrow">Browse</span>
                    <h1 class="page-title">Lost and found items</h1>
                    <p class="page-subtitle">Search by item, category, location, date, or status to narrow the list quickly.</p>
                </div>
                <a href="report_item.php" class="btn-primary-solid">Report New Item</a>
            </div>

            <form method="GET" class="filter-bar">
                <input type="text" name="search" placeholder="Search item or category" value="<?php echo htmlspecialchars($search); ?>">
                <select name="status">
                    <option value="">All Status</option>
                    <option value="lost" <?php if ($status_filter == "lost") echo "selected"; ?>>Lost</option>
                    <option value="found" <?php if ($status_filter == "found") echo "selected"; ?>>Found</option>
                    <option value="returned" <?php if ($status_filter == "returned") echo "selected"; ?>>Returned</option>
                    <option value="claimed" <?php if ($status_filter == "claimed") echo "selected"; ?>>Claimed</option>
                </select>
                <input type="text" name="location" placeholder="Location" value="<?php echo htmlspecialchars($location); ?>">
                <input type="date" name="date" value="<?php echo htmlspecialchars($date); ?>">
                <button type="submit">Filter</button>
                <a href="browse.php" class="btn-ghost-soft text-center">Reset</a>
            </form>
        </section>

        <section class="table-shell">
            <div class="table-header">
                <div>
                    <h2 class="panel-title">Reported items</h2>
                    <p class="panel-subtitle">All items are sorted by most recent report.</p>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                            <?php if ($role == 'admin') { ?>
                                <th>QR Code</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <?php
                            $item_id = $row['id'];
                            $claim_check = mysqli_query($conn, "SELECT * FROM claims WHERE item_id='$item_id' AND status='approved'");
                            $claimed = mysqli_num_rows($claim_check);
                            ?>
                            <tr>
                                <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['item_name']); ?>" class="thumb"></td>
                                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><span class="<?php echo badge_class($row['status']); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td>
                                    <?php if ($row['reported_by'] == $user_id) { ?>
                                        <span class="muted">Your item</span>
                                    <?php } elseif ($claimed == 0 && $row['status'] != 'returned') { ?>
                                        <a href="claim_item.php?id=<?php echo $row['id']; ?>" class="table-action">Claim Item</a>
                                    <?php } else { ?>
                                        <span class="status-badge status-approved">Already Claimed</span>
                                    <?php } ?>

                                    <?php if ($role == 'admin') { ?>
                                        <?php if ($row['status'] != 'returned') { ?>
                                            <a href="mark_returned.php?id=<?php echo $row['id']; ?>" class="table-action success">Mark Returned</a>
                                        <?php } ?>
                                        <a href="delete_item.php?id=<?php echo $row['id']; ?>" class="table-action danger">Delete</a>
                                    <?php } ?>
                                </td>
                                <?php if ($role == 'admin') { ?>
                                    <td>
                                        <div class="qr-box">
                                            <div id="qrcode_<?php echo $row['id']; ?>"></div>
                                        </div>
                                        <script>
                                        new QRCode(document.getElementById("qrcode_<?php echo $row['id']; ?>"), {
                                            text: "http://localhost/school-lost-found/verify_item.php?id=<?php echo $row['id']; ?>",
                                            width: 80,
                                            height: 80
                                        });
                                        </script>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
