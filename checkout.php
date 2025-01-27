<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Fetch cart items and calculate total
$stmt = $pdo->prepare("
    SELECT cart.quantity, products.price
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Clear the cart
$stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);

?>

<?php include 'templates/header.php'; ?>
<h2>Checkout</h2>
<p>Thank you for your purchase! Your total is $<?= $total ?>.</p>
<?php include 'templates/footer.php'; ?>
