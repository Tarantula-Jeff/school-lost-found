<?php
session_start();
include("config/db.php");

$result = mysqli_query($conn, "
SELECT claims.*, items.item_name
FROM claims
JOIN items ON claims.item_id = items.id
ORDER BY claims.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-shell">
                <div class="container-fluid px-0">
                    <a class="navbar-brand brand-mark" href="dashboard.php">Campus<span>Collect</span></a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#claimsNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="claimsNav">
                        <div class="nav-actions">
                            <a href="dashboard.php" class="nav-pill">Dashboard</a>
                            <a href="admin.php" class="nav-pill">Admin</a>
                            <a href="admin_claims.php" class="nav-pill active">Claims</a>
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
                    <span class="eyebrow">Claim Requests</span>
                    <h1 class="page-title">Review ownership claims with less friction.</h1>
                    <p class="page-subtitle">Everything needed for approval is in one clean table, including proof text, security details, and attached files.</p>
                </div>
                <a href="admin.php" class="btn-ghost-soft">Back to Admin Panel</a>
            </div>
        </section>

        <section class="table-shell">
            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>User ID</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Security Question</th>
                            <th>Answer</th>
                            <th>Proof File</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['item_id']; ?></td>
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['proof']); ?></td>
                                <td><?php echo htmlspecialchars($row['security_question']); ?></td>
                                <td><?php echo htmlspecialchars($row['security_answer']); ?></td>
                                <td>
                                    <?php if (!empty($row['proof_file'])) { ?>
                                        <a href="proofs/<?php echo htmlspecialchars($row['proof_file']); ?>" target="_blank" class="table-action">View File</a>
                                    <?php } else { ?>
                                        <span class="muted">No File</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <span class="<?php echo $row['status'] == 'pending' ? 'status-badge status-pending' : ($row['status'] == 'approved' ? 'status-badge status-approved' : 'status-badge status-claimed'); ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'pending') { ?>
                                        <a href="approve_claim.php?id=<?php echo $row['id']; ?>" class="table-action success">Approve</a>
                                        <a href="reject_claim.php?id=<?php echo $row['id']; ?>" class="table-action danger">Reject</a>
                                    <?php } else { ?>
                                        <span class="muted">Done</span>
                                    <?php } ?>
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
