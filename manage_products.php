<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
requireLogin();

// Handle delete request
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_products.php");
    exit;
}

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'templates/header.php'; ?>
<h2>Manage Products</h2>
<a href="add_product.php" class="btn btn-primary mb-3">Add Product</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>" width="50"></td>
            <td><?= $product['name'] ?></td>
            <td><?= $product['description'] ?></td>
            <td>$<?= $product['price'] ?></td>
            <td>
                <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="manage_products.php?delete=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'templates/footer.php'; ?>
