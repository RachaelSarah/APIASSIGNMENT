<?php
session_start();
require 'includes/db.php';

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'templates/header.php'; ?>
<div class="container search-container mt-4">
    <form action="search.php" method="GET" class="d-flex">
        <input class="form-control me-2" type="search" name="query" placeholder="Search products..." required>
        <button class="btn btn-custom" type="submit">Search</button>
    </form>
</div>

<style>
.search-container {
    max-width: 500px;
    margin: auto;
}
</style>
<h2>Shop</h2>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?= htmlspecialchars($product['image_url'], ENT_QUOTES) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($product['description'], ENT_QUOTES) ?></p>
                    <p class="card-text">$<?= number_format($product['price'], 2) ?></p>
                    
                    <!-- Updated form to include product_id, name, and price -->
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>"> <!-- Fixed column name -->
                        <input type="hidden" name="name" value="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>">
                        <input type="hidden" name="price" value="<?= $product['price'] ?>">
                        <button type="submit" class="btn btn-custom">Buy Now</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include 'templates/footer.php'; ?>
