<?php
session_start();
include("../config/config.php");
header('Content-Type: application/json');

// Security Check: Only admins can upload logos
if (!isset($_SESSION['user_id']) || $_SESSION['userRole'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized action.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo'])) {
    $file = $_FILES['logo'];
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'File upload error code: ' . $file['error']]);
        exit;
    }

    $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($ext, $allowedExts)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file format. Only JPG, PNG, and WEBP are allowed.']);
        exit;
    }

    $uploadDir = '../../public/user/assets/Img/Logo/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $newFileName = 'custom_logo_' . time() . '.' . $ext;
    $targetPath = $uploadDir . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $dbPath = 'user/assets/Img/Logo/' . $newFileName;

        // FIXED: Explicitly check if it exists to prevent database duplicates!
        $check = $conn->query("SELECT id FROM system_settings WHERE setting_key = 'school_logo'");
        if ($check && $check->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_key = 'school_logo'");
        } else {
            $stmt = $conn->prepare("INSERT INTO system_settings (setting_key, setting_value) VALUES ('school_logo', ?)");
        }
        
        $stmt->bind_param("s", $dbPath);
        $stmt->execute();
        $stmt->close();

        $admin_id = $_SESSION['user_id'];
        $logStmt = $conn->prepare("INSERT INTO activity_logs (admin_id, action) VALUES (?, 'Updated School Logo')");
        $logStmt->bind_param("i", $admin_id);
        $logStmt->execute();
        $logStmt->close();

        echo json_encode(['status' => 'success', 'message' => 'Logo updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save the uploaded file to the server.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No file received.']);
}
?>