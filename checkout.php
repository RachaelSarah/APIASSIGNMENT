<?php
session_start();
include 'templates/header.php';
?>

<h2>Checkout</h2>
<?php if (empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <form action="process_checkout.php" method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="address">Shipping Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>