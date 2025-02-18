<?php
session_start();
include 'dbconnection.php'; // Include your database connection file

// Check if the user is logged in (assuming you store user ID in the session)
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Get the order total from the form (or wherever it comes from)
$order_total = $_POST['order_total']; // Example: from a form submission

// Insert the order into the database
$user_id = $_SESSION['user_id'];
$sql = "INSERT INTO orders (user_id, order_total) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $order_total);

if ($stmt->execute()) {
    // Get the last inserted order ID
    $order_id = $stmt->insert_id;
    $_SESSION['order_id'] = $order_id;
    $_SESSION['order_total'] = $order_total;

    // Redirect to the thank you page
    header('Location: thank_you.php');
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>