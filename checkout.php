<?php
session_start();
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS for a stylish design */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            width: 100%;
        }

        h1 {
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #e83e8c;
            box-shadow: 0 0 5px rgba(232, 62, 140, 0.5);
        }

        .btn-pink {
            background-color: #e83e8c;
            border-color: #e83e8c;
            color: #fff;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-pink:hover {
            background-color: #d63384;
            border-color: #d63384;
        }

        .text-end {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <form action="process_checkout.php" method="POST">
            <div class="mb-3">
                <label for="address" class="form-label">Shipping Address:</label>
                <textarea id="address" name="address" class="form-control" rows="4" required></textarea>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-pink">Place Order</button>
            </div>
        </form>
    </div>
</body>
</html>