<?php
session_start();

// Handle product removal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_product_id'])) {
        $removeId = $_POST['remove_product_id'];
        if (isset($_SESSION['cart'][$removeId])) {
            unset($_SESSION['cart'][$removeId]); // Remove single item
        }
        header("Location: cart.php?removed=1");
        exit();
    }

    // Handle empty cart action
    if (isset($_POST['empty_cart'])) {
        $_SESSION['cart'] = []; // Clear the cart
        header("Location: cart.php?emptied=1");
        exit();
    }
}
?>

<?php include 'templates/header.php'; ?>

<!-- Custom Styling -->
<style>
    body {
        background-color: #E3F2FD; /* Light blue background */
        font-family: Arial, sans-serif;
    }
    .container {
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }
    .table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
    }
    .table th {
        background: #ff66b2; /* Pink header */
        color: white;
        text-align: center;
    }
    .table td {
        text-align: center;
    }
    .alert {
        border-radius: 8px;
        text-align: center;
        font-weight: bold;
    }
    .btn-custom {
        background-color: #ff66b2; /* Pink buttons */
        color: white;
        border: none;
    }
    .btn-custom:hover {
        background-color: #e65c99;
    }
    .empty-cart {
        text-align: center;
        margin-top: 50px;
    }
</style>

<div class="container">
    <h2 class="text-center">🛒 Your Shopping Cart</h2>

    <!-- Display Success Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Product added to cart successfully!</div>
    <?php endif; ?>

    <?php if (isset($_GET['removed'])): ?>
        <div class="alert alert-warning">Product removed from cart!</div>
    <?php endif; ?>

    <?php if (isset($_GET['emptied'])): ?>
        <div class="alert alert-danger">All products removed from cart!</div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $productId => $item): 
                    $productName = isset($item['name']) ? htmlspecialchars($item['name'], ENT_QUOTES) : "Unknown Product";
                    $productPrice = isset($item['price']) ? number_format($item['price'], 2) : "0.00";
                    $productQuantity = isset($item['quantity']) ? $item['quantity'] : 1;
                    
                    $itemTotal = $productPrice * $productQuantity;
                    $total += $itemTotal;
                ?>
                    <tr>
                        <td><?= $productName ?></td>
                        <td>$<?= $productPrice ?></td>
                        <td><?= $productQuantity ?></td>
                        <td>$<?= number_format($itemTotal, 2) ?></td>
                        <td>
                            <form action="cart.php" method="POST" style="display:inline;">
                                <input type="hidden" name="remove_product_id" value="<?= $productId ?>">
                                <button type="submit" class="btn btn-danger btn-sm">❌ Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Grand Total</th>
                    <th>$<?= number_format($total, 2) ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <form action="cart.php" method="POST">
                <button type="submit" name="empty_cart" class="btn btn-warning">🗑 Empty Cart</button>
            </form>
            <a href="shop.php" class="btn btn-secondary">🔙 Continue Shopping</a>
            <a href="checkout.php" class="btn btn-custom">💳 Proceed to Checkout</a>
        </div>

    <?php else: ?>
        <!-- Empty Cart Message -->
        <div class="empty-cart">
            <h3>Your cart is empty 😢</h3>
            <p>Start adding some products now!</p>
            <a href="shop.php" class="btn btn-custom">🛍 Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>
