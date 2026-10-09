<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT * FROM community_posts
    WHERE id = ? AND user_id = ?
");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    die("Post not found or access denied.");
}

$post = $result->fetch_assoc();

/* UPDATE POST */
if (isset($_POST['update_post'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $imageName = $post['image'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $tmpName = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmpName, "uploads/" . $imageName);
    }

    $sql = "UPDATE community_posts
            SET title = ?, content = ?, image = ?
            WHERE id = ? AND user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $title, $content, $imageName, $post_id, $user_id);
    $stmt->execute();

    header("Location: my_wall.php");
    exit();
}
?>

<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="style.css?v=4">
    <title>Edit Post</title>
</head>

<body>
    <header class="site-header"><a class="brand" href="index.php">Food<span>Fusion</span></a></header>
    <main class="page-shell"><a class="back-link" href="my_wall.php">← My wall</a>
        <div class="form-card">
            <h2>Edit post</h2>

            <form method="POST" enctype="multipart/form-data">

                <input type="text" name="title"
                    value="<?php echo htmlspecialchars($post['title']); ?>" required>
                <br><br>

                <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                <br><br>

                <?php if (!empty($post['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" width="180">
                    <br><br>
                <?php endif; ?>

                <input type="file" name="image">
                <br><br>

                <button type="submit" name="update_post">Update Post</button>

            </form>
        </div>
    </main>
</body>

</html>