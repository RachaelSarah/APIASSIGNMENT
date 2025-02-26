<?php
header('Content-Type: application/json');
include '../includes/db.php';

$stmt = $conn->query("
    SELECT 
        payment_status AS status,
        COUNT(*) AS total_orders
    FROM orders
    GROUP BY payment_status
");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
?>