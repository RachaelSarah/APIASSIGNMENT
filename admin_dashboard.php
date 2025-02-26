<?php
session_start();
include('dbconnection.php'); // Establish PDO connection as $conn

// Ensure admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all products from the database
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch analytics data
$stmt = $conn->query("SELECT COUNT(*) AS total_orders, SUM(total_amount) AS total_sales FROM orders");
$analytics = $stmt->fetch(PDO::FETCH_ASSOC);
$avgOrderValue = $analytics['total_orders'] > 0 ? number_format($analytics['total_sales'] / $analytics['total_orders'], 2) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #ff69b4;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }
        .main-content {
            background-color: white;
            padding: 20px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 0 auto;
        }
        .btn {
            background-color: #ff69b4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #e75480;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #ff69b4;
            color: white;
        }
        footer {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 20px;
        }
        .analytics-section {
            margin-top: 50px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .chart-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        .chart-container canvas {
            max-width: 45%;
            height: 200px;
        }
        .summary-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .summary-table th, .summary-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .summary-table th {
            background-color: #ff69b4;
            color: white;
            text-align: left;
        }
        .summary-table td {
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Admin Dashboard</h1>
        <p>Manage Your Lip Gloss Products</p>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Action Buttons -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a href="add_product.php" class="btn">Add New Product <i class="fas fa-plus"></i></a>
            <a href="logout.php" class="btn" style="background-color: #dc3545;">Logout <i class="fas fa-sign-out-alt"></i></a>
        </div>

        <!-- Products Table -->
        <h2 style="color: #ff69b4; margin-bottom: 20px;">Products</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; border: 1px solid #ddd;">No products found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr style="border: 1px solid #ddd;">
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($product['product_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($product['name']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($product['category']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">$<?= number_format((float)$product['price'], 2); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                <a href="edit_product.php?product_id=<?= $product['product_id']; ?>" class="btn" style="background-color: #198754;">Edit <i class="fas fa-edit"></i></a>
                                <a href="delete_product.php?product_id=<?= $product['product_id']; ?>" class="btn" onclick="return confirm('Are you sure?')" style="background-color: #dc3545;">Delete <i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Footer -->
        <footer>© 2023 Lip Gloss Admin Panel</footer>

        <!-- Analytics Section (Moved to Bottom) -->
        <div class="analytics-section">
            <h2 style="color: #ff69b4; text-align: center; margin-bottom: 20px;">Analytics</h2>

            <!-- Small Charts -->
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
                <canvas id="ordersChart"></canvas>
            </div>

            <!-- Analytics Data Table -->
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Metric</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Sales</td>
                        <td>$<?= number_format((float)$analytics['total_sales'], 2); ?></td>
                    </tr>
                    <tr>
                        <td>Total Orders</td>
                        <td><?= $analytics['total_orders']; ?></td>
                    </tr>
                    <tr>
                        <td>Avg. Order Value</td>
                        <td>$<?= $avgOrderValue; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Chart.js Initialization -->
        <script>
            // Function to fetch data via AJAX
            function fetchData(endpoint) {
                return fetch(endpoint)
                    .then(response => response.json())
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Initialize charts on page load
            window.addEventListener('DOMContentLoaded', async () => {
                const salesData = await fetchData('api/sales_over_time.php');
                const ordersData = await fetchData('api/orders_by_status.php');

                // Sales Over Time Chart
                const salesLabels = salesData.map(item => item.month);
                const salesValues = salesData.map(item => item.total_sales);

                const salesCtx = document.getElementById('salesChart').getContext('2d');
                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: salesLabels,
                        datasets: [{
                            label: 'Monthly Sales',
                            data: salesValues,
                            borderColor: '#ff69b4',
                            borderWidth: 2,
                            backgroundColor: 'rgba(255, 105, 180, 0.2)',
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `$${context.parsed.y}`;
                                    }
                                }
                            }
                        }
                    }
                });

                // Orders by Status Chart
                const ordersLabels = ordersData.map(item => item.status);
                const ordersValues = ordersData.map(item => item.total_orders);

                const ordersCtx = document.getElementById('ordersChart').getContext('2d');
                new Chart(ordersCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ordersLabels,
                        datasets: [{
                            data: ordersValues,
                            backgroundColor: ['#ff69b4', '#e75480', '#f44336', '#9c27b0', '#673ab7']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'right' }
                        }
                    }
                });
            });
        </script>
</body>
</html>