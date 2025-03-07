<?php
session_start();
include('dbconnection.php'); // Establish PDO connection as $conn

// Ensure admin is logged in.
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null; // Updated to product_id

if (!$product_id) {
    header("Location: admin_dashboard.php");
    exit();
}

try {
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :product_id"); // Updated to product_id
    $stmt->execute([':product_id' => $product_id]);
    header("Location: admin_dashboard.php");
    exit();
} catch (Exception $e) {
    error_log("Delete error: " . $e->getMessage());
    $_SESSION['error'] = "Failed to delete product.";
    header("Location: admin_dashboard.php");
    exit();
}