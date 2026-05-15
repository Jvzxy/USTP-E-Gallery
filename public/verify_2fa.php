<?php
session_start();
include("../app/config/config.php");

if (!isset($_SESSION['pending_2fa_user_id'])) {
    header("Location: login");
    exit();
}

$error         = "";
$pendingUserId = $_SESSION['pending_2fa_user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    $enteredCode = $_POST['code'];

    $stmt = $conn->prepare("SELECT id, uuid, username, role, two_factor_code, two_factor_expires FROM user WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $pendingUserId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        $error = "Session error. Please log in again.";
    } elseif ($user['two_factor_code'] !== $enteredCode) {
        $error = "Invalid verification code.";
    } elseif (date("Y-m-d H:i:s") > $user['two_factor_expires']) {
        $error = "Code has expired. Please log in again to generate a new code.";
    } else {
        // Verified — promote session and clean up
        session_regenerate_id(true);
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['userRole'] = $user['role'];
        $_SESSION['authUser'] = [
            'user_id'  => $user['id'],
            'uuid'     => $user['uuid'],
            'username' => $user['username'],
        ];
        unset($_SESSION['pending_2fa_user_id']);

        // Wipe the used code from DB using a prepared statement
        $clean = $conn->prepare("UPDATE user SET two_factor_code = NULL, two_factor_expires = NULL WHERE id = ?");
        $clean->bind_param("i", $user['id']);
        $clean->execute();

        if ($user['role'] === 'admin') {
            $log = $conn->prepare("INSERT INTO activity_logs (admin_id, action) VALUES (?, ?)");
            $action = "Logged into the system via 2FA";
            $log->bind_param("is", $user['id'], $action);
            $log->execute();
            header("Location: admin/index");
        } else {
            $visit = $conn->prepare("INSERT INTO user_visits (user_id) VALUES (?)");
            $visit->bind_param("i", $user['id']);
            $visit->execute();
            header("Location: user/index");
        }
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify 2FA – E-Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/verify_2fa.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="card shadow-sm p-4 p-md-5 verify-card">

        <div class="text-center mb-4">
            <h4 class="fw-bold mb-2 text-dark">Security Verification</h4>
            <p class="text-muted small">We've sent a 6-digit authentication code to your recovery email. Please enter it below.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2 small fw-bold text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <input type="text" name="code" class="form-control form-control-lg code-input"
                       placeholder="000000" maxlength="6" required autocomplete="off" autofocus
                       inputmode="numeric" pattern="\d{6}">
            </div>
            <button type="submit" name="verify" class="btn btn-navy w-100 py-2 rounded-3">Verify Account</button>
        </form>

        <div class="text-center mt-4">
            <a href="login" class="text-decoration-none small text-muted">Cancel and back to login</a>
        </div>

    </div>
</body>
</html>