<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About FoodFusion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar">

        <a class="logo" href="index.php">Food<span>Fusion</span></a>
        <nav class="nav-links" aria-label="Main navigation">
            <a href="index.php">Home</a>
            <a href="aboutus.php" class="active">About</a>
            <a href="recipes.php">Recipes</a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'member'): ?>
                <a href="contactus.php">Contact Us</a>
                <a href="community_cookbook.php">Community</a>
                <a href="my_wall.php">My Wall</a>

            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="community_cookbook.php">Community</a>
                <div class="dropdown">
                    <a href="admin_resources.php">Studio ▾</a>
                    <div class="dropdown-content">
                        <a href="admin_recipes.php">Manage recipes</a>
                        <a href="admin_resources.php">Manage resources</a>
                        <a href="admin_contact.php">Manage contact</a>
                    </div>
                </div>
            <?php endif; ?>
        </nav>

        <span class="user-area">

            <?php if (isset($_SESSION['user_id'])): ?>

                <div class="user-pill">
                    Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>
                </div>

                <a href="logout.php" class="logout-btn">Logout</a>

            <?php else: ?>

                <button onclick="showRegister()">Join Us</button>
                <button onclick="showLogin()">Login</button>

            <?php endif; ?>

        </span>

    </nav>

    <div id="modalBackdrop" class="modal-backdrop" onclick="if(event.target === this) closeAll()">
        <section id="registerForm" class="auth-modal" role="dialog" aria-modal="true">
            <button class="modal-close" type="button" aria-label="Close registration form" onclick="closeAll()">×</button>
            <div class="auth-kicker">A table for everyone</div>
            <h2>Join FoodFusion</h2>
            <p>Create your account and begin collecting delicious ideas.</p>
            <form action="register.php" method="POST" class="auth-form">
                <div class="name-fields">
                    <input type="text" name="first_name" placeholder="First name" required>
                    <input type="text" name="last_name" placeholder="Last name" required>
                </div>

                <input type="email" name="email" placeholder="Email address" required>
                <input type="password" name="password" placeholder="Create a password" required>
                <button type="submit">Create my account <span>→</span>
                </button>
            </form>
            <p class="auth-switch">Already cooking with us?
                <button type="button" onclick="showLogin()">Log in</button>
            </p>
        </section>

        <section id="loginForm" class="auth-modal" role="dialog" aria-modal="true">

            <button class="modal-close" type="button" aria-label="Close login form" onclick="closeAll()">×</button>
            <div class="auth-kicker">Welcome back</div>
            <h2>Good to see you</h2>
            <p>Pick up where your last food adventure left off.</p>

            <form action="login.php" method="POST" class="auth-form">
                <input type="email" name="email" placeholder="Email address" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Log in <span>→</span>
                </button>
            </form>

            <p class="auth-switch">New to FoodFusion?
                <button type="button" onclick="showRegister()">Create an account</button>
            </p>
        </section>
    </div>

    <script>
        function showRegister() {
            document.getElementById("modalBackdrop").classList.add("is-open");
            document.getElementById("registerForm").classList.add("is-active");
            document.getElementById("loginForm").classList.remove("is-active");
            document.body.classList.add("modal-open");
        }

        function showLogin() {
            document.getElementById("modalBackdrop").classList.add("is-open");
            document.getElementById("loginForm").classList.add("is-active");
            document.getElementById("registerForm").classList.remove("is-active");
            document.body.classList.add("modal-open");
        }

        function closeAll() {
            document.getElementById("modalBackdrop").classList.remove("is-open");
            document.getElementById("registerForm").classList.remove("is-active");
            document.getElementById("loginForm").classList.remove("is-active");
            document.body.classList.remove("modal-open");
        }
        document.addEventListener("keydown", event => {
            if (event.key === "Escape") closeAll();
        });
    </script>

    <!-- About Hero Section -->
    <section class="about-hero">

        <div class="hero-text">
            <h4>About Us</h4>
            <h1>Welcome to <br><span>FoodFusion</span></h1>
            <p>
                At FoodFusion, we believe that food brings people together.
                Our mission is to inspire home cooks with delicious recipes,
                simple ingredients, and a passion for sharing good food with
                the ones they love.
            </p>
            <p>
                Whether you're looking for quick meals, comfort classics,
                or something new to try, you'll find it here.
            </p>
            <h3>Let's cook. Share. Enjoy. ♡</h3>
        </div>

        <div class="hero-image">
            <div class="photo-frame">
                <img src="images/community.jpg" alt="Friends sharing food">
                <div class="photo-caption">home is where the pot simmers</div>
            </div>
        </div>

    </section>


    <!-- Mission / Community / Passion -->

    <section class="about-info">

        <div class="info-box">
            <h2>Our mission</h2>
            <p>To make cooking enjoyable, accessible, and rewarding for everyone.</p>
        </div>

        <div class="info-box">
            <h2>Our community</h2>
            <p>We are a community of food lovers who share recipes, learn together, and inspire one another.</p>
        </div>

        <div class="info-box">
            <h2>Our passion</h2>
            <p>We are passionate about delicious food, creative recipes, and meaningful connections.</p>
        </div>

    </section>


    <!-- Our Story -->

    <section class="our-story">

        <div class="story-image">
            <img src="images/Fragrant_Chicken_Curry.jpg" alt="Fragrant chicken curry, the dish that started it all">
        </div>

        <div class="story-content">
            <h4>Our story</h4>
            <h2>How FoodFusion began</h2>

            <div class="story-step">
                <span class="step-mark">1</span>
                <p><strong>2026 —</strong> FoodFusion was founded by a group of university students who shared a passion for cooking, creativity, and web development.</p>
            </div>

            <div class="story-step">
                <span class="step-mark">2</span>
                <p><strong>Soon after —</strong> what started as a university project became a platform for discovering recipes, learning techniques, and exploring cuisines from around the world.</p>
            </div>

            <div class="story-step">
                <span class="step-mark">3</span>
                <p><strong>Today —</strong> FoodFusion keeps growing as a welcoming community where everyone, from beginners to experienced cooks, can find inspiration and share ideas.</p>
            </div>
        </div>

    </section>


    <!-- Why Choose FoodFusion -->

    <section class="why-us">

        <h2>Why choose <span>FoodFusion</span>?</h2>

        <div class="features">

            <div class="feature">
                <div class="feature-lid"></div>
                <div class="feature-body">
                    <h3>Easy recipes</h3>
                    <p>Simple and easy-to-follow recipes for everyone.</p>
                </div>
            </div>

            <div class="feature">
                <div class="feature-lid"></div>
                <div class="feature-body">
                    <h3>Global cuisine</h3>
                    <p>Explore dishes and flavors from around the world.</p>
                </div>
            </div>

            <div class="feature">
                <div class="feature-lid"></div>
                <div class="feature-body">
                    <h3>Friendly community</h3>
                    <p>Share your recipes and connect with fellow food lovers.</p>
                </div>
            </div>

        </div>

    </section>


    <!-- Meet The Team -->

    <!-- Meet The Team -->

    <section class="team-section">

        <div class="container">
            <div class="section-heading">
                <div class="eyebrow">The people behind FoodFusion</div>
                <h2>Meet Our Team</h2>
                <p>We are a passionate team working together to create a simple, enjoyable and inspiring cooking experience.</p>
            </div>

            <div class="team-grid">

                <article class="team-card">
                    <div class="team-avatar">G</div>
                    <h3>Gordon</h3>
                    <span class="team-role">Project Lead · Recipe Developer</span>
                    <p>Leads the FoodFusion project and helps create, organise and test recipes for our cooking community.</p>
                </article>

                <article class="team-card">
                    <div class="team-avatar">V</div>
                    <h3>Vannie</h3>
                    <span class="team-role">Web Developer · UI Designer</span>
                    <p>Develops the website and creates a clean, user-friendly experience for everyone visiting FoodFusion.</p>
                </article>

                <article class="team-card">
                    <div class="team-avatar">A</div>
                    <h3>Amy</h3>
                    <span class="team-role">Community Manager</span>
                    <p>Supports the FoodFusion community and encourages members to share their recipes, ideas and cooking experiences.</p>
                </article>

                <article class="team-card">
                    <div class="team-avatar">D</div>
                    <h3>Daniel</h3>
                    <span class="team-role">Food Content Creator</span>
                    <p>Creates cooking guides and food-related content to help users discover new recipes and improve their cooking skills.</p>
                </article>

            </div>
        </div>

    </section>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div class="footer-intro"><a class="footer-logo" href="index.php">Food<span>Fusion</span></a>
                <p>Recipes worth returning to, and a warm table where every home cook belongs.</p>
                <div class="footer-social"><a href="https://www.facebook.com" aria-label="Facebook">f</a><a href="https://x.com" aria-label="X">𝕏</a><a href="https://www.instagram.com" aria-label="Instagram">◎</a></div>
            </div>
            <div>
                <h4>Explore</h4>
                <ul>
                    <li><a href="recipes.php">Recipe collection</a></li>
                    <li><a href="community_cookbook.php">Community cookbook</a></li>
                    <li><a href="culinary_resources.php">Cooking resources</a></li>
                </ul>
            </div>
            <div>
                <h4>FoodFusion</h4>
                <ul>
                    <li><a href="aboutus.php">Our story</a></li>
                    <li><a href="educational_resources.php">Learn with us</a></li>
                    <li><a href="community_cookbook.php">Share a dish</a></li>
                    <li><a href="privacy.php">Privacy &amp; cookie policy</a></li>
                </ul>
            </div>
            <div>
                <h4>Your account</h4>
                <ul><?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="my_wall.php">My wall</a>
                        </li>
                        <li>
                            <a href="logout.php">Log out</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="login.php" onclick="showLogin();return false;">Log in</a>
                        </li>
                        <li>
                            <a href="register.php" onclick="showRegister();return false;">Create account</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="container footer-bottom">
            <span>© 2026 FoodFusion</span>
            <span>Cook slowly. Share generously.</span>
        </div>
    </footer>


</body>

</html>