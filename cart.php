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

<h2>Your Shopping Cart</h2>

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
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
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
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
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

    <!-- "Empty Cart" Form -->
    <form action="cart.php" method="POST">
        <button type="submit" name="empty_cart" class="btn btn-warning">Empty Cart</button>
    </form>

    <!-- "Continue Shopping" & "Proceed to Checkout" Buttons -->
    <a href="shop.php" class="btn btn-primary">Continue Shopping</a>
    <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>

<?php else: ?>
    <p>Your cart is empty.</p>
    <a href="shop.php" class="btn btn-primary">Start Shopping</a>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>
