<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>FoodFusion</title>
</head>

<body>

    <nav class="navbar">

        <a class="logo" href="index.php">Food<span>Fusion</span></a>
        <nav class="nav-links" aria-label="Main navigation">
            <a href="index.php" class="active">Home</a>
            <a href="aboutus.php">About</a>
            <a href="recipes.php">Recipes</a>


            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'member'): ?>
                <a href="community_cookbook.php">Community</a>
                <a href="my_wall.php">My Wall</a>
                <a href="contactus.php">Contact Us</a>

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



    <!-- =====================================================
     HERO
===================================================== -->

    <main>
        <section class="hero">
            <div class="hero-image"></div>

            <div class="container">
                <div class="hero-content">

                    <div class="eyebrow"> Welcome to FoodFusion </div>

                    <h1>
                        Discover.
                        <span class="hero-title-accent"> Cook. </span>
                        Share.
                    </h1>

                    <p>

                        Explore delicious recipes from around
                        the world, discover new cooking ideas,
                        and share your favourite creations with
                        a community of food lovers.

                    </p>

                    <div class="hero-buttons">
                        <a href="recipes.php" class="btn btn-primary"> Explore Recipes </a>
                        <a href="community_cookbook.php" class="btn btn-outline"> Community Cookbook </a>
                    </div>

                    <form action="recipes.php" method="GET" class="search-box">
                        <input type="search" name="search" placeholder="Search recipes, ingredients or cuisine..." aria-label="Search recipes">
                        <button type="submit"> Search </button>
                    </form>
                </div>
            </div>
        </section>



        <!-- =====================================================
     CATEGORIES
===================================================== -->

        <section class="categories">

            <div class="container">
                <div class="section-heading">
                    <div class="eyebrow"> Explore </div>
                    <h2> What are you craving? </h2>
                    <p>
                        Discover recipes based on your favourite
                        cuisines and dishes.
                    </p>
                </div>


                <div class="category-grid">
                    <a href="recipes.php?category=asian" class="category-card">
                        <img src="images/asian.jpg" class="category-image" alt="Asian cuisine">
                        <h3> Asian </h3>
                    </a>

                    <a href="recipes.php?category=korean" class="category-card">
                        <img src="images/korea.jpg" class="category-image" alt="Korean cuisine">
                        <h3> Korean </h3>
                    </a>

                    <a href="recipes.php?category=indian" class="category-card">
                        <img src="images/Indian.jpg" class="category-image" alt="Indian cuisine">
                        <h3> Indian </h3>
                    </a>

                    <a href="recipes.php?category=mexican" class="category-card">
                        <img src="images/mexican.jpg" class="category-image" alt="Mexican cuisine">
                        <h3> Mexican </h3>
                    </a>

                    <a href="recipes.php?category=italian" class="category-card">
                        <img src="images/dessert.jpg" class="category-image" alt="Italian cuisine">
                        <h3> Italian </h3>
                    </a>

                    <a href="recipes.php?category=vegetarian" class="category-card">
                        <img src="images/vegetarian.jpg" class="category-image" alt="Vegetarian food">
                        <h3> Vegetarian </h3>
                    </a>
                </div>
            </div>
        </section>



        <!-- =====================================================
     FEATURED RECIPES
