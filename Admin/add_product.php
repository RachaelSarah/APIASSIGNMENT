<?php
session_start();
include('dbconnection.php'); // Establish PDO connection as $conn

// Ensure admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
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
                INSERT INTO products (name, description, price, image_url, category) 
                VALUES (:name, :description, :price, :image_url, :category)
            ");
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':image_url' => $image_url,
                ':category' => $category
            ]);
            header("Location: admin_dashboard.php");
            exit();
        } catch (Exception $e) {
            $error = "Failed to add product: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <div style="background-color: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-align: center; width: 100%; max-width: 500px;">
        <img src="https://via.placeholder.com/150" alt="Lip Gloss Logo" style="max-width: 100%; height: auto; margin-bottom: 20px;">
        <h2 style="color: #ff69b4; margin-bottom: 20px;">Add New Product</h2>
        <?php if (isset($error)): ?>
            <div style="color: red; background-color: #ffecec; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form action="add_product.php" method="POST" onsubmit="showLoadingSpinner()" style="display: flex; flex-direction: column; align-items: center;">
            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Name:</label>
            <input type="text" id="name" name="name" required placeholder="Enter product name" style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;">

            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Description:</label>
            <textarea id="description" name="description" placeholder="Enter product description" style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;"></textarea>

            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required placeholder="Enter product price" style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;">

            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Image URL:</label>
            <div style="position: relative; width: 100%; margin-bottom: 15px;">
                <input type="url" id="image_url" name="image_url" placeholder="Enter product image URL" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;">
                <img id="image-preview" src="" alt="Preview" style="max-width: 100%; max-height: 150px; margin-top: 10px; display: none;">
            </div>

            <label style="font-weight: bold; margin-bottom: 5px; width: 100%; text-align: left;">Category:</label>
            <input type="text" id="category" name="category" required placeholder="Enter product category" style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; width: 100%;">

            <button type="submit" id="submit-button" style="background-color: #ff69b4; color: white; padding: 10px; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; transition: background-color 0.3s; width: 100%;">
                Add Product
            </button>
            <div id="loading-spinner" style="display: none; margin-top: 10px; text-align: center;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #ff69b4;"></i>
            </div>
        </form>
        <p style="margin-top: 15px; font-size: 14px; color: #666; text-align: center;">
            <a href="admin_dashboard.php" style="text-decoration: none; color: #ff69b4;">Back to Dashboard</a>
        </p>

        <script>
            // Image preview functionality
            document.getElementById('image_url').addEventListener('input', function () {
                const imageUrl = this.value;
                const preview = document.getElementById('image-preview');
                if (imageUrl) {
                    preview.src = imageUrl;
                    preview.style.display = 'block';
                } else {
                    preview.style.display = 'none';
                }
            });

            // Loading spinner functionality
            function showLoadingSpinner() {
                document.getElementById('submit-button').style.display = 'none';
                document.getElementById('loading-spinner').style.display = 'block';
            }
        </script>
    </div>
</body>
</html>