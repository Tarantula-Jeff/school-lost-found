<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$total_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM items"))['total'];
$lost_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM items WHERE status='lost'"))['total'];
$found_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM items WHERE status='found'"))['total'];
$returned_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM items WHERE status='returned'"))['total'];
$total_claims = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM claims"))['total'];

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);
$role = $user['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-shell">
                <div class="container-fluid px-0">
                    <a class="navbar-brand brand-mark" href="dashboard.php">Campus<span>Collect</span></a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#dashNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="dashNav">
                        <div class="nav-actions">
                            <a href="dashboard.php" class="nav-pill active">Dashboard</a>
                            <a href="browse.php" class="nav-pill">Browse</a>
                            <a href="report_item.php" class="nav-pill accent">Report Item</a>
                            <a href="logout.php" class="nav-pill danger">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="page-shell">
        <section class="hero-panel">
            <div class="split-layout">
                <div>
                    <span class="eyebrow">Dashboard</span>
                    <h1 class="page-title">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>.</h1>
                    <p class="page-subtitle">Everything you need is in one place: report, search, claim, and manage the lifecycle of lost items across campus.</p>
                    <div class="quick-actions mt-4">
                        <a href="report_item.php" class="btn-primary-solid">Report Lost or Found Item</a>
                        <a href="browse.php" class="btn-secondary-soft">Browse Items</a>
                        <?php if ($role == 'admin') { ?>
                            <a href="admin.php" class="btn-ghost-soft">Open Admin Panel</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="panel">
                    <h2 class="panel-title">Quick Links</h2>
                    <p class="panel-subtitle">Jump into the parts of the app you use most.</p>
                    <div class="stack mt-4">
                        <a href="browse.php" class="table-action">Browse all items</a>
                        <a href="report_item.php" class="table-action success">Submit a report</a>
                        <?php if ($role == 'admin') { ?>
                            <a href="admin_claims.php" class="table-action">Review claim requests</a>
                            <a href="admin_users.php" class="table-action">Manage users</a>
                            <a href="logs.php" class="table-action">View audit logs</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="stack" style="margin-top: 28px;">
            <div class="page-header compact">
                <div>
                    <h2 class="panel-title">System Statistics</h2>
                    <p class="panel-subtitle">A quick pulse on current item activity and claim volume.</p>
                </div>
            </div>

            <div class="stat-grid">
                <article class="stat-card">
                    <span>Total Items</span>
                    <strong><?php echo $total_items; ?></strong>
                </article>
                <article class="stat-card">
                    <span>Lost Items</span>
                    <strong><?php echo $lost_items; ?></strong>
                </article>
                <article class="stat-card">
                    <span>Found Items</span>
                    <strong><?php echo $found_items; ?></strong>
                </article>
                <article class="stat-card">
                    <span>Returned Items</span>
                    <strong><?php echo $returned_items; ?></strong>
                </article>
                <article class="stat-card">
                    <span>Total Claims</span>
                    <strong><?php echo $total_claims; ?></strong>
                </article>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
