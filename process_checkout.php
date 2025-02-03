<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the order (e.g., save to database, send email, etc.)
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Clear the cart
    unset($_SESSION['cart']);

    // Redirect to a thank you page
    header('Location: thank_you.php');
    exit;
}
?>