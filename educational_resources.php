<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$stmt = $conn->prepare("
    SELECT * FROM resources
    WHERE resource_category = 'Educational'
    ORDER BY id DESC
");
$stmt->execute();
$resources = $stmt->get_result();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Educational Resources | FoodFusion</title>
</head>

<body class="page-educational">
    <header class="site-header">
        <a class="brand" href="index.php">Food<span>Fusion</span></a>
        <nav class="site-nav">
            <a href="recipes.php">Recipes</a>
            <a href="community_cookbook.php">Community</a>
            <div class="dropdown-resources">
                <a href="culinary_resources.php">Resources ▾</a>
                <div class="dropdown-content-resource">
                    <a href="educational_resources.php">Educational</a>
                    <a href="culinary_resources.php">Culinary</a>
                </div>
            </div>
        </nav>
    </header>

    <section class="res-hero">
        <div class="container">
            <span class="res-eyebrow">Cook greener, learn more</span>
            <h1>Educational <span>resources</span></h1>
            <p>Downloadable guides, infographics and lessons on renewable energy and sustainable cooking — from solar cookers to energy-efficient kitchens.</p>
        </div>
    </section>

    <main class="page-shell">
        <div class="res-grid">
            <?php $hasResources = false;
            while ($row = $resources->fetch_assoc()): $hasResources = true; ?>
                <article class="res-card">

                    <?php if (in_array($row['file_type'], ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                        <div class="res-card__media">
                            <img src="uploads/resources/<?php echo htmlspecialchars($row['file_name']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            <span class="res-badge"><?php echo htmlspecialchars(strtoupper($row['file_type'])); ?></span>
                        </div>
                    <?php elseif ($row['file_type'] == 'mp4'): ?>
                        <div class="res-card__media res-card__media--video">
                            <video controls>
                                <source src="uploads/resources/<?php echo htmlspecialchars($row['file_name']); ?>" type="video/mp4">
                            </video>
                            <span class="res-badge">Video</span>
                        </div>
                    <?php else: ?>
                        <div class="res-card__media res-card__media--doc">
                            <span class="res-doc-icon"><?php echo htmlspecialchars(strtoupper($row['file_type'])); ?></span>
                            <span class="res-badge">Guide</span>
                        </div>
                    <?php endif; ?>

                    <div class="res-card__body">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <a class="res-download" href="uploads/resources/<?php echo htmlspecialchars($row['file_name']); ?>" download>Download resource ↓</a>
                    </div>
                </article>
            <?php endwhile;
            if (!$hasResources): ?>
                <div class="empty-state">New learning resources will appear here soon.</div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>
