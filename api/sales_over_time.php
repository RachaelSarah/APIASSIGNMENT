<?php
header('Content-Type: application/json');
//Include database connection
include '../includes/db.php';

$stmt = $conn->query("
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') AS month,
        SUM(total_amount) AS total_sales
    FROM orders
    GROUP BY month
    ORDER BY created_at ASC
");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
?>