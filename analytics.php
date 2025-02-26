<?php
include('dbconnection.php'); // Ensure this matches your existing connection file

header('Content-Type: application/json');

// Fetch total sales, total orders, and average order value
$salesQuery = "SELECT COUNT(order_id) AS total_orders, SUM(total_amount) AS total_revenue, AVG(total_amount) AS avg_order_value FROM orders";
$salesResult = $conn->query($salesQuery);
$salesData = $salesResult->fetch(PDO::FETCH_ASSOC);

// Fetch top 5 best-selling products
$topProductsQuery = "SELECT p.name, SUM(oi.quantity) AS total_sold 
                    FROM order_items oi
                    JOIN products p ON oi.product_id = p.product_id
                    GROUP BY p.name 
                    ORDER BY total_sold DESC 
                    LIMIT 5";
$topProductsResult = $conn->query($topProductsQuery);
$topProducts = $topProductsResult->fetchAll(PDO::FETCH_ASSOC);

// Fetch monthly sales trend
$monthlySalesQuery = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, SUM(total_amount) AS revenue 
                      FROM orders 
                      GROUP BY month 
                      ORDER BY month ASC";
$monthlySalesResult = $conn->query($monthlySalesQuery);
$monthlySales = $monthlySalesResult->fetchAll(PDO::FETCH_ASSOC);

// Fetch order status breakdown
$statusQuery = "SELECT payment_status, COUNT(order_id) AS count FROM orders GROUP BY payment_status";
$statusResult = $conn->query($statusQuery);
$orderStatus = $statusResult->fetchAll(PDO::FETCH_ASSOC);

// Return all data as JSON
echo json_encode([
    "sales" => $salesData,
    "top_products" => $topProducts,
    "monthly_sales" => $monthlySales,
    "order_status" => $orderStatus
]);
?>
