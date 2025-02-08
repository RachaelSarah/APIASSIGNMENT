<?php
session_start();
include 'templates/header.php';
?>

<!-- Custom CSS for the checkout page -->
<style>
    body {
        background-color: #f9f9f9;
        font-family: 'Arial', sans-serif;
    }
    .checkout-header {
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
    .checkout-form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        font-size: 1rem;
        color: #333;
        font-weight: bold;
    }
    .form-control {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        font-size: 1rem;
        color: #555;
    }
    .form-control:focus {
        border-color: #ff69b4;
        box-shadow: 0 0 5px rgba(255, 105, 180, 0.5);
    }
    .btn-place-order {
        display: block;
        width: 100%;
        padding: 12px;
        font-size: 1.1rem;
        background-color: #ff69b4;
        border: none;
        border-radius: 25px;
        color: white;
        text-align: center;
        cursor: pointer;
    }
    .btn-place-order:hover {
        background-color: #ff1493;
    }
</style>

<h2 class="checkout-header">Checkout</h2>
<?php if (empty($_SESSION['cart'])): ?>
    <p class="cart-empty-message">Your cart is empty. Add some lip gloss to glam up!</p>
<?php else: ?>
    <div class="checkout-form">
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
                <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-place-order">Place Order</button>
        </form>
    </div>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>