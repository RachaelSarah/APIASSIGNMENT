<?php
session_start();
include('dbconnection.php'); // Establish PDO connection as $conn

// Ensure admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

if (!$product_id) {
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :product_id");
$stmt->execute([':product_id' => $product_id]);
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
    $category = trim($_POST['category']);

    if (empty($name) || empty($price) || empty($category)) {
        $error = "Name, price, and category are required.";
    } else {
        try {
            $stmt = $conn->prepare("
                UPDATE products 
                SET name = :name, description = :description, price = :price, image_url = :image_url, category = :category 
                WHERE product_id = :product_id
            ");
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':image_url' => $image_url,
                ':category' => $category,
                ':product_id' => $product_id
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
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <div style="background-color: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-align: center; width: 100%; max-width: 500px;">
        <h2 style="color: #ff69b4; margin-bottom: 20px;">Edit Product</h2>
        <?php if (isset($error)): ?>
            <div style="color: red; background-color: #ffecec; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form action="edit_product.php?product_id=<?= $product['product_id']; ?>" method="POST" style="display: flex; flex-direction: column; align-items: center;">
            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']); ?>" required style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;">

            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Description:</label>
            <textarea id="description" name="description" style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;"><?= htmlspecialchars($product['description']); ?></textarea>

            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Price:</label>
            <input type="number" id="price" name="price" value="<?= htmlspecialchars($product['price']); ?>" step="0.01" required style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;">

            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Image URL:</label>
            <input type="url" id="image_url" name="image_url" value="<?= htmlspecialchars($product['image_url']); ?>" style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;">

            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Category:</label>
            <input type="text" id="category" name="category" value="<?= htmlspecialchars($product['category']); ?>" required style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;">

            <button type="submit" style="background-color: #ff69b4; color: white; padding: 10px; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; transition: background-color 0.3s; width: 100%;">
                Update Product
            </button>
        </form>
        <p style="margin-top: 15px; font-size: 14px; color: #666; text-align: center;">
            <a href="admin_dashboard.php" style="text-decoration: none; color: #ff69b4;">Back to Dashboard</a>
        </p>
    </div>
</body>
</html>