===================================================== -->

        <section>

            <div class="container">

                <div class="section-heading">
                    <div class="eyebrow"> From our kitchen </div>

                    <h2> Featured Recipes </h2>

                    <p>
                        Hand-picked recipes to inspire your
                        next delicious meal.
                    </p>
                </div>


                <div class="recipe-grid">
                    <!-- Recipe 1 -->

                    <article class="recipe-card">

                        <div class="recipe-image">
                            <img src="images/pasta1.jpg" alt="Creamy pasta">
                            <span class="recipe-tag"> Popular </span>
                        </div>

                        <div class="recipe-content">
                            <div class="recipe-meta">
                                <span> Italian </span>
                                <span> 30 min </span>
                            </div>

                            <h3> Creamy Garlic Pasta </h3>

                            <p>
                                A simple and comforting pasta
                                dish perfect for a quick dinner.
                            </p>

                            <div class="recipe-footer">
                                <div class="rating"> ★ 4.9 </div>

                                <div class="interaction">
                                    <span> ♡ 124 </span>
                                    <span> 💬 18 </span>
                                </div>

                                <button class="save" type="button" aria-label="Save recipe">
                                    ♡
                                </button>
                            </div>
                        </div>
                    </article>


                    <!-- Recipe 2 -->

                    <article class="recipe-card">

                        <div class="recipe-image">

                            <img src="images/chicken.jpg" alt="Chicken curry">
                            <span class="recipe-tag"> Trending </span>

                        </div>

                        <div class="recipe-content">

                            <div class="recipe-meta">
                                <span> Asian </span>
                                <span> 45 min </span>
                            </div>

                            <h3> Fragrant Chicken Curry </h3>

                            <p>
                                Rich spices and tender chicken
                                come together in this comforting dish.
                            </p>


                            <div class="recipe-footer">

                                <div class="rating"> ★ 4.8 </div>
                                <div class="interaction">
                                    <span> ♡ 96 </span>
                                    <span> 💬 12 </span>
                                </div>

                                <button class="save" type="button" aria-label="Save recipe">
                                    ♡
                                </button>
                            </div>
                        </div>
                    </article>



                    <!-- Recipe 3 -->

                    <article class="recipe-card">

                        <div class="recipe-image">
                            <img src="images/choco.jpg" alt="Chocolate cake">
                            <span class="recipe-tag"> Dessert </span>
                        </div>

                        <div class="recipe-content">
                            <div class="recipe-meta">
                                <span> Baking </span>
                                <span> 60 min </span>
                            </div>

                            <h3> Classic Chocolate Cake </h3>

                            <p>
                                Rich, soft and chocolatey —
                                perfect for celebrations.
                            </p>


                            <div class="recipe-footer">
                                <div class="rating">★ 5.0 </div>

                                <div class="interaction">
                                    <span> ♡ 213 </span>
                                    <span> 💬 34 </span>
                                </div>

                                <button class="save" type="button" aria-label="Save recipe">
                                    ♡
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- =====================================================
     COMMUNITY COOKBOOK
===================================================== -->

        <section class="community">

            <div class="container community-layout">

                <div>
                    <div class="eyebrow"> FoodFusion Community </div>
                    <h2> Your recipe could be
                        someone's next favourite.
                    </h2>

                    <p>
                        Share your favourite recipes, upload
                        your cooking photos, exchange tips,
                        and inspire other food lovers.
                    </p>


                    <div class="community-buttons">
                        <a href="community_cookbook.php" class="btn btn-primary"> Explore Cookbook </a>
                        <a href="recipes.php" class="btn btn-outline"> Share Your Recipe </a>
                    </div>
                </div>

                <div class="community-photo-grid">
                    <div class="community-photo">
                        <img src="images/community.jpg" alt="Community cooking">
                    </div>

                    <div class="community-photo">
                        <img src="images/homemade.jpg" alt="Homemade food">
                    </div>

                    <div class="community-photo">
                        <img src="images/preparation.jpg" alt="Cooking preparation">
                    </div>
                </div>
            </div>
        </section>

        <!-- =====================================================
     EVENTS
===================================================== -->

        <section class="event-section">

            <div class="container">

                <div class="section-heading">

                    <div class="eyebrow"> Learn & Connect </div>
                    <h2> Upcoming Cooking Events </h2>
                    <p>
                        Learn new techniques and meet fellow
                        food enthusiasts.
                    </p>

                </div>


                <div class="event-carousel" id="eventCarousel">

                    <div class="event-track">

                        <article class="event-slide">
                            <div class="event-image">
                                <img src="images/event1.jpg" alt="Cooking class">
                            </div>

                            <div class="event-content">
                                <div class="event-date"> September 12 </div>
                                <h3> Knife Skills 101 </h3>
                                <p>
                                    Learn essential knife techniques
                                    for everyday cooking, from safe grip
                                    and posture to clean dicing, slicing
                                    and julienne cuts.
                                </p>

                                <a href="events.php" class="resource-link">
                                    View Event →
                                </a>
                            </div>
                        </article>


                        <article class="event-slide">
                            <div class="event-image">
                                <img src="images/event2.jpg" alt="Community potluck">
                            </div>

                            <div class="event-content">
                                <div class="event-date"> September 26 </div>
                                <h3> Community Potluck </h3>
                                <p>
                                    Share your favourite dish and
                                    connect with local food lovers.
                                    Bring one plate, leave with new
                                    friends and new recipes.
                                </p>

                                <a href="events.php" class="resource-link">
                                    View Event →
                                </a>
                            </div>
                        </article>


                        <article class="event-slide">
                            <div class="event-image">
                                <img src="images/preparation.jpg" alt="Bread baking preparation">
                            </div>

                            <div class="event-content">
                                <div class="event-date"> October 3 </div>
                                <h3> Bread From Scratch </h3>
                                <p>
                                    Learn the basics of making
                                    delicious homemade bread — mixing,
                                    kneading, proving and baking a
                                    golden crusty loaf.
                                </p>

                                <a href="events.php" class="resource-link">
                                    View Event →
                                </a>
                            </div>
                        </article>
                    </div>

                    <button class="carousel-btn carousel-btn--prev" type="button" aria-label="Previous event">‹</button>
                    <button class="carousel-btn carousel-btn--next" type="button" aria-label="Next event">›</button>

                    <div class="carousel-dots" role="tablist" aria-label="Event slides"></div>
                </div>
            </div>
        </section>

        <!-- =====================================================
     CULINARY RESOURCES
