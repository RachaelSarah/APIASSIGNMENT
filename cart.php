<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the product is already in the cart
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_item) {
        // Update quantity
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
    } else {
        // Add to cart
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $stmt->execute([$user_id, $product_id]);
    }

    header("Location: view_cart.php");
    exit;
}
?>
