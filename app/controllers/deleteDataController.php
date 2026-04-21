<?php
session_start();
include("../config/config.php"); 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? ''; 
    $id = $_POST['id'] ?? 0;
    $itemName = $_POST['name'] ?? 'Unknown Item'; 

    if (empty($type) || empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing information for deletion.']);
        exit();
    }

    $query = "";

    // --- 1. DETERMINE WHAT WE ARE DELETING ---
    if ($type === 'department') {
        // Prevent deleting if it has active programs
        $chk1 = $conn->prepare("SELECT id FROM programs WHERE department_id = ? LIMIT 1");
        $chk1->bind_param("i", $id); 
        $chk1->execute();
        if ($chk1->get_result()->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Cannot delete: There are Programs attached to this Department.']);
            exit();
        }
        $query = "DELETE FROM departments WHERE id = ?";
        
    } elseif ($type === 'program') {
        $query = "DELETE FROM programs WHERE id = ?";
        
    } elseif ($type === 'class_year') {
        $query = "DELETE FROM class_years WHERE id = ?";
        
    } elseif ($type === 'student') {
        // NEW: When deleting a student, physically delete their image from the server first!
        $imgStmt = $conn->prepare("SELECT photo_path FROM student_profiles WHERE id = ?");
        $imgStmt->bind_param("i", $id);
        $imgStmt->execute();
        $imgRes = $imgStmt->get_result();
        
        if ($row = $imgRes->fetch_assoc()) {
            // Path relative to where this controller is located
            $filePath = "../../public/admin/" . $row['photo_path'];
            if (!empty($row['photo_path']) && file_exists($filePath)) {
                unlink($filePath); // This permanently deletes the image file
            }
        }
        $imgStmt->close();
        
        $query = "DELETE FROM student_profiles WHERE id = ?";
        
    } else {
       
        echo json_encode(['status' => 'error', 'message' => 'Invalid deletion type.']);
        exit();
    }


    // --- 2. EXECUTE THE DELETION ---
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            
            // --- 3. LOG THE ACTIVITY ---
            if (isset($_SESSION['user_id'])) {
                $admin_id = $_SESSION['user_id'];
                
                // Format string nicely (e.g. "Deleted Student: John Doe" or "Deleted Class_year: 2029")
                $itemTypeStr = str_replace('_', ' ', ucfirst($type)); 
                $action = "Deleted $itemTypeStr: $itemName";
                
                $logQuery = "INSERT INTO `activity_logs` (`admin_id`, `action`) VALUES (?, ?)";
                $logStmt = $conn->prepare($logQuery);
                if ($logStmt) {
                    $logStmt->bind_param("is", $admin_id, $action);
                    $logStmt->execute();
                    $logStmt->close();
                }
            }

            echo json_encode(['status' => 'success', 'message' => ucfirst(str_replace('_', ' ', $type)) . ' deleted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete from database.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query error.']);
    }
}
?>