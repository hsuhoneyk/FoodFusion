<?php
session_start();
include "db.php";

/* Only logged-in users can access My Wall */
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ADD POST */
if (isset($_POST['submit_post'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $imageName = "";

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $tmpName = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmpName, "uploads/" . $imageName);
    }

    $sql = "INSERT INTO community_posts 
            (user_id, title, content, image)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $title, $content, $imageName);
    $stmt->execute();

    header("Location: my_wall.php");
    exit();
}

/* GET ONLY MY POSTS */
$stmt = $conn->prepare("
    SELECT *
    FROM community_posts
    WHERE user_id = ?
    ORDER BY id DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$posts = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>My Wall | FoodFusion</title>
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">Food<span>Fusion</span></a>
        <nav class="site-nav">
        
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'member'): ?>
                <a href="community_cookbook.php">Community</a>
                <a class="active" href="my_wall.php">My Wall</a>
                <div class="dropdown-resources">
                <a href="culinary_resources.php">Resources ▾</a>
                <div class="dropdown-content-resource">
                    <a href="educational_resources.php">Educational</a>
                    <a href="culinary_resources.php">Culinary</a>
                </div>
            </div>

            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="community_cookbook.php">Community</a>
                <a class="active" href="my_wall.php">My Wall</a>
                <div class="dropdown-resources">
                <a href="admin_resources.php">Resources ▾</a>
                <div class="dropdown-content-resource">
                    <a href="admin_resources.php">Resources</a>
                    <a href="admin_recipes.php">Recipes</a>
                </div>
            </div>
            <?php endif; ?>

        </nav>
    </header>
    <section class="page-hero">
        <div class="container">
            <div class="eyebrow">Your food journal</div>
            <h1>My wall</h1>
            <p>Create and manage the recipes, kitchen tips and culinary moments you want to share.</p>
        </div>
    </section>
    <main class="page-shell">
        <div class="community-layout">
            <section>
                <div class="form-card">
                    <h2>Create a new post</h2>
                    <form method="POST" enctype="multipart/form-data" class="form-grid">
                        <!-- Encoding Type -->
                        <input class="wide" type="text" name="title" placeholder="Post Title" required>

                        <textarea class="wide" name="content" placeholder="Share your recipe, cooking tip or culinary experience..." required></textarea>

                        <input class="wide" type="file" name="image" accept="image/*">

                        <button type="submit" name="submit_post">Publish post</button>
                    </form>
                </div>
                <h2>My posts</h2>

                <?php while ($row = $posts->fetch_assoc()): ?>

                    <article class="post-card">

                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>

                        <?php if (!empty($row['image'])): ?>
                            <img class="post-card__image" src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <?php endif; ?>

                        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>

                        <div class="post-actions"><a class="action-link quiet" href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a class="action-link danger" href="delete_post.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Delete this post?')">Delete</a>

                        </div>
                    </article>

                <?php endwhile; ?>
            </section>
            <aside class="form-card sidebar-card">
                <div class="eyebrow">Explore</div>
                <h2>See what others are cooking</h2>
                <p>Visit the community cookbook for ideas, conversations and inspiration.</p>
                <a class="button" href="community_cookbook.php">View community</a>
            </aside>
        </div>
    </main>
</body>

</html>