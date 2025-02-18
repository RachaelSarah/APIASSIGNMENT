<?php
session_start();

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required POST parameters exist
    if (isset($_POST['product_id'], $_POST['name'], $_POST['price'])) {
        $productId = $_POST['product_id'];
        $productName = $_POST['name'];
        $productPrice = $_POST['price'];

        // Initialize the cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1; // Increment quantity
        } else {
            // Add new product to the cart
            $_SESSION['cart'][$productId] = [
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 1
            ];
        }

        // Redirect to cart.php after adding the product
        header("Location: cart.php?success=1");
        exit();
    } else {
        // Handle missing data error
        header("Location: shop.php?error=missing_data");
        exit();
    }
}
?>
