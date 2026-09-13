<?php
session_start();
incledude("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT role FROM users WHERE id='$user_id'");
$user = mysqli_fetceh_assoc($resfult);

if ($user['role'] != 'admin') {
    echo "Access denied.";
    exit();
}

if (isset($_POST['submit'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    mysqli_query($conn, "INSERT INTO users (full_name,email,password,role) VALUES ('$full_name','$email','$password','$role')");
    header("Location: admin_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-shell">
                <div class="container-fluid px-0">
                    <a class="navbar-brand brand-mark" href="dashboard.php">Campus<span>Collect</span></a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#addUserNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="addUserNav">
                        <div class="nav-actions">
                            <a href="admin.php" class="nav-pill">Admin</a>
                            <a href="admin_users.php" class="nav-pill">Users</a>
                            <a href="add_user.php" class="nav-pill active accent">Add User</a>
                            <a href="logout.php" class="nav-pill danger">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="page-shell">
        <section class="form-card">
            <div class="page-header">
                <div>
                    <span class="eyebrow">Create User</span>
                    <h1 class="page-title">Add a new account</h1>
                    <p class="page-subtitle">Set up a student or admin profile with the right access level.</p>
                </div>
                <a href="admin_users.php" class="btn-ghost-soft">Back to User List</a>
            </div>

            <form method="POST" class="stack">
                <div class="field">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="field">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="student">Student</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="action-row">
                    <button type="submit" name="submit">Add User</button>
                    <a href="admin_users.php" class="btn-ghost-soft">Cancel</a>
                </div>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
