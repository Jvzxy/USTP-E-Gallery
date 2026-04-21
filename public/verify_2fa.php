<?php
session_start();
include("../app/config/config.php");

// If they shouldn't be here, kick them back to login
if (!isset($_SESSION['pending_2fa_user_id'])) {
    header("Location: login.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify'])) {
    $enteredCode = $_POST['code'];
    $pendingUserId = $_SESSION['pending_2fa_user_id'];

    $query = "SELECT `id`, `uuid`, `username`, `role`, `two_factor_code`, `two_factor_expires` FROM `user` WHERE `id` = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pendingUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $currentTime = date("Y-m-d H:i:s");

        // Check if code matches
        if ($user['two_factor_code'] === $enteredCode) {
            
            // Check if code has expired
            if ($currentTime <= $user['two_factor_expires']) {
                
                // 100% Verified! Set up the real sessions
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['userRole'] = $user['role'];
                $_SESSION['authUser'] = [
                    'user_id' => $user['id'],
                    'uuid' => $user['uuid'],
                    'username' => $user['username']
                ];

                // Clean up the used code from DB and clear pending session
                unset($_SESSION['pending_2fa_user_id']);
                $conn->query("UPDATE `user` SET `two_factor_code` = NULL, `two_factor_expires` = NULL WHERE `id` = " . $user['id']);

                // Route them to their dashboard
                if ($user['role'] === 'admin') {
                    $action = "Logged into the system via 2FA";
                    $logStmt = $conn->prepare("INSERT INTO `activity_logs` (`admin_id`, `action`) VALUES (?, ?)");
                    $logStmt->bind_param("is", $user['id'], $action);
                    $logStmt->execute();
                    
                    header("Location: admin/index.php");
                    exit();
                } else {
                    $visitStmt = $conn->prepare("INSERT INTO `user_visits` (`user_id`) VALUES (?)");
                    $visitStmt->bind_param("i", $user['id']);
                    $visitStmt->execute();
                    
                    header("Location: user/index.php");
                    exit();
                }
            } else {
                $error = "Code has expired. Please log in again to generate a new code.";
            }
        } else {
            $error = "Invalid verification code.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify 2FA - USTP E-Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .verify-card { max-width: 400px; width: 100%; border-radius: 12px; border: none; }
        .code-input { letter-spacing: 8px; font-size: 1.5rem; text-align: center; border: 2px solid #e2e8f0; font-weight: bold; }
        .code-input:focus { border-color: #1A1851; box-shadow: none; }
        .btn-navy { background-color: #1A1851; color: white; font-weight: 800; border: none; }
        .btn-navy:hover { background-color: #2a2775; color: white; }
    </style>
</head>
<body>
    <div class="card shadow-sm p-4 p-md-5 verify-card">
        <div class="text-center mb-4">
            <h4 class="fw-bold mb-2 text-dark">Security Verification</h4>
            <p class="text-muted small">We've sent a 6-digit authentication code to your recovery email. Please enter it below.</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger py-2 small fw-bold text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <input type="text" name="code" class="form-control form-control-lg code-input" placeholder="000000" maxlength="6" required autocomplete="off" autofocus>
            </div>
            <button type="submit" name="verify" class="btn btn-navy w-100 py-2 rounded-3">Verify Account</button>
        </form>
        
        <div class="text-center mt-4">
            <a href="login.php" class="text-decoration-none small text-muted">Cancel and back to login</a>
        </div>
    </div>
</body>
</html>