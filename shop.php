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
    body {
        background-color: #f8f9fa;
    }
    .search-container {
        max-width: 500px;
        margin: auto;
    }
    h2 {
        text-align: center;
        margin: 20px 0;
        color: #e83e8c; /* Pink heading for a stylish look */
    }
    .card {
        width: 100%; 
        max-width: 250px; /* Smaller card width */
        margin: auto; 
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.05);
    }
    .card-img-top {
        height: 150px; /* Reduced image height */
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }
    .card-body {
        padding: 15px;
        text-align: center;
    }
    .btn-custom {
        background-color: #e83e8c; /* Pink button */
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background 0.3s;
    }
    .btn-custom:hover {
        background-color: #c2185b; /* Darker pink on hover */
    }
</style>

<h2>Shop</h2>

<div class="container">
    <div class="row justify-content-center">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <img src="<?= htmlspecialchars($product['image_url'], ENT_QUOTES) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></h5>
                        <p class="card-text">$<?= number_format($product['price'], 2) ?></p>

                        <!-- Buy Now Form -->
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <input type="hidden" name="name" value="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>">
                            <input type="hidden" name="price" value="<?= $product['price'] ?>">
                            <button type="submit" class="btn btn-custom">Buy Now</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
