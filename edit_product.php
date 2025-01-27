<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
requireLogin();

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imageUrl = $_POST['image_url'];

    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ? WHERE id = ?");
    if ($stmt->execute([$name, $description, $price, $imageUrl, $id])) {
        header("Location: manage_products.php");
        exit;
    } else {
        $error = "Failed to update product. Try again.";
    }
}
?>

<?php include 'templates/header.php'; ?>
<h2>Edit Product</h2>
<?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form action="edit_product.php?id=<?= $id ?>" method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?= $product['description'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= $product['price'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="image_url" class="form-label">Image URL</label>
        <input type="text" class="form-control" id="image_url" name="image_url" value="<?= $product['image_url'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>
<?php include 'templates/footer.php'; ?>
