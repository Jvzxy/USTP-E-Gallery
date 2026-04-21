<?php
session_start();
include("../config/config.php");
header('Content-Type: application/json');

// Shield against database crashes
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Security Check: Only admins can change system settings
if (!isset($_SESSION['user_id']) || $_SESSION['userRole'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized action.']);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Grab the data sent from settings_modal.php
        $sysName = $_POST['system_name'] ?? 'USTP E-Gallery';
        $maintenance = $_POST['maintenance_mode'] ?? '0';

        // FIXED: Using a standard UPDATE statement to prevent database duplicates
        $query = "UPDATE `system_settings` SET `setting_value` = ? WHERE `setting_key` = ?";
        $stmt = $conn->prepare($query);
        
        $settings = [
            'system_name' => $sysName,
            'maintenance_mode' => $maintenance
        ];

        // Loop through and save the settings
        foreach($settings as $key => $val) {
            // Note: bind_param takes value ($val) first, then key ($key) based on the SQL order!
            $stmt->bind_param("ss", $val, $key);
            $stmt->execute();
        }
        $stmt->close();
        
        // Log Activity with dynamic ON/OFF status
        if (isset($_SESSION['user_id'])) {
            $statusText = ($maintenance === '1') ? 'ON' : 'OFF';
            $action = "Updated System Settings (Maintenance: $statusText)";
            
            $logQuery = "INSERT INTO `activity_logs` (`admin_id`, `action`) VALUES (?, ?)";
            $logStmt = $conn->prepare($logQuery);
            $logStmt->bind_param("is", $_SESSION['user_id'], $action);
            $logStmt->execute();
            $logStmt->close();
        }

        echo json_encode(['status' => 'success', 'message' => 'Global settings updated successfully!']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
}
?>