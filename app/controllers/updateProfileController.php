<?php
session_start();
include("../config/config.php");

header('Content-Type: application/json');

// Security check: ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit;
}

$userId = $_SESSION['user_id'];
$username = $_POST['username'] ?? '';
$email = $_POST['recovery_email'] ?? '';
$password = $_POST['password'] ?? '';
$twoFactor = $_POST['two_factor_enabled'] ?? '0';

if (empty($username)) {
    echo json_encode(['status' => 'error', 'message' => 'Username is required.']);
    exit;
}

try {
    if (!empty($password)) {
        // User typed a new password, so we hash it and update everything
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE `user` SET `username` = ?, `recovery_email` = ?, `password` = ?, `two_factor_enabled` = ? WHERE `id` = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $username, $email, $hashedPassword, $twoFactor, $userId);
    } else {
        // Password field was left blank, update everything EXCEPT password
        $query = "UPDATE `user` SET `username` = ?, `recovery_email` = ?, `two_factor_enabled` = ? WHERE `id` = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssii", $username, $email, $twoFactor, $userId);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update database.']);
    }
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>