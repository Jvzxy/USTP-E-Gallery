<?php
session_start();
include("../config/config.php");

// Security Check: Only admins can export data
if (!isset($_SESSION['user_id']) || $_SESSION['userRole'] !== 'admin') {
    die("Unauthorized access.");
}

$year = $_GET['year'] ?? 'all';

// Set the downloaded file name dynamically based on the year
$dateStr = date('Y-m-d');
$filename = ($year === 'all') ? "all_students_export_{$dateStr}.csv" : "class_of_{$year}_export_{$dateStr}.csv";

// Tell the browser to expect a CSV file download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open the output stream
$output = fopen('php://output', 'w');

// Write the column headers for the spreadsheet
fputcsv($output, ['Full Name', 'Department', 'Program', 'Section', 'Latin Honor', 'Class Year', 'Quote', 'Upload Date']);

// Build the database query
$query = "SELECT sp.full_name, d.name as dept_name, p.name as prog_name, s.name as sec_name, sp.latin_honor, sp.class_year, sp.quote, sp.uploaded_at
          FROM student_profiles sp
          LEFT JOIN departments d ON sp.department_id = d.id
          LEFT JOIN programs p ON sp.program_id = p.id
          LEFT JOIN sections s ON sp.section_id = s.id";

// Filter by year if a specific year was chosen
if ($year !== 'all') {
    $query .= " WHERE sp.class_year = ? ORDER BY sp.full_name ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $year);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query .= " ORDER BY sp.class_year DESC, sp.full_name ASC";
    $result = $conn->query($query);
}

// Loop through the data and write it to the CSV
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['full_name'],
            $row['dept_name'] ?? 'N/A',
            $row['prog_name'] ?? 'N/A',
            $row['sec_name'] ?? 'N/A',
            $row['latin_honor'] ?? 'None',
            $row['class_year'],
            $row['quote'],
            $row['uploaded_at']
        ]);
    }
    
    // Log the export activity
    $action = ($year === 'all') ? "Exported all student records to CSV" : "Exported Class of $year records to CSV";
    $logStmt = $conn->prepare("INSERT INTO `activity_logs` (`admin_id`, `action`) VALUES (?, ?)");
    $logStmt->bind_param("is", $_SESSION['user_id'], $action);
    $logStmt->execute();
    $logStmt->close();
    
} else {
    // If no students exist, write a blank row
    fputcsv($output, ['No records found for this selection.']);
}

fclose($output);
exit();
?>