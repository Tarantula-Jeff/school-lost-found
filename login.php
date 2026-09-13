<?php
session_start();
include("config/db.php");

$error_message = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Wrong password. Please try again.";
        }
    } else {
        $error_message = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <main class="auth-shell">
        <section class="hero-panel auth-side">
            <span class="eyebrow">Welcome back</span>
            <h1 class="page-title">Pick up where your campus recovery flow left off.</h1>
            <p class="page-subtitle">Review reported items, submit claims, and keep track of activity from one calm dashboard.</p>
            <div class="auth-list">
                <div class="auth-list-item">
                    <strong>Quick browsing</strong>
                    <p class="mini-note mb-0">Search and filter recently reported items without digging through clutter.</p>
                </div>
                <div class="auth-list-item">
                    <strong>Proof-based claims</strong>
                    <p class="mini-note mb-0">Claim items with written details, security prompts, and optional file proof.</p>
                </div>
                <div class="auth-list-item">
                    <strong>Admin visibility</strong>
                    <p class="mini-note mb-0">Moderators can approve claims, mark returns, and audit activity.</p>
                </div>
            </div>
        </section>

        <section class="form-card auth-card">
            <span class="eyebrow">Account access</span>
            <h2 class="panel-title mt-3">Login to your account</h2>
            <p class="panel-subtitle mb-4">Use the email and password you registered with.</p>

            <?php if (!empty($error_message)) { ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php } ?>

            <form method="POST" class="stack">
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="you@school.edu" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" name="login">Login</button>
            </form>

            <div class="action-row mt-4">
                <a href="register.php" class="center-link">Create a new account</a>
                <a href="browse.php" class="center-link">Browse items first</a>
            </div>
        </section>
    </main>
</body>
</html>
