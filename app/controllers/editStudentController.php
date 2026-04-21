<?php
session_start();
include("../config/config.php");

header('Content-Type: application/json');

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['userRole'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized action.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;
    $fullName = $_POST['full_name'] ?? '';
    $latinHonor = $_POST['latin_honor'] ?? 'None';

    if (empty($id) || empty($fullName)) {
        echo json_encode(['status' => 'error', 'message' => 'Full Name is required.']);
        exit;
    }

    // Update the database
    $query = "UPDATE `student_profiles` SET `full_name` = ?, `latin_honor` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("ssi", $fullName, $latinHonor, $id);
        
        if ($stmt->execute()) {
            // Log the activity
            $admin_id = $_SESSION['user_id'];
            $action = "Edited student profile: " . $fullName;
            $logStmt = $conn->prepare("INSERT INTO `activity_logs` (`admin_id`, `action`) VALUES (?, ?)");
            $logStmt->bind_param("is", $admin_id, $action);
            $logStmt->execute();
            $logStmt->close();

            echo json_encode(['status' => 'success', 'message' => 'Student updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update database.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query error.']);
    }
}
?>