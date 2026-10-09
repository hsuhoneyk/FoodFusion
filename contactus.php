<?php
require_once "db.php";

$errors  = [];
$success = false;

$old = [
    "name"    => "",
    "email"   => "",
    "subject" => "",
    "message" => "",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST["website"])) {
        $success = true;
    } else {

        $name    = trim($_POST["name"] ?? "");
        $email   = trim($_POST["email"] ?? "");
        $subject = trim($_POST["subject"] ?? "");
        $message = trim($_POST["message"] ?? "");

        $old = compact("name", "email", "subject", "message");

        if ($name === "" || mb_strlen($name) > 100) {
            $errors["name"] = "Enter your name.";
        }

        if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            $errors["email"] = "Enter a valid email address.";
        }

        if ($subject === "" || mb_strlen($subject) > 200) {
            $errors["subject"] = "Enter a subject.";
        }

        if ($message === "") {
            $errors["message"] = "Enter a message.";
        }

        if (empty($errors)) {
            $stmt = $conn->prepare(
                "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            $stmt->execute();
            $stmt->close();

            $success = true;
            $old = ["name" => "", "email" => "", "subject" => "", "message" => ""];
        }
    }
}

function old_val($old, $key)
{
    return htmlspecialchars($old[$key], ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us — FoodFusion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="site-header">
        <a class="brand" href="index.php">Food<span>Fusion</span></a>
        <nav class="site-nav">
            <a href="index.php">Home</a>
            <a href="aboutus.php">About</a>
            <a href="recipes.php">Recipes</a>
            <a class="active" href="contactus.php">Contact Us</a>
        </nav>
    </header>


    <section class="contact-hero">
        <h4>Get in touch</h4>
        <h1>Let's <span>talk food</span></h1>
        <p>Questions, recipe requests, or just want to say hi? Send us a message and we'll get back to you.</p>
    </section>

    <section class="contact-wrap">

        <div class="contact-card">

            <?php if ($success): ?>

                <div class="form-success">
                    <div class="success-check">
                        <svg viewBox="0 0 24 24">
                            <polyline points="4 12 10 18 20 6"></polyline>
                        </svg>
                    </div>
                    <h3>Message sent</h3>
                    <p>Thanks for reaching out — we'll reply to <?= htmlspecialchars($_POST["email"] ?? "your email", ENT_QUOTES, "UTF-8") ?> soon, usually within 1–2 business days.</p>
                    <a href="contactus.php" class="btn-again">Send another message</a>
                </div>

            <?php else: ?>

                <h2>Send us a message</h2>

                <?php if (!empty($errors)): ?>
                    <div class="form-error-banner">Please fix the highlighted fields below.</div>
                <?php endif; ?>

                <form action="contactus.php" method="POST" novalidate>

                    <div class="form-row">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="<?= old_val($old, 'name') ?>" placeholder="Your name">
                        <?php if (isset($errors["name"])): ?>
                            <span class="field-error"><?= $errors["name"] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= old_val($old, 'email') ?>" placeholder="name@example.com">
                        <?php if (isset($errors["email"])): ?>
                            <span class="field-error"><?= $errors["email"] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" value="<?= old_val($old, 'subject') ?>" placeholder="What's this about?">
                        <?php if (isset($errors["subject"])): ?>
                            <span class="field-error"><?= $errors["subject"] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Tell us more..."><?= old_val($old, 'message') ?></textarea>
                        <?php if (isset($errors["message"])): ?>
                            <span class="field-error"><?= $errors["message"] ?></span>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn-submit">Send message</button>

                </form>

            <?php endif; ?>

        </div>

        <div class="contact-side">
            <h3>Other ways to reach us</h3>
            <ul>
                <li><i>Email</i><span>info@foodfusion.com</span></li>
                <li><i>Community</i><span>Join the forum for quick answers</span></li>
                <li><i>Response time</i><span>Usually within 1–2 business days</span></li>
            </ul>
        </div>

    </section>

</body>

</html>