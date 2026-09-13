<?php
include("config/db.php");

$success_message = "";
$error_message = "";

if (isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password)
            VALUES ('$full_name', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        $success_message = "Registration successful. You can log in now.";
    } else {
        $error_message = "Registration failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <main class="auth-shell">
        <section class="hero-panel auth-side">
            <span class="eyebrow">New account</span>
            <h1 class="page-title">Join the lost-and-found network for your school community.</h1>
            <p class="page-subtitle">Create an account to report items, track claims, and help missing belongings find their way home faster.</p>
            <div class="hero-metrics">
                <div class="metric-card">
                    <span>Designed for speed</span>
                    <strong>Simple forms</strong>
                </div>
                <div class="metric-card">
                    <span>Trusted workflow</span>
                    <strong>Claim review</strong>
                </div>
            </div>
        </section>

        <section class="form-card auth-card">
            <span class="eyebrow">Get started</span>
            <h2 class="panel-title mt-3">Create your account</h2>
            <p class="panel-subtitle mb-4">A few details and you’re ready to start reporting or claiming items.</p>

            <?php if (!empty($success_message)) { ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php } ?>

            <?php if (!empty($error_message)) { ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php } ?>

            <form method="POST" class="stack">
                <div class="field">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Student or staff name" required>
                </div>

                <div class="field">
                    <label for="reg_email">Email</label>
                    <input type="email" id="reg_email" name="email" placeholder="you@school.edu" required>
                </div>

                <div class="field">
                    <label for="reg_password">Password</label>
                    <input type="password" id="reg_password" name="password" placeholder="Choose a secure password" required>
                </div>

                <button type="submit" name="register">Create Account</button>
            </form>

            <div class="action-row mt-4">
                <a href="login.php" class="center-link">Already have an account?</a>
            </div>
        </section>
    </main>
</body>
</html>
