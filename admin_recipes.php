<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Access denied. Admin only.");
}

/* ADD RECIPE */
if (isset($_POST['add'])) {

    $title = $_POST['title'];
    $cuisine = $_POST['cuisine_type'];
    $dietary = $_POST['dietary_preference'];
    $difficulty = $_POST['difficulty'];
    $description = $_POST['description'];

    $imageName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmpName, "uploads/" . $imageName);

    $sql = "INSERT INTO recipes 
            (title, cuisine_type, dietary_preference, difficulty, description, image)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $cuisine, $dietary, $difficulty, $description, $imageName);
    $stmt->execute();

    header("Location: admin_recipes.php");
    exit();
}

$recipes = $conn->query("SELECT * FROM recipes ORDER BY id DESC");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Manage Recipes | FoodFusion</title>
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">Food<span>Fusion</span></a>
        <nav class="site-nav">
            <a href="admin_resources.php">Resources</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="page-shell">
        <a class="back-link" href="index.php">← Back to home</a>

        <div class="form-card">
            <div class="eyebrow">Admin kitchen</div>
            <h2>Add a recipe</h2>

            <form method="POST" enctype="multipart/form-data">
                <!-- POST, ဆိုရင် text data only ပို့နိုင်တယ်။
    file/image upload ပါ, enctype- encoding type ဘယ် format နဲ့ပို့မလဲ
    e.g Normal form - letter openssl_pkey_export
        mutipart/form-data - letter + package+photo -->
                <input type="text" name="title" placeholder="Recipe Title" required>
                <br><br>

                <input type="text" name="cuisine_type" placeholder="Cuisine Type" required>
                <br><br>
                <!-- <input type="text" name="dietary_preference" placeholder="Dietary Preference" required><br><br> -->

                <div class="select-row">

                    <select name="dietary_preference">
                        <option value="">Select Diet</option>
                        <option>Regular</option>
                        <option>Vegetarian</option>
                        <option>Non-Vegetarian</option>
                        <option>Vegan</option>
                        <option>Halal</option>
                        <option>Gluten-Free</option>
                        <option>Keto</option>
                    </select>

                    <select name="difficulty" required>
                        <option value="">Select Difficulty</option>
                        <option>Easy</option>
                        <option>Medium</option>
                        <option>Hard</option>
                    </select>

                </div>
                
                <br>

                <textarea name="description" placeholder="Description" required>
                </textarea>
                <br><br>
                <input type="file" name="image" required>
                <br><br>
                <button type="submit" name="add">Add Recipe</button>
            </form>
        </div>

        <h2>Recipe list</h2>
        <div class="admin-list">
            <?php while ($row = $recipes->fetch_assoc()): ?>
                <article class="admin-item"><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="">
                    <div>
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p>
                            <?php echo $row['cuisine_type']; ?> |
                            <?php echo $row['dietary_preference']; ?> |
                            <?php echo $row['difficulty']; ?> |
                            <?php echo $row['description']; ?>
                        </p>
                    </div>
                    <div class="admin-actions">
                        <a class="action-link quiet" href="edit_recipe.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a class="action-link danger" href="delete_recipe.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this recipe?')">Delete</a>
                    </div>
                </article>

            <?php endwhile; ?>
        </div>
    </main>
</body>

</html>

<!-- Userက browserမှာ imageရွေး <input type="file" name="image">
user: pizza.jpg
PHP က uploaded file information ကို: $_FILESဆိုတဲ့ special array ထဲမှာ သိမ်း
PHP internally:$_FILES['image']ထဲမှာ ဒီလို data တွေရှိတယ်။
Array
(
    [name] => pizza.jpg
    [type] => image/jpeg
    [tmp_name] => C:\xampp\tmp\php123.tmp
    [error] => 0
    [size] => 50234
)
$imageName = $_FILES['image']['name'];
$imageName = "pizza.jpg";

$tmpName = $_FILES['image']['tmp_name'];
Browser က upload လုပ်တဲ့ file ကို PHP က server ထဲမှာ temporary folder တစ်ခုထဲ အရင်သိမ်း
C:\xampp\tmp\php123.tmp
temporary storage ဖြစ်

move_uploaded_file($tmpName, "uploads/" . $imageName);
move_uploaded_file(
    "C:\xampp\tmp\phpA12.tmp",
    "uploads/pizza.jpg"
);
Result: uploads/pizza.jpg
$_FILES['image']['name']     Original filename                        
$_FILES['image']['tmp_name'] Temporary uploaded file location         
move_uploaded_file()         Temp file ကို permanent folder သို့ move 

dietary_preference, diet type ကိုဆိုလိုတာ။Recipe က ဘယ်လိုစားသောက်ပုံစံအတွက် -->