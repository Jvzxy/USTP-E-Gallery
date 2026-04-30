<?php
session_start();
include("../config/config.php");
header('Content-Type: application/json');

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'monthly';

$labels = [];
$dataMap = [];

if ($filter === 'daily') {
    // 1. Pre-fill the last 7 days with 0 visits
    for ($i = 6; $i >= 0; $i--) {
        $dateStr = date('Y-m-d', strtotime("-$i days"));
        $dayLabel = date('D', strtotime("-$i days")); // e.g., 'Mon', 'Tue'
        $labels[] = $dayLabel;
        $dataMap[$dateStr] = 0; 
    }

    $query = "SELECT DATE(v.visit_time) as vdate, COUNT(v.id) as count 
              FROM user_visits v
              JOIN user u ON v.user_id = u.id
              WHERE v.visit_time >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) 
              AND u.role = 'user'
              GROUP BY DATE(v.visit_time)";

    if (isset($conn)) {
        $result = $conn->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Fill in the actual data for the specific date
                if (isset($dataMap[$row['vdate']])) {
                    $dataMap[$row['vdate']] = (int)$row['count'];
                }
            }
        }
    }
              
} elseif ($filter === 'weekly') {
    // 1. Pre-fill the 5 possible weeks of the CURRENT month
    $labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
    $dataMap = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

    // FIXED: Now we strictly filter by the CURRENT month, eliminating duplicate week overlaps!
    $query = "SELECT CEIL(DAY(v.visit_time)/7) as week_num, COUNT(v.id) as count 
              FROM user_visits v
              JOIN user u ON v.user_id = u.id
              WHERE MONTH(v.visit_time) = MONTH(CURDATE()) 
              AND YEAR(v.visit_time) = YEAR(CURDATE())
              AND u.role = 'user'
              GROUP BY week_num";

    if (isset($conn)) {
        $result = $conn->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $weekIndex = (int)$row['week_num'];
                if (isset($dataMap[$weekIndex])) {
                    $dataMap[$weekIndex] = (int)$row['count'];
                }
            }
        }
    }
              
} else {
    // 1. Pre-fill all 12 months with 0 visits
    $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $dataMap = [1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0, 8=>0, 9=>0, 10=>0, 11=>0, 12=>0];

    $query = "SELECT MONTH(v.visit_time) as month_num, COUNT(v.id) as count 
              FROM user_visits v
              JOIN user u ON v.user_id = u.id
              WHERE YEAR(v.visit_time) = YEAR(CURDATE()) 
              AND u.role = 'user'
              GROUP BY MONTH(v.visit_time)";

    if (isset($conn)) {
        $result = $conn->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $monthIndex = (int)$row['month_num'];
                if (isset($dataMap[$monthIndex])) {
                    $dataMap[$monthIndex] = (int)$row['count'];
                }
            }
        }
    }
}

// Convert our mapped data array into a simple, ordered list of numbers for Chart.js
$data = array_values($dataMap);

echo json_encode(['labels' => $labels, 'data' => $data]);
?>