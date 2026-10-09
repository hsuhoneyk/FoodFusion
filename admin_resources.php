<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Access denied. Admin only.");
}

/* ADD RESOURCE */
if (isset($_POST['add_resource'])) {

    $resource_category = $_POST['resource_category'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $fileName = time() . "_" . basename($_FILES['resource_file']['name']);
    $tmpName = $_FILES['resource_file']['tmp_name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    move_uploaded_file($tmpName, "uploads/resources/" . $fileName);

    $sql = "INSERT INTO resources 
            (resource_category, title, description, file_name, file_type)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $resource_category, $title, $description, $fileName, $fileType);
    $stmt->execute();

    header("Location: admin_resources.php");
    exit();
}

$resources = $conn->query("SELECT * FROM resources ORDER BY id DESC");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Manage Resources | FoodFusion</title>
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">Food<span>Fusion</span>
        </a>
        <nav class="site-nav">
            <a href="admin_recipes.php">Recipes</a>
            <a href="admin_contact.php">Messages</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main class="page-shell">
        <div class="form-card">
            <div class="eyebrow">Admin library</div>
            <h2>Upload a resource</h2>

            <form method="POST" enctype="multipart/form-data">

                <select name="resource_category" required>
                    <option value="Culinary">Culinary Resources</option>
                    <option value="Educational">Educational Resources</option>
                </select>
                <br><br>

                <input type="text" name="title" placeholder="Resource Title" required>
                <br><br>

                <textarea name="description" placeholder="Description" required></textarea>
                <br><br>

                <input type="file" name="resource_file" required>
                <br><br>

                <button type="submit" name="add_resource">Upload Resource</button>

            </form>
        </div>
        <h2>Uploaded resources</h2>
        <div class="admin-list">

            <?php while ($row = $resources->fetch_assoc()): ?>

                <article class="admin-item">
                    <?php if (in_array($row['file_type'], ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                        <img src="uploads/resources/<?php echo htmlspecialchars($row['file_name']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <?php else: ?>
                        <div class="tag"><?php echo htmlspecialchars($row['file_type']); ?></div>
                    <?php endif; ?>
                    <div>
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>

                        <p>
                            <strong>Category:</strong>
                            <?php echo htmlspecialchars($row['resource_category']); ?>
                        </p>

                        <p><?php echo htmlspecialchars($row['description']); ?></p>

                        <p>
                            <strong>File:</strong>
                            <?php echo htmlspecialchars($row['file_name']); ?>
                        </p>

                    </div>
                    <div class="admin-actions">
                        <a class="action-link quiet" href="uploads/resources/<?php echo htmlspecialchars($row['file_name']); ?>" download>Download</a>
                        <a class="action-link quiet" href="edit_resource.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a class="action-link danger" href="delete_resource.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this resource?')">Delete</a>
                    </div>
                </article>

            <?php endwhile; ?>
        </div>
    </main>
</body>

</html>