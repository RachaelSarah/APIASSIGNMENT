<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
include 'templates/header.php';
?>

<h2>Your Cart</h2>
<?php if (empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <div class="row">
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= $item['image_url'] ?>" class="card-img-top" alt="<?= $item['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $item['name'] ?></h5>
                        <p class="card-text">$<?= $item['price'] ?></p>
                        <p class="card-text">Quantity: <?= $item['quantity'] ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>