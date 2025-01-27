<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imageUrl = $_POST['image_url'];

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $description, $price, $imageUrl])) {
        header("Location: manage_products.php");
        exit;
    } else {
        $error = "Failed to add product. Try again.";
    }
}
?>

<?php include 'templates/header.php'; ?>
<h2>Add Product</h2>
<?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form action="add_product.php" method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="image_url" class="form-label">Image URL</label>
        <input type="text" class="form-control" id="image_url" name="image_url" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Product</button>
</form>
<?php include 'templates/footer.php'; ?>
