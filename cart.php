<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
include 'templates/header.php';
?>

<!-- Custom CSS for the cart page -->
<style>
    body {
        background-color: #f9f9f9;
    }
    .cart-header {
        text-align: center;
        font-size: 2.5rem;
        color: #ff69b4;
        margin: 20px 0;
    }
    .cart-empty-message {
        text-align: center;
        font-size: 1.2rem;
        color: #555;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-img-top {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        height: 200px;
        object-fit: cover;
    }
    .card-body {
        text-align: center;
        padding: 15px;
    }
    .card-title {
        font-size: 1.25rem;
        color: #333;
        margin-bottom: 10px;
    }
    .card-text {
        font-size: 1rem;
        color: #666;
    }
    .btn-checkout {
        display: block;
        width: 200px;
        margin: 30px auto;
        padding: 10px;
        font-size: 1.1rem;
        background-color: #ff69b4;
        border: none;
        border-radius: 25px;
        color: white;
        text-align: center;
    }
    .btn-checkout:hover {
        background-color: #ff1493;
    }
</style>

<h2 class="cart-header">Your Lip Gloss Cart</h2>
<?php if (empty($_SESSION['cart'])): ?>
    <p class="cart-empty-message">Your cart is empty. Add some lip gloss to glam up!</p>
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
    <a href="checkout.php" class="btn btn-checkout">Proceed to Checkout</a>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>