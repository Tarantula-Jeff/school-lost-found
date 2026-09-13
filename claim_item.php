<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$item_id = $_GET['id'];
$success_message = "";
$error_message = "";

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $proof_text = $_POST['proof_text'];
    $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];
    $proof_file_name = "";

    if (!empty($_FILES['proof_file']['name'])) {
        $proof_file_name = $_FILES['proof_file']['name'];
        $tmp = $_FILES['proof_file']['tmp_name'];

        $fileType = mime_content_type($tmp);

        if (strpos($fileType, 'image') === false && $fileType != 'application/pdf') {
            $error_message = "Only images or PDFs are allowed.";
        } else {
            move_uploaded_file($tmp, "proofs/" . $proof_file_name);
        }
    }

    if (empty($error_message)) {
        $sql = "INSERT INTO claims 
        (item_id,user_id,proof,security_question,security_answer,proof_file,status)
        VALUES 
        ('$item_id','$user_id','$proof_text','$security_question','$security_answer','$proof_file_name','pending')";

        mysqli_query($conn, "
        INSERT INTO logs (user_id, action, item_id)
        VALUES ('$user_id', 'Submitted Claim', '$item_id')
        ");

        if (mysqli_query($conn, $sql)) {
            $success_message = "Claim request submitted successfully.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-shell">
                <div class="container-fluid px-0">
                    <a class="navbar-brand brand-mark" href="dashboard.php">Campus<span>Collect</span></a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#claimNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="claimNav">
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

    <main class="page-shell">
        <section class="form-card">
            <div class="page-header">
                <div>
                    <span class="eyebrow">Claim Flow</span>
                    <h1 class="page-title">Claim this item</h1>
                    <p class="page-subtitle">Give enough detail to prove ownership and help admins approve the right request confidently.</p>
                </div>
                <a href="browse.php" class="btn-ghost-soft">Back to Browse</a>
            </div>

            <?php if (!empty($success_message)) { ?>
                <div class="alert alert-success">
                    <?php echo $success_message; ?>
                    <div class="mt-2"><a href="browse.php" class="center-link">Return to items</a></div>
                </div>
            <?php } ?>

            <?php if (!empty($error_message)) { ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php } ?>

            <form method="POST" enctype="multipart/form-data" class="stack">
                <div class="field">
                    <label for="proof_text">Describe the item</label>
                    <textarea id="proof_text" name="proof_text" required placeholder="Example: Black backpack with my name stitched inside and a calculator in the front pocket."></textarea>
                </div>

                <div class="field-grid">
                    <div class="field">
                        <label for="security_question">Security Question</label>
                        <input type="text" id="security_question" name="security_question" required placeholder="What detail only the owner would know?">
                    </div>

                    <div class="field">
                        <label for="security_answer">Security Answer</label>
                        <input type="text" id="security_answer" name="security_answer" required placeholder="Provide the answer clearly">
                    </div>
                </div>

                <div class="field">
                    <label for="proof_file">Upload Optional Proof</label>
                    <input type="file" id="proof_file" name="proof_file" accept="image/*,application/pdf">
                    <p class="mini-note mb-0">Accepted formats: image files and PDF documents.</p>
                </div>

                <div class="action-row">
                    <button type="submit" name="submit">Submit Claim</button>
                    <a href="browse.php" class="btn-ghost-soft">Cancel</a>
                </div>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
