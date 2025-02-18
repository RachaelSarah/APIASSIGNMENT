<?php
session_start();
include('dbconnection.php'); // Establish PDO connection as $conn

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Retrieve the most recent order placed by the user
    $stmt = $conn->prepare("
        SELECT o.id AS order_id, o.total_amount, o.shipping_address, o.payment_status, o.created_at
        FROM orders o
        WHERE o.user_id = :user_id
        ORDER BY o.created_at DESC
        LIMIT 1
    ");
    $stmt->execute([':user_id' => $user_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        $_SESSION['error'] = "No recent order found.";
        header("Location: cart.php");
        exit();
    }

    // Retrieve the items in the order
    $order_id = $order['order_id'];
    $stmt = $conn->prepare("
        SELECT oi.product_id, oi.quantity, oi.price, p.name AS product_name
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = :order_id
    ");
    $stmt->execute([':order_id' => $order_id]);
    $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred while fetching your order details.";
    header("Location: cart.php");
    exit();
}
?>

<?php include 'templates/header.php'; ?>
<h2>Order Confirmation</h2>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php 
            echo htmlspecialchars($_SESSION['success']);
            unset($_SESSION['success']); // Clear success message after displaying
        ?>
    </div>
<?php endif; ?>

<div style="background: #f8f9fa; padding: 20px; border-radius: 10px; max-width: 600px; margin: 0 auto;">
    <h3>Order Summary</h3>
    <p><strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']); ?></p>
    <p><strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2); ?></p>
    <p><strong>Shipping Address:</strong> <?= htmlspecialchars($order['shipping_address']); ?></p>
    <p><strong>Payment Status:</strong> <?= htmlspecialchars($order['payment_status']); ?></p>
    <p><strong>Order Date:</strong> <?= date('F j, Y, g:i a', strtotime($order['created_at'])); ?></p>

    <h4>Order Items</h4>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']); ?></td>
                    <td><?= htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?= number_format($item['price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p style="margin-top: 20px;">Thank you for your order! Your items will be shipped to the provided address shortly.</p>

    <a href="index.php" class="btn btn-primary">Return to Home</a>
    <a href="order_history.php" class="btn btn-secondary">View Order History</a>
</div>

<?php include 'templates/footer.php'; ?>