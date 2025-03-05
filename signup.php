<?php 
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $passwordHash])) {
            header('Location: login.php');
            exit;
        } else {
            $error = "Registration failed. Try again.";
        }
    }
}
?>

<?php include 'templates/header.php'; ?>

<!-- Custom Styling -->
<style>
    body {
        background-color: #FCE4EC; /* Pastel Pink */
        font-family: 'Arial', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }
    .signup-container {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }
    h2 {
        color: #d63384; /* Soft Pink */
        font-weight: bold;
    }
    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }
    label {
        font-weight: bold;
        color: #444;
    }
    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    .btn-submit {
        width: 100%;
        padding: 12px;
        background-color: #ff66b2; /* Soft pink button */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s ease-in-out;
    }
    .btn-submit:hover {
        background-color: #e65c99; /* Darker pink on hover */
    }
    .alert {
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 15px;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    .login-link {
        margin-top: 15px;
        color: #d63384;
        text-decoration: none;
        font-weight: bold;
    }
    .login-link:hover {
        text-decoration: underline;
    }
</style>

<!-- Signup Form -->
<div class="signup-container">
    <h2>✨ Sign Up ✨</h2>

    <!-- Display error message if exists -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="signup.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn-submit">💖 Create Account</button>
    </form>

    <p class="login-link">
        Already have an account? <a href="login.php">Login</a>
    </p>
</div>

<?php include 'templates/footer.php'; ?>
