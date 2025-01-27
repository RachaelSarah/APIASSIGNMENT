<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Fetch cart items
$stmt = $pdo->prepare("
    SELECT cart.id AS cart_id, products.name, products.price, cart.quantity, products.image_url
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<?php include 'templates/header.php'; ?>
<h2>Your Cart</h2>

<?php if (count($cart_items) > 0): ?>
<table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cart_items as $item): ?>
        <tr>
            <td><img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>" width="50"></td>
            <td><?= $item['name'] ?></td>
            <td>$<?= $item['price'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>$<?= $item['price'] * $item['quantity'] ?></td>
            <td>
                <form action="remove_from_cart.php" method="POST" style="display:inline;">
                    <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h4>Total: $<?= $total ?></h4>
<a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>

<?php else: ?>
<p>Your cart is empty.</p>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>
