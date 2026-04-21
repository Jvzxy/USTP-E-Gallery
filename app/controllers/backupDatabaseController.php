<?php
session_start();
include("../config/config.php");

// Security Check: Only admins can trigger a backup
if (!isset($_SESSION['user_id']) || $_SESSION['userRole'] !== 'admin') {
    die("Unauthorized access.");
}

// 1. Get all tables in the database
$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

$sqlScript = "-- ---------------------------------------------------------\n";
$sqlScript .= "-- USTP E-Gallery Database Backup\n";
$sqlScript .= "-- Generated: " . date('F j, Y, g:i a') . "\n";
$sqlScript .= "-- ---------------------------------------------------------\n\n";
$sqlScript .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

// 2. Loop through every table to get its structure and data
foreach ($tables as $table) {
    
    // Add the "CREATE TABLE" structure
    $sqlScript .= "-- Structure for table `$table`\n";
    $sqlScript .= "DROP TABLE IF EXISTS `$table`;\n";
    $createTableResult = $conn->query("SHOW CREATE TABLE `$table`");
    $createTableRow = $createTableResult->fetch_row();
    $sqlScript .= $createTableRow[1] . ";\n\n";

    // Add the "INSERT INTO" data rows
    $dataResult = $conn->query("SELECT * FROM `$table`");
    $numColumns = $dataResult->field_count;

    if ($dataResult->num_rows > 0) {
        $sqlScript .= "-- Data for table `$table`\n";
        while ($row = $dataResult->fetch_row()) {
            $sqlScript .= "INSERT INTO `$table` VALUES(";
            for ($j = 0; $j < $numColumns; $j++) {
                if (isset($row[$j])) {
                    // Clean the data to prevent SQL syntax breaks
                    $cleanData = $conn->real_escape_string($row[$j]);
                    $sqlScript .= '"' . $cleanData . '"';
                } else {
                    $sqlScript .= 'NULL';
                }
                if ($j < ($numColumns - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
        $sqlScript .= "\n";
    }
}

$sqlScript .= "SET FOREIGN_KEY_CHECKS=1;\n";

// 3. Log the Activity BEFORE sending headers
$admin_id = $_SESSION['user_id'];
$action = "Generated full database SQL backup";
$logStmt = $conn->prepare("INSERT INTO `activity_logs` (`admin_id`, `action`) VALUES (?, ?)");
$logStmt->bind_param("is", $admin_id, $action);
$logStmt->execute();
$logStmt->close();

// 4. Force the browser to download the text as a .sql file
$filename = 'ustp_egallery_backup_' . date('Y-m-d_H-i') . '.sql';

header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: no-cache, no-store, must-revalidate');

echo $sqlScript;
exit();
?>