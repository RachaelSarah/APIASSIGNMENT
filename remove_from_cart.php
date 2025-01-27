<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];

    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$cart_id]);

    header("Location: view_cart.php");
    exit;
}
?>
