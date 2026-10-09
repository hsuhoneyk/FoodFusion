<?php
session_start();
include "db.php";

$search = trim($_GET['search'] ?? "");
$cuisine = trim($_GET['cuisine'] ?? "");
$diet = trim($_GET['diet'] ?? "");
$difficulty = trim($_GET['difficulty'] ?? "");
$category = strtolower(trim($_GET['category'] ?? ""));

/* Homepage category cards link here with ?category= — map them onto filters */
if ($category !== "" && $cuisine === "" && $diet === "") {
        if (in_array($category, ["vegetarian", "dessert", "desserts", "baking"], true)) {
                $diet = $category === "desserts" ? "dessert" : $category;
                $_GET['diet'] = $diet;
        } else {
                $cuisine = $category;
                $_GET['cuisine'] = $cuisine;
        }
}

/* Build query with optional filters */
$conditions = [];
$types = "";
$params = [];

if ($search !== "") {
        $conditions[] = "(title LIKE ? OR cuisine_type LIKE ? OR dietary_preference LIKE ? OR difficulty LIKE ?)";
        $types .= "ssss";
        $keyword = "%$search%";
        array_push($params, $keyword, $keyword, $keyword, $keyword);
}
if ($cuisine !== "") {
        $conditions[] = "LOWER(cuisine_type) = LOWER(?)";
        $types .= "s";
        $params[] = $cuisine;
}
if ($diet !== "") {
        $conditions[] = "LOWER(dietary_preference) = LOWER(?)";
        $types .= "s";
        $params[] = $diet;
}
if ($difficulty !== "") {
        $conditions[] = "LOWER(difficulty) = LOWER(?)";
        $types .= "s";
        $params[] = $difficulty;
}

$sql = "SELECT * FROM recipes" .
        (count($conditions) ? " WHERE " . implode(" AND ", $conditions) : "") .
        " ORDER BY id DESC";

$stmt = $conn->prepare($sql);
if ($params) {
        $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

/* Distinct values for the filter chips */
$cuisines = array_column($conn->query("SELECT DISTINCT cuisine_type FROM recipes WHERE cuisine_type <> '' AND cuisine_type IS NOT NULL ORDER BY cuisine_type")->fetch_all(MYSQLI_ASSOC), "cuisine_type");
$diets = array_column($conn->query("SELECT DISTINCT dietary_preference FROM recipes WHERE dietary_preference <> '' AND dietary_preference IS NOT NULL ORDER BY dietary_preference")->fetch_all(MYSQLI_ASSOC), "dietary_preference");
$difficulties = array_column($conn->query("SELECT DISTINCT difficulty FROM recipes WHERE difficulty <> '' AND difficulty IS NOT NULL ORDER BY difficulty")->fetch_all(MYSQLI_ASSOC), "difficulty");

/* Build a chip link that keeps the other active filters */
function filter_url($key, $value)
{
        $query = $_GET;
        if (isset($query[$key]) && strtolower($query[$key]) === strtolower($value)) {
                unset($query[$key]); /* clicking the active chip clears it */
        } else {
                $query[$key] = $value;
        }
        unset($query['category']);
        return "recipes.php" . (count($query) ? "?" . http_build_query($query) : "");
}

function is_active($key, $value)
{
        return isset($_GET[$key]) && strtolower($_GET[$key]) === strtolower($value);
}
?>

<!doctype html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="style.css">
        <title>Recipe Collection | FoodFusion</title>
</head>

<body>
        <header class="site-header">
                <a class="brand" href="index.php">Food<span>Fusion</span></a>
                <nav class="site-nav">
                        <a href="index.php" >Home</a>
                        <a href="aboutus.php">About</a>
                        <a href="recipes.php" class="active">Recipes</a>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'member'): ?>
                                <a href="contactus.php">Contact Us</a>


                        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a href="admin_contact.php">Message</a>

                        <?php endif; ?>

                </nav>
        </header>
        <section class="page-hero">
                <div class="container">
                        <div class="eyebrow">Discover your next favorite</div>
                        <h1>Recipe collection</h1>
                        <p>Search by flavour, or filter by cuisine type, dietary preference and cooking difficulty.</p>
                </div>
        </section>
        <main class="page-shell">
                <form method="GET" class="toolbar">
                        <input type="search" name="search" placeholder="Search recipe, cuisine, diet, difficulty" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit">Search recipes</button>
                </form>

                <div class="filter-groups">
                        <?php if (count($cuisines)): ?>
                                <div class="filter-group">
                                        <span class="filter-label">Cuisine</span>
                                        <?php foreach ($cuisines as $c): ?>
                                                <a class="filter-chip<?php echo is_active('cuisine', $c) ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars(filter_url('cuisine', $c)); ?>">
                                                        <?php echo htmlspecialchars($c); ?>
                                                </a>
                                        <?php endforeach; ?>
                                </div>
                        <?php endif; ?>

                        <?php if (count($diets)): ?>
                                <div class="filter-group">
                                        <span class="filter-label">Dietary</span>
                                        <?php foreach ($diets as $d): ?>
                                                <a class="filter-chip<?php echo is_active('diet', $d) ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars(filter_url('diet', $d)); ?>">
                                                        <?php echo htmlspecialchars($d); ?>
                                                </a>
                                        <?php endforeach; ?>
                                </div>
                        <?php endif; ?>

                        <?php if (count($difficulties)): ?>
                                <div class="filter-group">
                                        <span class="filter-label">Difficulty</span>
                                        <?php foreach ($difficulties as $df): ?>
                                                <a class="filter-chip<?php echo is_active('difficulty', $df) ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars(filter_url('difficulty', $df)); ?>">
                                                        <?php echo htmlspecialchars($df); ?>
                                                </a>
                                        <?php endforeach; ?>
                                </div>
                        <?php endif; ?>

                        <?php if ($search !== "" || $cuisine !== "" || $diet !== "" || $difficulty !== ""): ?>
                                <div class="filter-group">
                                        <a class="filter-chip filter-chip--clear" href="recipes.php">✕ Clear all filters</a>
                                </div>
                        <?php endif; ?>
                </div>

                <div class="card-grid">
                        <?php $hasRecipes = false;
                        while ($row = $result->fetch_assoc()): $hasRecipes = true; ?>
                                <article class="content-card">
                                        <img class="content-card__image" src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                        <div class="content-card__body">
                                                <div class="tag-row">
                                                        <span class="tag"><?php echo htmlspecialchars($row['cuisine_type']); ?></span>
                                                        <span class="tag"><?php echo htmlspecialchars($row['difficulty']); ?></span>
                                                </div>
                                                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                                                <p><?php echo htmlspecialchars($row['description']); ?></p>
                                                <div class="meta">
                                                        <span class="tag">
                                                                <?php echo htmlspecialchars($row['dietary_preference']); ?>
                                                        </span>
                                                </div>
                                        </div>
                                </article>
                        <?php endwhile;
                        if (!$hasRecipes): ?>
                        <div class="empty-state">No recipes matched that search. Try another ingredient or category.</div>
                        <?php endif; ?>
                </div>
        </main>
</body>

</html>