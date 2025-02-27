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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 20px;">
    <!-- Header Section -->
    <header style="background-color: #ff69b4; color: white; text-align: center; padding: 20px; border-radius: 10px 10px 0 0;">
        <h1 style="margin: 0;">Admin Dashboard</h1>
        <p style="margin: 5px 0;">Manage Your Lip Gloss Products</p>
        
            <!-- Analytics Summary Section -->


    </header>

    <!-- Main Content -->
    <div style="background-color: white; padding: 20px; border-radius: 0 0 10px 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 1000px; margin: 0 auto;">
        <!-- Action Buttons -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a href="add_product.php" class="btn" style="background-color: #ff69b4; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; text-decoration: none;">
                Add New Product <i class="fas fa-plus"></i>
            </a>
            <a href="logout.php" class="btn" style="background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; text-decoration: none;">
                Logout <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>

        <!-- Search Input -->
        <div style="margin-bottom: 20px;">
            <input type="text" id="search-input" placeholder="Search products..." style="padding: 10px; width: 100%; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
        </div>

        <!-- Products Table -->
        <h2 style="color: #ff69b4; margin-bottom: 20px; text-align: center;">Products</h2>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead style="background-color: #ff69b4; color: white;">
                <tr>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">ID</th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Name</th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Category</th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Price</th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; border: 1px solid #ddd;">
                            No products found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr style="border: 1px solid #ddd; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#f4f4f4'" onmouseout="this.style.backgroundColor='white'">
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($product['product_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($product['name']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($product['category']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">$<?= number_format((float)$product['price'], 2); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                <a href="edit_product.php?product_id=<?= $product['product_id']; ?>" class="btn" style="background-color: #198754; color: white; padding: 5px 10px; border: none; border-radius: 5px; font-size: 14px; margin-right: 5px; text-decoration: none;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_product.php?product_id=<?= $product['product_id']; ?>" class="btn" onclick="return confirm('Are you sure?')" style="background-color: #dc3545; color: white; padding: 5px 10px; border: none; border-radius: 5px; font-size: 14px; text-decoration: none;">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
<br> <br>
<div style="display: flex; justify-content: space-around; padding: 20px; background-color: #fff; border-radius: 10px; margin: 20px auto; max-width: 1000px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <div class="card" style="text-align: center;">
        <h3>Total Sales</h3>
        <p id="total-sales" style="font-size: 24px; font-weight: bold;">$0.00</p>
    </div>
    <div class="card" style="text-align: center;">
        <h3>Total Orders</h3>
        <p id="total-orders" style="font-size: 24px; font-weight: bold;">0</p>
    </div>
    <div class="card" style="text-align: center;">
        <h3>Avg. Order Value</h3>
        <p id="avg-order-value" style="font-size: 24px; font-weight: bold;">$0.00</p>
    </div>
</div>

<!-- Charts Container -->
<div style="max-width: 1000px; margin: 20px auto;">
    <canvas id="topProductsChart"></canvas>
</div>

<div style="max-width: 1000px; margin: 20px auto;">
    <canvas id="monthlySalesChart"></canvas>
</div>

<div style="max-width: 500px; margin: 20px auto;">
    <canvas id="orderStatusChart"></canvas>
</div>

        <!-- Footer -->
        <footer style="text-align: center; color: #666; font-size: 14px; margin-top: 20px;">
            © 2023 Lip Gloss Admin Panel
        </footer>
    </div>

    <!-- Search Script -->
    <script>
        document.getElementById('search-input').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const category = row.cells[2].textContent.toLowerCase();
                if (name.includes(query) || category.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    <!-- Load Chart.js and jQuery -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $.ajax({
            url: "analytics.php",
            method: "GET",
            success: function (data) {
                // Update summary stats
                $("#total-sales").text(`$${parseFloat(data.sales.total_revenue).toFixed(2)}`);
                $("#total-orders").text(data.sales.total_orders);
                $("#avg-order-value").text(`$${parseFloat(data.sales.avg_order_value).toFixed(2)}`);

                // Top Selling Products Chart
                const productNames = data.top_products.map(item => item.name);
                const productSales = data.top_products.map(item => item.total_sold);

                new Chart(document.getElementById("topProductsChart"), {
                    type: "bar",
                    data: {
                        labels: productNames,
                        datasets: [{
                            label: "Best Selling Products",
                            data: productSales,
                            backgroundColor: "blue"
                        }]
                    }
                });

                // Monthly Sales Chart
                const months = data.monthly_sales.map(item => item.month);
                const revenues = data.monthly_sales.map(item => item.revenue);

                new Chart(document.getElementById("monthlySalesChart"), {
                    type: "line",
                    data: {
                        labels: months,
                        datasets: [{
                            label: "Monthly Revenue",
                            data: revenues,
                            backgroundColor: "green",
                            borderColor: "green",
                            fill: false
                        }]
                    }
                });

                // Order Status Chart
                const statusLabels = data.order_status.map(item => item.payment_status);
                const statusCounts = data.order_status.map(item => item.count);

                new Chart(document.getElementById("orderStatusChart"), {
                    type: "pie",
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            label: "Order Status",
                            data: statusCounts,
                            backgroundColor: ["red", "yellow", "green"]
                        }]
                    }
                });
            }
        });
    });
</script>
</body>
</html>