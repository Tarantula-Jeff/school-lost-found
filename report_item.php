<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$success_message = "";
$error_message = "";

if (isset($_POST['submit'])) {
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $reported_by = $_SESSION['user_id'];

    $image_name = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];

    $fileType = mime_content_type($temp_name);
    if (strpos($fileType, 'image') === false) {
        $error_message = "Only image files are allowed.";
    } else {
        move_uploaded_file($temp_name, "uploads/" . $image_name);

        $sql = "INSERT INTO items (item_name, description, category, location, status, reported_by, image)
            VALUES ('$item_name','$description','$category','$location','$status','$reported_by','$image_name')";

        if (mysqli_query($conn, $sql)) {
            $item_id = mysqli_insert_id($conn);
            $user_id = $_SESSION['user_id'];

            mysqli_query($conn, "
            INSERT INTO logs (user_id, action, item_id)
            VALUES ('$user_id', 'Reported Item', '$item_id')
            ");

            $success_message = "Item reported successfully.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-shell">
                <div class="container-fluid px-0">
                    <a class="navbar-brand brand-mark" href="dashboard.php">Campus<span>Collect</span></a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#reportNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="reportNav">
                        <div class="nav-actions">
                            <a href="dashboard.php" class="nav-pill">Dashboard</a>
                            <a href="browse.php" class="nav-pill">Browse</a>
                            <a href="report_item.php" class="nav-pill active accent">Report Item</a>
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
                    <span class="eyebrow">Report</span>
                    <h1 class="page-title">Report a lost or found item</h1>
                    <p class="page-subtitle">Add clear details so the right owner can identify the item quickly and safely.</p>
                </div>
                <a href="dashboard.php" class="btn-ghost-soft">Back to Dashboard</a>
            </div>

            <?php if (!empty($success_message)) { ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php } ?>

            <?php if (!empty($error_message)) { ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php } ?>

            <form method="POST" enctype="multipart/form-data" class="stack">
                <div class="field-grid">
                    <div class="field">
                        <label for="item_name">Item Name</label>
                        <input type="text" id="item_name" name="item_name" placeholder="Black backpack" required>
                    </div>

                    <div class="field">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Bag">Bag</option>
                            <option value="Phone">Phone</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Books">Books</option>
                            <option value="Clothing">Clothing</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Color, brand, identifying marks, and any useful context"></textarea>
                </div>

                <div class="field-grid">
                    <div class="field">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" placeholder="Library, cafeteria, classroom, bus stop">
                    </div>

                    <div class="field">
                        <label for="status">Item Status</label>
                        <select id="status" name="status">
                            <option value="lost">Lost</option>
                            <option value="found">Found</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="fileElem">Upload Image</label>
                    <div id="drop-area" class="dropzone">
                        <p class="mb-2"><strong>Drag and drop an image here</strong></p>
                        <p class="mini-note mb-3">or choose a file manually</p>
                        <input type="file" name="image" id="fileElem" accept="image/*" required>
                    </div>
                </div>

                <p id="error" class="alert alert-error" style="display:none;"></p>
                <img id="preview" src="" alt="Image preview" class="preview-image" style="display:none;">

                <div class="action-row">
                    <button type="submit" name="submit">Submit Item Report</button>
                    <a href="browse.php" class="btn-ghost-soft">Browse Existing Items</a>
                </div>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const dropArea = document.getElementById("drop-area");
    const fileInput = document.getElementById("fileElem");
    const preview = document.getElementById("preview");
    const error = document.getElementById("error");

    ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
        dropArea.addEventListener(eventName, (event) => event.preventDefault());
    });

    dropArea.addEventListener("dragover", () => {
        dropArea.classList.add("dragover");
    });

    dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("dragover");
    });

    dropArea.addEventListener("drop", (event) => {
        dropArea.classList.remove("dragover");
        const file = event.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            handleFile(file);
        }
    });

    fileInput.addEventListener("change", () => {
        const file = fileInput.files[0];
        if (file) {
            handleFile(file);
        }
    });

    function handleFile(file) {
        error.style.display = "none";
        error.innerText = "";

        if (!file.type.startsWith("image/")) {
            error.innerText = "Only image files are allowed.";
            error.style.display = "block";
            preview.style.display = "none";
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
    </script>
</body>
</html>
