<?php
require 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'templates/header.php'; ?>
<h2>Shop</h2>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?= $product['image_url'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text">$<?= $product['price'] ?></p>
                    <a href="#" class="btn btn-custom">Buy Now</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include 'templates/footer.php'; ?>