===================================================== -->

        <section>
            <div class="container">
                <div class="section-heading">
                    <div class="eyebrow"> Learn Something New </div>
                    <h2> Culinary Resources </h2>
                    <p>
                        Helpful guides, tutorials and kitchen
                        tips for every level of cook.
                    </p>
                </div>

                <div class="resource-grid">
                    <article class="resource-card">
                        <div class="resource-icon"> 📖 </div>
                        <h3> Recipe Cards </h3>
                        <p>
                            Download printable recipe cards
                            for your favourite dishes.
                        </p>
                        <a href="educational_resources.php" class="resource-link">
                            Explore Resources →
                        </a>
                    </article>

                    <article class="resource-card">
                        <div class="resource-icon"> 🎥 </div>
                        <h3> Cooking Tutorials </h3>
                        <p>
                            Step-by-step tutorials covering
                            useful cooking techniques.
                        </p>
                        <a href="culinary_resources.php" class="resource-link">
                            Watch Tutorials →
                        </a>
                    </article>

                    <article class="resource-card">
                        <div class="resource-icon"> 💡 </div>
                        <h3> Kitchen Hacks </h3>
                        <p>
                            Simple tips and tricks that make
                            everyday cooking easier.
                        </p>
                        <a href="educational_resources.php" class="resource-link">
                            Discover Tips →
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <!-- =====================================================
     JOIN CTA
