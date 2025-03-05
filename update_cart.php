<?php
//starting session
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    try {
        $sql = "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: cart.php');
        exit();
    } catch (PDOException $e) {
        echo "Error updating cart: " . $e->getMessage();
    }
}
?>