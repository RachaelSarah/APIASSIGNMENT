<?php
session_start();
include('dbconnection.php'); // Establish PDO connection as $conn

// Ensure admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

$product_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$product_id) {
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $image_url = trim($_POST['image_url']);
    $category = trim($_POST['category']); // Get category

    if (empty($name) || empty($price) || empty($category)) {
        $error = "Name, price, and category are required.";
    } else {
        try {
            $stmt = $conn->prepare("
                UPDATE products 
                SET name = :name, description = :description, price = :price, image_url = :image_url, category = :category 
                WHERE id = :id
            ");
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':image_url' => $image_url,
                ':category' => $category, // Update category
                ':id' => $product_id
            ]);
            header("Location: admin_dashboard.php");
            exit();
        } catch (Exception $e) {
            $error = "Failed to update product: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <?php if (isset($error)): ?>
        <div style="color: red;"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="edit_product.php?id=<?= $product['id']; ?>" method="POST">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description"><?= htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?= htmlspecialchars($product['price']); ?>" step="0.01" required>
        </div>
        <div>
            <label for="image_url">Image URL:</label>
            <input type="url" id="image_url" name="image_url" value="<?= htmlspecialchars($product['image_url']); ?>">
        </div>
        <div>
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" value="<?= htmlspecialchars($product['category']); ?>" required> <!-- Add category field -->
        </div>
        <button type="submit">Update Product</button>
    </form>
    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>