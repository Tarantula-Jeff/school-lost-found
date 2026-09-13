<?php
include("config/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Lost &amp; Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="config/assets/style.css">
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-shell">
                <div class="container-fluid px-0">
                    <a class="navbar-brand brand-mark" href="index.php">Campus<span>Collect</span></a>
                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="topNav">
                        <div class="nav-actions">
                            <a href="browse.php" class="nav-pill">Browse Items</a>
                            <a href="login.php" class="nav-pill">Login</a>
                            <a href="register.php" class="nav-pill accent">Create Account</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="page-shell">
        <section class="hero-panel">
            <div class="hero-grid">
                <div>
                    <span class="eyebrow">School-wide recovery hub</span>
                    <h1 class="hero-title">A cleaner, faster way to reunite students with their things.</h1>
                    <p class="hero-copy">
                        Turn your lost-and-found process into a calm, modern experience. Report items quickly, browse recent discoveries, and track claims in one polished campus dashboard.
                    </p>
                    <div class="hero-actions">
                        <a href="register.php" class="btn-primary-solid">Start Reporting Items</a>
                        <a href="browse.php" class="btn-secondary-soft">Explore Lost &amp; Found</a>
                    </div>
                </div>

                <div class="hero-metrics">
                    <div class="metric-card">
                        <span>Fast item reporting</span>
                        <strong>1 place</strong>
                        <p class="meta-text">Submit lost or found items with location, category, image, and status.</p>
                    </div>
                    <div class="metric-card">
                        <span>Safer claims</span>
                        <strong>Proof-first</strong>
                        <p class="meta-text">Claim flows support descriptions, security questions, and supporting files.</p>
                    </div>
                    <div class="metric-card">
                        <span>Admin visibility</span>
                        <strong>Review-ready</strong>
                        <p class="meta-text">Track requests, approve legitimate claims, and close the loop on returns.</p>
                    </div>
                    <div class="metric-card">
                        <span>Simple for students</span>
                        <strong>Clear actions</strong>
                        <p class="meta-text">Designed so the next step is obvious whether you lost, found, or manage items.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="stack" style="margin-top: 28px;">
            <div class="page-header compact">
                <div>
                    <h2 class="page-title">Built for daily campus traffic</h2>
                    <p class="page-subtitle">The core flows are simple, quick to scan, and easy to use on both desktop and mobile.</p>
                </div>
            </div>

            <div class="feature-grid">
                <article class="feature-card">
                    <h3 class="panel-title">Report in minutes</h3>
                    <p>Add a photo, category, location, and status without wading through cluttered forms.</p>
                </article>
                <article class="feature-card">
                    <h3 class="panel-title">Browse with filters</h3>
                    <p>Search by item name, category, location, date, and status to narrow results quickly.</p>
                </article>
                <article class="feature-card">
                    <h3 class="panel-title">Manage confidently</h3>
                    <p>Admins can review claims, mark returns, and keep the system clean without jumping between screens.</p>
                </article>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
