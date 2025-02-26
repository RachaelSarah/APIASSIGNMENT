<?php
session_start();
include('dbconnection.php'); // Establish PDO connection as $conn

if (isset($_SESSION['failed_attempts']) && $_SESSION['failed_attempts'] >= 3) {
    $error = "Too many failed login attempts. Please try again later.";
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === 'admin' && $password === 'password123') { // Replace with secure authentication
        $_SESSION['admin_logged_in'] = true;
        unset($_SESSION['failed_attempts']); // Reset failed attempts on successful login
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['failed_attempts'] = ($_SESSION['failed_attempts'] ?? 0) + 1;
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }

        function showLoadingSpinner() {
            document.getElementById('login-button').style.display = 'none';
            document.getElementById('loading-spinner').style.display = 'block';
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        body {
            animation: fadeIn 1s ease-in-out;
            font-family: Arial, sans-serif;
            background: url('https://via.placeholder.com/1920x1080') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            color: #ff69b4;
            margin-bottom: 20px;
        }
        .login-container input[type="text"], .login-container input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }
        .login-container button {
            background-color: #ff69b4;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-container button:hover {
            background-color: #e75480;
        }
        .login-container .error {
            color: red;
            background-color: #ffecec;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .login-container .forgot-password {
            text-decoration: none;
            color: #ff69b4;
            font-size: 14px;
            margin-top: 10px;
            text-align: right;
        }
        .login-container .loading-spinner {
            display: none;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Removed the logo image -->
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="admin_login.php" method="POST" onsubmit="showLoadingSpinner()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required aria-label="Enter your username">

            <label for="password">Password:</label>
            <div style="position: relative; display: flex; align-items: center;">
                <input id="password" type="password" name="password" required aria-label="Enter your password" style="flex: 1;">
                <span onclick="togglePasswordVisibility()" style="cursor: pointer; margin-left: -35px; z-index: 1; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                    <i id="toggle-icon" class="fas fa-eye-slash" style="font-size: 18px; color: #aaa;"></i>
                </span>
            </div>

            <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
            <button type="submit" id="login-button">Login</button>
            <div id="loading-spinner" class="loading-spinner">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #ff69b4;"></i>
            </div>
        </form>
        <p style="margin-top: 15px; font-size: 14px; color: #666;">© 2023 Lip Gloss Admin Panel</p>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>