===================================================== -->

        <section class="join-section">

            <div class="container">
                <div class="join-box">
                    <div class="eyebrow"> Join FoodFusion </div>
                    <h2>
                        Bring your cooking
                        to the community.
                    </h2>
                    <p>
                        Create your account, save your favourite
                        recipes, share your cooking and connect
                        with food enthusiasts.
                    </p>

                    <button type="button" class="btn btn-primary" onclick="showRegister()">
                        Create Your Account
                    </button>
                </div>
            </div>
        </section>
    </main>

    <div class="cookie-notice" id="cookieNotice">
        <p>
            We use cookies to improve your experience and keep FoodFusion running smoothly.
            Read our <a href="privacy.php">Privacy Policy</a> to learn more.
        </p>
        <div class="cookie-buttons">
            <button class="btn-decline" id="cookieDecline">Decline</button>
            <button class="btn-accept" id="cookieAccept">Accept</button>
        </div>
    </div>



    <footer class="site-footer">
        <div class="container footer-grid">
            <div class="footer-intro">
                <a class="footer-logo" href="index.php">Food<span>Fusion</span></a>
                <p>Recipes worth returning to, and a warm table where every home cook belongs.</p>
                <div class="footer-social">
                    <a href="https://www.facebook.com" aria-label="Facebook">f</a>
                    <a href="https://x.com" aria-label="X">𝕏</a>
                    <a href="https://www.instagram.com" aria-label="Instagram">◎</a>
                </div>
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
                <ul><?php if (isset($_SESSION['user_id'])): ?><li><a href="my_wall.php">My wall</a></li>
                        <li>
                            <a href="logout.php">Log out</a>
                        </li><?php else: ?><li>
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

    <!-- login, register form  -->

    <div id="modalBackdrop" class="modal-backdrop" onclick="if(event.target === this) closeAll()">

        <section id="registerForm" class="auth-modal" role="dialog" aria-modal="true">

            <button class="modal-close" type="button" aria-label="Close registration form" onclick="closeAll()">×</button>
            <div class="auth-kicker">
                A table for everyone
            </div>

            <h2>Join FoodFusion</h2>

            <p>Create your account and begin collecting delicious ideas.</p>

            <form action="register.php" method="POST" class="auth-form">
                <div class="name-fields">
                    <input type="text" name="first_name" placeholder="First name" required>
                    <input type="text" name="last_name" placeholder="Last name" required>
                </div>

                <input type="email" name="email" placeholder="Email address" required>
                <input type="password" name="password" placeholder="Create a password" required>

                <button type="submit">Create my account <span>→</span></button>
            </form>

            <p class="auth-switch"> Already cooking with us? <button type="button" onclick="showLogin()">Log in</button></p>
        </section>

        <section id="loginForm" class="auth-modal" role="dialog" aria-modal="true">
            <button class="modal-close" type="button" aria-label="Close login form" onclick="closeAll()">×</button>
            <div class="auth-kicker">Welcome back</div>
            <h2>Good to see you</h2>
            <p>Pick up where your last food adventure left off.</p>

            <form action="login.php" method="POST" class="auth-form" onsubmit="handleLogin(event)">
                <!-- Styled error banner container -->
                <div id="authAlert" class="auth-alert hidden" role="alert"></div>

                <input type="email" name="email" placeholder="Email address" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" id="submitBtn">Log in <span>→</span></button>
            </form>

            <p class="auth-switch">New to FoodFusion? <button type="button" onclick="showRegister()">Create an account</button></p>
            <p class="auth-switch">
                <button type="button" onclick="showForgot()">Forgot password?</button>
            </p>
        </section>

        <section id="forgotForm" class="auth-modal" role="dialog" aria-modal="true">
            <button class="modal-close" type="button" aria-label="Close" onclick="closeAll()">×</button>
            <div class="auth-kicker">Locked out?</div>
            <h2>Reset your password</h2>
            <p>Enter your email and reset your password.</p>

            <form class="auth-form" onsubmit="handleForgotSubmit(event)">
                <input type="hidden" name="ajax" value="1">
                <div id="forgotAlert" class="auth-alert hidden" role="alert"></div>
                <input type="email" name="email" id="forgotEmail" placeholder="Email address" required>
                <button type="submit"> Reset Password <span>→</span></button>
            </form>

            <p class="auth-switch">Remembered it? <button type="button" onclick="showLogin()">Back to log in</button></p>
        </section>
    </div>

    <script>
        async function handleLogin(event) {
            event.preventDefault();

            const form = event.target;
            const alertBox = document.getElementById("authAlert");
            const formData = new FormData(form);

            try {
                const response = await fetch("login.php", {
                    method: "POST",
                    body: formData
                });

                // Check if PHP issued a redirect header to index.php (Login Success)
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                const rawText = await response.text();

                // If PHP returned HTML text, parse and clean it
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = rawText;

                // Remove unwanted "Try again" or "Back to Login" links from raw HTML output
                const links = tempDiv.querySelectorAll("a");
                links.forEach(link => link.remove());

                const cleanedMessage = tempDiv.textContent.trim();

                // If the text includes success markers or no message, reload to proceed
                if (!cleanedMessage) {
                    window.location.reload();
                    return;
                }

                // Display styled warning message
                alertBox.textContent = cleanedMessage;
                alertBox.classList.remove("hidden");

                // Trigger shake effect
                triggerShake();

            } catch (error) {
                alertBox.textContent = "An error occurred. Please try again.";
                alertBox.classList.remove("hidden");
            }
        }

        async function handleForgotSubmit(event) {
            event.preventDefault();

            const form = event.target;
            const alertBox = document.getElementById("forgotAlert");
            const formData = new FormData(form); // includes email + hidden ajax=1 field
            const btn = form.querySelector('button[type="submit"]');

            btn.disabled = true;
            alertBox.classList.add("hidden");
            alertBox.classList.remove("is-error");

            try {
                const response = await fetch("forgot_password.php", {
                    method: "POST",
                    body: formData
                });

                const data = await response.json();

                // DEMO ONLY: skip straight to the reset form instead of
                // waiting on an email. Remove this block for a real deployment.
                if (data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }

                alertBox.textContent = data.message;
                alertBox.classList.remove("hidden");
                if (!data.success) alertBox.classList.add("is-error");

            } catch (error) {
                alertBox.textContent = "An error occurred. Please try again.";
                alertBox.classList.remove("hidden");
                alertBox.classList.add("is-error");
            } finally {
                btn.disabled = false;
            }
        }

        function triggerShake() {
            const modal = document.getElementById("loginForm");
            modal.classList.remove("shake");
            void modal.offsetWidth; // Force CSS reflow
            modal.classList.add("shake");
        }

        function showRegister() {
            document.getElementById("modalBackdrop").classList.add("is-open");
            document.getElementById("registerForm").classList.add("is-active");
            document.getElementById("loginForm").classList.remove("is-active");
            document.getElementById("forgotForm").classList.remove("is-active");
            document.body.classList.add("modal-open");
        }

        function showLogin() {
            document.getElementById("modalBackdrop").classList.add("is-open");
            document.getElementById("loginForm").classList.add("is-active");
            document.getElementById("registerForm").classList.remove("is-active");
            document.getElementById("forgotForm").classList.remove("is-active");
            document.body.classList.add("modal-open");
        }

        function showForgot() {
            document.getElementById("modalBackdrop").classList.add("is-open");
            document.getElementById("forgotForm").classList.add("is-active");
            document.getElementById("loginForm").classList.remove("is-active");
            document.getElementById("registerForm").classList.remove("is-active");
            document.body.classList.add("modal-open");
        }

        function closeAll() {
            document.getElementById("modalBackdrop").classList.remove("is-open");
            document.getElementById("registerForm").classList.remove("is-active");
            document.getElementById("loginForm").classList.remove("is-active");
            document.getElementById("forgotForm").classList.remove("is-active");
            document.body.classList.remove("modal-open");
        }

        document.addEventListener("keydown", event => {
            if (event.key === "Escape") closeAll();
        });
    </script>


    <script>
        (function() {
            var notice = document.getElementById('cookieNotice');
            var consent = localStorage.getItem('foodfusion_cookie_consent');

            if (consent) {
                notice.classList.add('hidden');
            }

            function setConsent(value) {
                localStorage.setItem('foodfusion_cookie_consent', value);
                notice.classList.add('hidden');
            }

            document.getElementById('cookieAccept').addEventListener('click', function() {
                setConsent('accepted');
            });

            document.getElementById('cookieDecline').addEventListener('click', function() {
                setConsent('declined');
            });
        })();
    </script>

    <script>
        (function() {
            var carousel = document.getElementById('eventCarousel');
            if (!carousel) return;

            var track = carousel.querySelector('.event-track');
            var slides = carousel.querySelectorAll('.event-slide');
            var dotsWrap = carousel.querySelector('.carousel-dots');
            var current = 0;
            var timer = null;

            slides.forEach(function(slide, i) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'carousel-dot';
                dot.setAttribute('aria-label', 'Go to event ' + (i + 1));
                dot.addEventListener('click', function() {
                    goTo(i);
                    restart();
                });
                dotsWrap.appendChild(dot);
            });

            var dots = dotsWrap.querySelectorAll('.carousel-dot');

            function goTo(index) {
                current = (index + slides.length) % slides.length;
                track.style.transform = 'translateX(-' + current * 100 + '%)';
                dots.forEach(function(dot, i) {
                    dot.classList.toggle('is-active', i === current);
                });
            }

            function restart() {
                clearInterval(timer);
                timer = setInterval(function() {
                    goTo(current + 1);
                }, 5000);
            }

            carousel.querySelector('.carousel-btn--prev').addEventListener('click', function() {
                goTo(current - 1);
                restart();
            });

            carousel.querySelector('.carousel-btn--next').addEventListener('click', function() {
                goTo(current + 1);
                restart();
            });

            carousel.addEventListener('mouseenter', function() {
                clearInterval(timer);
            });
            carousel.addEventListener('mouseleave', restart);

            goTo(0);
            restart();
        })();
    </script>

</body>

</html>