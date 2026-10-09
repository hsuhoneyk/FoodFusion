<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Access denied.");
}

$id = $_GET['id'];

$sql = "SELECT * FROM recipes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$recipe = $stmt->get_result()->fetch_assoc();

if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $cuisine = $_POST['cuisine_type'];
    $dietary = $_POST['dietary_preference'];
    $difficulty = $_POST['difficulty'];
    $description = $_POST['description'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmpName, "uploads/" . $imageName);

        $sql = "UPDATE recipes 
                SET title=?, cuisine_type=?, dietary_preference=?, difficulty=?, description=?, image=?
                WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $title, $cuisine, $dietary, $difficulty, $description, $imageName, $id);
    } else {

        $sql = "UPDATE recipes 
                SET title=?, cuisine_type=?, dietary_preference=?, difficulty=?, description=?
                WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $title, $cuisine, $dietary, $difficulty, $description, $id);
    }

    $stmt->execute();

    header("Location: admin_recipes.php");
    exit();
}
?>

<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="style.css?v=4">
    <title>Edit Recipe</title>
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">Food<span>Fusion</span>
        </a>
    </header>
    <main class="page-shell">
        <a class="back-link" href="admin_recipes.php">← Recipe management</a>
        <div class="form-card">
            <h2>Edit recipe</h2>

            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="title" value="<?php echo $recipe['title']; ?>" required><br><br>
                <input type="text" name="cuisine_type" value="<?php echo $recipe['cuisine_type']; ?>" required><br><br>
                <!-- <input type="text" name="dietary_preference" value="<?php echo $recipe['dietary_preference']; ?>" required><br><br> -->
                <select name="dietary_preference" required>
                    <option value="">Select Diet</option>
                    <option value="Vegetarian" <?php if ($recipe['dietary_preference'] == 'Vegetarian') echo 'selected'; ?>>
                        Vegetarian
                    </option>

                    <option value="Non-Vegetarian" <?php if ($recipe['dietary_preference'] == 'Non-Vegetarian') echo 'selected'; ?>>
                        Non-Vegetarian
                    </option>

                    <option value="Vegan" <?php if ($recipe['dietary_preference'] == 'Vegan') echo 'selected'; ?>>
                        Vegan
                    </option>

                    <option value="Halal" <?php if ($recipe['dietary_preference'] == 'Halal') echo 'selected'; ?>>
                        Halal
                    </option>

                    <option value="Gluten-Free" <?php if ($recipe['dietary_preference'] == 'Gluten-Free') echo 'selected'; ?>>
                        Gluten-Free
                        <!-- ဂျုံပါဝင်မှု မရှိတဲ့ food -->
                    </option>

                    <option value="Keto" <?php if ($recipe['dietary_preference'] == 'Keto') echo 'selected'; ?>>
                        Keto
                        <!-- carb နည်း fat များ -->
                    </option>
                </select>
                <br><br>

                <select name="difficulty">
                    <option <?php if ($recipe['difficulty'] == "Easy") echo "selected"; ?>>Easy</option>
                    <option <?php if ($recipe['difficulty'] == "Medium") echo "selected"; ?>>Medium</option>
                    <option <?php if ($recipe['difficulty'] == "Hard") echo "selected"; ?>>Hard</option>
                </select><br><br>
                
                <textarea name="description" required><?php echo $recipe['description']; ?></textarea><br><br>
                <img src="uploads/<?php echo $recipe['image']; ?>" width="150"><br><br>
                <input type="file" name="image"><br><br>
                <button type="submit" name="update">Update Recipe</button>
            </form>
        </div>
    </main>
</body>

</html>