<?php session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Cooking Events | FoodFusion</title>
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">Food<span>Fusion</span></a>
        <nav class="site-nav">
            <a href="index.php">Home</a>
            <a href="recipes.php">Recipes</a>
            <a href="community_cookbook.php">Community</a>
        </nav>
    </header>

    <section class="page-hero">
        <div class="container">
            <div class="eyebrow">Learn &amp; connect</div>
            <h1>Upcoming cooking events</h1>
            <p>Hands-on classes and community gatherings for every level of cook. New events are announced on the homepage carousel.</p>
        </div>
    </section>

    <main class="page-shell">
        <div class="card-grid">

            <article class="content-card">
                <img class="content-card__image" src="images/event1.jpg" alt="Knife skills class">
                <div class="content-card__body">
                    <div class="tag-row">
                        <span class="tag">September 12</span>
                        <span class="tag">Workshop</span>
                    </div>
                    <h2>Knife Skills 101</h2>
                    <p>Learn essential knife techniques for everyday cooking — safe grip, posture, and clean dicing, slicing and julienne cuts. All equipment provided; just bring your appetite.</p>
                    <div class="meta">
                        <span class="tag">Beginner friendly</span>
                        <span class="tag">2 hours</span>
                    </div>
                </div>
            </article>

            <article class="content-card">
                <img class="content-card__image" src="images/event2.jpg" alt="Community potluck">
                <div class="content-card__body">
                    <div class="tag-row">
                        <span class="tag">September 26</span>
                        <span class="tag">Community</span>
                    </div>
                    <h2>Community Potluck</h2>
                    <p>Share your favourite dish and connect with local food lovers. Bring one plate, leave with new friends and new recipes for your collection.</p>
                    <div class="meta">
                        <span class="tag">All welcome</span>
                        <span class="tag">Evening</span>
                    </div>
                </div>
            </article>

            <article class="content-card">
                <img class="content-card__image" src="images/preparation.jpg" alt="Bread baking preparation">
                <div class="content-card__body">
                    <div class="tag-row">
                        <span class="tag">October 3</span>
                        <span class="tag">Class</span>
                    </div>
                    <h2>Bread From Scratch</h2>
                    <p>Learn the basics of making delicious homemade bread — mixing, kneading, proving and baking a golden crusty loaf you can take home.</p>
                    <div class="meta">
                        <span class="tag">Intermediate</span>
                        <span class="tag">3 hours</span>
                    </div>
                </div>
            </article>

        </div>
        <p style="text-align:center;margin-top:26px;">
            <a class="back-link" href="index.php">← Back to homepage</a>
        </p>
    </main>
</body>

</html>
