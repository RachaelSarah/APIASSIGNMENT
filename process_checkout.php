<?php
session_start();
include('dbconnection.php'); // Establish PDO connection as $conn

// Debugging: Check if cart is set
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = "Your cart is empty.";
    header("Location: cart.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the address input.
    if (empty($_POST['address'])) {
        $_SESSION['error'] = "Shipping address is required.";
        header("Location: cart.php");
        exit();
    }

    $address = trim($_POST['address']);

    try {
        // Start a transaction
        $conn->beginTransaction();

        // Calculate total order amount
        $total_amount = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $_SESSION['cart']));

        // Insert order into the database
        $stmt = $conn->prepare("
            INSERT INTO orders (id, total_amount, shipping_address, payment_status) 
            VALUES (:id, :total_amount, :address, 'Pending')
        ");
        $stmt->execute([
            ':id' => null, // Use NULL for guest orders
            ':total_amount' => $total_amount,
            ':address' => $address
        ]);
        $order_id = $conn->lastInsertId();

        // Store order details in the session
        $_SESSION['order_id'] = $order_id;
        $_SESSION['total_amount'] = $total_amount;
        $_SESSION['shipping_address'] = $address;

        // Insert order items
        $stmt = $conn->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price) 
            VALUES (:order_id, :product_id, :quantity, :price)
        ");
        foreach ($_SESSION['cart'] as $product_id => $item) {
            if (!is_numeric($product_id) || !is_numeric($item['quantity']) || $item['quantity'] <= 0) {
                throw new Exception("Invalid cart data.");
            }
            $stmt->execute([
                ':order_id' => $order_id,
                ':product_id' => $product_id,
                ':quantity' => $item['quantity'],
                ':price' => $item['price']
            ]);
        }

        // Commit the transaction
        $conn->commit();

        // Clear the cart after successful checkout
        unset($_SESSION['cart']);

        // Log successful checkout
        error_log("Guest order placed successfully.");

        // Redirect to the thank you page
        $_SESSION['success'] = "Thank you for your order!";
        header("Location: thank_you.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollBack();

        // Log the error message
        error_log("Checkout error: " . $e->getMessage());

        // Provide feedback to the user
        $_SESSION['error'] = "Checkout failed. Please try again.";
        header("Location: cart.php");
        exit();
    }
}
?>