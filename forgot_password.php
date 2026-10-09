<?php
require_once 'db.php'; // adjust path if your db.php lives elsewhere, e.g. 'includes/db.php'

$isAjax = isset($_POST['ajax']) && $_POST['ajax'] === '1';
$message = '';
$success = false;
$redirectUrl = null; // set only if the email matches a real account

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } else {

        // Look up the user, but never reveal whether the email exists.
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {
            // Generate a cryptographically secure token.
            $rawToken = bin2hex(random_bytes(32));       // sent to the user
            $tokenHash = hash('sha256', $rawToken);      // stored in the DB

            $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

            $update = $conn->prepare(
                'UPDATE users SET reset_token_hash = ?, reset_expires_at = ? WHERE id = ?'
            );
            $update->bind_param('ssi', $tokenHash, $expiresAt, $user['id']);
            $update->execute();
            $update->close();

            // DEMO ONLY: hand the link straight back to the browser instead of
            // requiring the user to open their email. Do NOT ship this to a
            // real, public site — it lets anyone reset any account without
            // proving they own that email address.
            $redirectUrl = 'reset_password.php?token=' . urlencode($rawToken);
        }

        // Same message whether or not the email was found — prevents
        // attackers from using this form to discover registered emails.
        $message = 'If that email is registered, a reset link has been sent.';
        $success = true;
    }
}

// AJAX callers (the modal form) get JSON back and nothing else.
if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message !== '' ? $message : 'Please enter a valid email address.',
        'redirect' => $redirectUrl, // null if email wasn't found
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>

<body>
    <!--
    This plain page is a no-JS fallback only. Normal users hit this
    functionality through the "Forgot password?" link in the login
    modal, which posts here with ajax=1 and never lands on this page.
  -->
    <h1>Forgot Password</h1>

    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form method="POST" action="forgot_password.php">
        <label for="email">Email address</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Reset Password</button>
    </form>
</body>

</html>