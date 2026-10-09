<?php
require_once "db.php";

$result   = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $result->fetch_all(MYSQLI_ASSOC);

function h($val)
{
    return htmlspecialchars($val, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages — FoodFusion Admin</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">Food<span>Fusion</span></a>
        <nav class="site-nav">
            <a href="admin_recipes.php">Recipes</a>
            <a href="admin_contact.php" class="active">Messages</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <section class="admin-header">
        <h4>FoodFusion admin</h4>
        <h1>Contact messages</h1>
        <p><?= count($messages) ?> message<?= count($messages) === 1 ? "" : "s" ?> received</p>
    </section>

    <section class="admin-wrap">

        <?php if (empty($messages)): ?>

            <div class="empty-state">
                <h3>No messages yet</h3>
                <p>Submissions from the contact form will show up here.</p>
            </div>

        <?php else: ?>

            <div class="message-list">
                <?php foreach ($messages as $msg): ?>
                    <div class="message-card">
                        <div class="message-top">
                            <div class="message-who">
                                <span class="who-avatar"><?= h(strtoupper(mb_substr($msg["name"], 0, 1)) ?: "?") ?></span>
                                <div class="who-meta">
                                    <span class="who-name"><?= h($msg["name"]) ?></span>
                                    <a class="who-email" href="mailto:<?= h($msg["email"]) ?>"><?= h($msg["email"]) ?></a>
                                </div>
                            </div>
                            <span class="message-date"><?= date("M j, Y — g:ia", strtotime($msg["created_at"])) ?></span>
                        </div>

                        <div class="message-subject"><?= h($msg["subject"]) ?></div>

                        <p class="message-body"><?= nl2br(h($msg["message"])) ?></p>

                        <div class="message-actions">
                            <a href="mailto:<?= h($msg["email"]) ?>?subject=Re: <?= rawurlencode($msg["subject"]) ?>" class="btn-reply">Reply by email</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </section>

</body>

</html>