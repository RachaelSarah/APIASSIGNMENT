<?php
session_start();
// Fetch order details from the session
$order_id = isset($_SESSION['order_id']) ? htmlspecialchars($_SESSION['order_id']) : "N/A";
$total_amount = isset($_SESSION['total_amount']) && is_numeric($_SESSION['total_amount']) 
    ? number_format((float)$_SESSION['total_amount'], 2) 
    : "N/A";
$shipping_address = isset($_SESSION['shipping_address']) ? nl2br(htmlspecialchars($_SESSION['shipping_address'])) : "N/A";
// Estimated delivery date (5–7 business days from today.)
$estimated_delivery_date = date('F j, Y', strtotime('+7 days'));
// Debugging: Log order details
error_log("Order ID: " . $order_id);
error_log("Total Amount: " . $total_amount);
error_log("Shipping Address: " . $shipping_address);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="Thank you.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS for a stylish design */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e6f7ff; /* Light blue background */
            padding: 20px;
        }

        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        h2 {
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #e83e8c; /* Pink header */
            color: #fff;
            font-weight: 500;
            font-size: 18px;
            padding: 12px 20px;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .btn-primary {
            background-color: #e83e8c;
            border-color: #e83e8c;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #d63384;
            border-color: #d63384;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .social-links .btn {
            margin-right: 10px;
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

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thank You for Your Order!</h2>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo htmlspecialchars($_SESSION['success']); 
                    unset($_SESSION['success']); // Clear success message after displaying
                ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">Order Summary</div>
            <div class="card-body">
                <p><strong>Order ID:</strong> <?= $order_id; ?></p>
                <p><strong>Total Amount:</strong> $<?= $total_amount; ?></p>
                <p><strong>Shipping Address:</strong> <?= $shipping_address; ?></p>
                <p><strong>Estimated Delivery Date:</strong> <?= htmlspecialchars($estimated_delivery_date); ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Customer Support</div>
            <div class="card-body">
                <p>If you have any questions or need assistance, please contact our customer support team:</p>
                <ul>
                    <li>Email: <a href="mailto:summer21cosmetics@gmail.com">summer21@gmail.com</a></li>
                    <li>Phone: <a href="tel:+254777854600">+254 (777) 854-600</a></li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Share Your Purchase</div>
            <div class="card-body">
                <p>Let your friends know about your awesome purchase!</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode("https://example.com/thank_you.php") ?>" target="_blank" class="btn btn-primary">
                        <i class="fab fa-facebook"></i> Share on Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode("https://example.com/thank_you.php") ?>&text=I%20just%20made%20an%20awesome%20purchase!" target="_blank" class="btn btn-primary">
                        <i class="fab fa-twitter"></i> Tweet About It
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Try Our New Products</div>
            <div class="card-body">
                <div class="row">
                    <!-- Example product cards -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://m.media-amazon.com/images/I/81ESI-ugVGL._SL1500_.jpg" class="card-img-top" alt="Product 1">
                            <div class="card-body">
                                <h5 class="card-title">Product 1</h5>
                                <p class="card-text">$49.99</p>
                                <a href="product.php?id=1" class="btn btn-primary">View Product</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://m.media-amazon.com/images/I/61Q+TITTeJL._SL1500_.jpg" class="card-img-top" alt="Product 2">
                            <div class="card-body">
                                <h5 class="card-title">Product 2</h5>
                                <p class="card-text">$29.99</p>
                                <a href="product.php?id=2" class="btn btn-primary">View Product</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://m.media-amazon.com/images/I/61OMjdHHcUL._SL1500_.jpg" class="card-img-top" alt="Product 3">
                            <div class="card-body">
                                <h5 class="card-title">Product 3</h5>
                                <p class="card-text">$39.99</p>
                                <a href="product.php?id=3" class="btn btn-primary">View Product</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Leave Feedback</div>
            <div class="card-body">
                <form action="submit_feedback.php" method="POST">
                    <div class="mb-3">
                        <label for="feedback" class="form-label">How was your shopping experience?</label>
                        <textarea class="form-control" id="feedback" name="feedback" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </form>
            </div>
        </div>

        <p class="text-center"><a href="index.php" class="btn btn-secondary">Return to Home</a></p>
    </div>

    <?php include 'templates/footer.php'; ?>
</body>
</html>