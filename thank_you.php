<?php
session_start();
include 'templates/header.php';

// Assuming you have stored order details in the session
$order_id = $_SESSION['order_id'] ?? 'N/A';
$order_total = $_SESSION['order_total'] ?? '0.00';
?>

<div style="max-width: 600px; margin: 50px auto; padding: 20px; text-align: center; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <h2 style="color: #ff69b4; font-size: 2.5em; margin-bottom: 20px;">Thank You!</h2>
    <p style="font-size: 1.2em; color: #333; margin-bottom: 20px;">Your order has been placed successfully.</p>
    
    <div style="background-color: #fff; padding: 15px; border-radius: 5px; margin-bottom: 20px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 1.5em; margin-bottom: 10px; color: #333;">Order Details</h3>
        <p style="font-size: 1.1em; color: #555; margin: 5px 0;"><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
        <p style="font-size: 1.1em; color: #555; margin: 5px 0;"><strong>Total Amount:</strong> $<?php echo htmlspecialchars($order_total); ?></p>
    </div>

    <p style="font-size: 1.2em; color: #333; margin-bottom: 20px;">We have sent a confirmation email to your registered email address. If you have any questions, feel free to <a href="contact.php" style="color: #ff69b4; text-decoration: none;">contact us</a>.</p>

    <a href="index.php" style="display: inline-block; padding: 10px 20px; background-color: #ff69b4; color: #fff; text-decoration: none; border-radius: 5px; font-size: 1.1em; transition: background-color 0.3s ease;">Return to Home</a>
</div>

<?php include 'templates/footer.php'; ?>