<?php
include('dbconnection.php'); // Establish PDO connection as $conn

// Fetch all products
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lip Gloss Products</title>
</head>
<body>
    <h2>Our Lip Gloss Products</h2>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" width="150">
                <h3><?= htmlspecialchars($product['name']); ?></h3>
                <p><?= htmlspecialchars($product['description']); ?></p>
                <p><strong>Price:</strong> $<?= number_format((float)$product['price'], 2); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>