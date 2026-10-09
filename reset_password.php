<?php
require_once 'db.php'; // adjust path if your db.php lives elsewhere, e.g. 'includes/db.php'

$message = '';
$isError = false;
$showForm = true;

// Token can arrive via the emailed link (GET) or via the form resubmission (POST).
$rawToken = $_POST['token'] ?? $_GET['token'] ?? '';

if ($rawToken === '') {
    $message = 'Missing or invalid reset link.';
    $isError = true;
    $showForm = false;
} else {

    $tokenHash = hash('sha256', $rawToken);

    $stmt = $conn->prepare(
        'SELECT id, reset_expires_at FROM users WHERE reset_token_hash = ? LIMIT 1'
    );
    $stmt->bind_param('s', $tokenHash);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user || strtotime($user['reset_expires_at']) < time()) {
        $message = 'This reset link is invalid or has expired. Please request a new one.';
        $isError = true;
        $showForm = false;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {

        $password = $_POST['password'];
        $confirm  = $_POST['confirm_password'] ?? '';

        if (strlen($password) < 8) {
            $message = 'Password must be at least 8 characters long.';
            $isError = true;
        } elseif ($password !== $confirm) {
            $message = 'Passwords do not match.';
            $isError = true;
        } else {
            $newHash = password_hash($password, PASSWORD_DEFAULT);

            // Update password and invalidate the token so it can't be reused.
            $update = $conn->prepare(
                'UPDATE users SET password = ? WHERE id = ?'
            );
            $update->bind_param('si', $newHash, $user['id']);
            $update->execute();
            $update->close();

            $message = 'Your password has been updated. You can now log in.';
            $showForm = false;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | FoodFusion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="modal-open">

    <div id="modalBackdrop" class="modal-backdrop is-open">

        <section id="resetForm" class="auth-modal is-active" role="dialog" aria-modal="true">

            <button class="modal-close" type="button" aria-label="Close" onclick="window.location.href='index.php'">×</button>
            <div class="auth-kicker">Locked out?</div>
            <h2>Set a new password</h2>
            <p>Almost there — choose something you'll remember this time.</p>

            <?php if ($message): ?>
                <div class="auth-alert<?php echo $isError ? ' is-error' : ''; ?>" role="alert">
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <?php if ($showForm): ?>
                <form method="POST" action="reset_password.php" class="auth-form">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($rawToken, ENT_QUOTES, 'UTF-8'); ?>">

                    <input type="password" name="password" placeholder="New password" minlength="8" required>
                    <input type="password" name="confirm_password" placeholder="Confirm new password" minlength="8" required>

                    <button type="submit">Reset my password </button>
                </form>
            <?php endif; ?>

            <p class="auth-switch">
                <?php if (!$showForm): ?>
                    <a href="index.php">Back to FoodFusion</a>
                <?php else: ?>
                    Remembered it after all? <a href="index.php">Back to log in</a>
                <?php endif; ?>
            </p>
        </section>

    </div>

</body>

</html>