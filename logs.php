<?php
session_start();
include("config/db.php");

$user_id = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($res);

if ($user['role'] != 'admin') {
    echo "Access denied.";
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : "";
$action_filter = isset($_GET['action']) ? $_GET['action'] : "";

$sql = "
SELECT logs.*, users.full_name, items.item_name
FROM logs
JOIN users ON logs.user_id = users.id
LEFT JOIN items ON logs.item_id = items.id
WHERE 1
";

if (!empty($search)) {
    $sql .= " AND (
        users.full_name LIKE '%$search%' 
        OR logs.action LIKE '%$search%' 
        OR items.item_name LIKE '%$search%'
    )";
}

if (!empty($action_filter)) {
    $sql .= " AND logs.action = '$action_filter'";
}

$sql .= " ORDER BY logs.created_at DESC";
$logs = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-shell">
                <div class="container-fluid px-0">
                    <a class="navbar-brand brand-mark" href="dashboard.php">Campus<span>Collect</span></a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#logsNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="logsNav">
                        <div class="nav-actions">
                            <a href="dashboard.php" class="nav-pill">Dashboard</a>
                            <a href="admin.php" class="nav-pill">Admin</a>
                            <a href="logs.php" class="nav-pill active">Logs</a>
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
                    <span class="eyebrow">Audit Logs</span>
                    <h1 class="page-title">Track system activity and moderation history.</h1>
                    <p class="page-subtitle">Search by user, action, or item and filter down to the specific events you need to inspect.</p>
                </div>
                <a href="admin.php" class="btn-ghost-soft">Back to Admin</a>
            </div>

            <form method="GET" class="filter-bar">
                <input type="text" name="search" placeholder="Search user, action, or item" value="<?php echo htmlspecialchars($search); ?>">
                <select name="action">
                    <option value="">All Actions</option>
                    <option value="Reported Item" <?php if ($action_filter == 'Reported Item') echo 'selected'; ?>>Reported Item</option>
                    <option value="Submitted Claim" <?php if ($action_filter == 'Submitted Claim') echo 'selected'; ?>>Submitted Claim</option>
                    <option value="Approved Claim" <?php if ($action_filter == 'Approved Claim') echo 'selected'; ?>>Approved Claim</option>
                    <option value="Deleted Item" <?php if ($action_filter == 'Deleted Item') echo 'selected'; ?>>Deleted Item</option>
                    <option value="Marked as Returned" <?php if ($action_filter == 'Marked as Returned') echo 'selected'; ?>>Marked as Returned</option>
                    <option value="User Logged In" <?php if ($action_filter == 'User Logged In') echo 'selected'; ?>>User Logged In</option>
                    <option value="User Logged Out" <?php if ($action_filter == 'User Logged Out') echo 'selected'; ?>>User Logged Out</option>
                </select>
                <div></div>
                <div></div>
                <button type="submit">Filter</button>
                <a href="logs.php" class="btn-ghost-soft text-center">Reset</a>
            </form>
        </section>

        <section class="table-shell">
            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Item</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($logs)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['action']); ?></td>
                                <td><?php echo $row['item_name'] ? htmlspecialchars($row['item_name']) : '-'; ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
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
