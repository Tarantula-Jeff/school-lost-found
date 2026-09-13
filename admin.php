<?php
session_start();
include("config/db.php");

$total_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM items"))['total'];
$lost_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM items WHERE status='lost'"))['total'];
$found_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM items WHERE status='found'"))['total'];
$returned_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM items WHERE status='returned'"))['total'];
$total_claims = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM claims"))['total'];

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT role FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($user['role'] != 'admin') {
    echo "Access denied.";
    exit();
}

$items = mysqli_query($conn, "SELECT * FROM items ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-shell">
                <div class="container-fluid px-0">
                    <a class="navbar-brand brand-mark" href="dashboard.php">Campus<span>Collect</span></a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="adminNav">
                        <div class="nav-actions">
                            <a href="dashboard.php" class="nav-pill">Dashboard</a>
                            <a href="admin.php" class="nav-pill active">Admin</a>
                            <a href="admin_claims.php" class="nav-pill">Claims</a>
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
                    <span class="eyebrow">Admin Control</span>
                    <h1 class="page-title">Manage item activity with a cleaner review workflow.</h1>
                    <p class="page-subtitle">See current inventory, inspect report volume, and move directly into approvals or cleanup actions.</p>
                </div>
                <div class="quick-actions">
                    <a href="admin_claims.php" class="btn-primary-solid">View Claim Requests</a>
                    <a href="dashboard.php" class="btn-ghost-soft">Back to Dashboard</a>
                </div>
            </div>

            <div class="stat-grid">
                <article class="stat-card"><span>Total Items</span><strong><?php echo $total_items; ?></strong></article>
                <article class="stat-card"><span>Lost</span><strong><?php echo $lost_items; ?></strong></article>
                <article class="stat-card"><span>Found</span><strong><?php echo $found_items; ?></strong></article>
                <article class="stat-card"><span>Returned</span><strong><?php echo $returned_items; ?></strong></article>
                <article class="stat-card"><span>Claims</span><strong><?php echo $total_claims; ?></strong></article>
            </div>
        </section>

        <section class="table-shell">
            <div class="table-header">
                <div>
                    <h2 class="panel-title">Recent items</h2>
                    <p class="panel-subtitle">Review the latest reported items and take action where needed.</p>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th>Reported By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($items)) { ?>
                            <tr>
                                <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['item_name']); ?>" class="thumb"></td>
                                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                <td><span class="<?php echo $row['status'] == 'returned' ? 'status-badge status-returned' : ($row['status'] == 'found' ? 'status-badge status-found' : ($row['status'] == 'lost' ? 'status-badge status-lost' : 'status-badge status-claimed')); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['reported_by']); ?></td>
                                <td>
                                    <a href="mark_returned.php?id=<?php echo $row['id']; ?>" class="table-action success">Mark Returned</a>
                                    <a href="delete_item.php?id=<?php echo $row['id']; ?>" class="table-action danger">Delete</a>
                                </td>
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
