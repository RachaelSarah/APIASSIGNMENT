<?php
session_start();
require 'includes/db.php';
include('mailer.php'); // Include the mailer functionality

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Two-Factor Authentication Simulation
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        // In a real-world scenario, send OTP via email or SMS
        echo "<script>alert('Your OTP is $otp');</script>";

        header('Location: verify_otp.php');
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<?php include 'templates/header.php'; ?>
<h2>Login</h2>
<?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form action="login.php" method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>
<p class="text-center mt-3">
                    Don't have an account? <a href="signup.php">Sign Up</a>
                </p>
                <p class="text-center mt-3">
                    Did you forget your password? <a href="recover_password.php">Forgot password</a>
                </p>
<?php include 'templates/footer.php'; ?>


