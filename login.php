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

<!-- Page Styling -->
<div style="
    background: url('https://www.nyxcosmetics.com/dw/image/v2/AANG_PRD/on/demandware.static/-/Sites-nyxcosmetics-us-Library/en_US/dwf6b3e9d0/homepage/2025/202506XX-DMI-NGL-HPV2-ALaunch-FOLD-CHILLZ-Ext-Banner-Global-1440x1440.jpg?sw=2000&sh=2000&sm=fit&q=70') no-repeat center center;
    background-size: cover;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
">
    <div style="
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 400px;
        text-align: center;
    ">
        <h2 style="margin-bottom: 20px; color: #333;">Login</h2>
        <?php if (isset($error)) echo "<div style='color: red; margin-bottom: 15px;'>$error</div>"; ?>

        <form action="login.php" method="POST">
            <div style="margin-bottom: 15px; text-align: left;">
                <label for="email" style="font-weight: bold;">Email</label>
                <input type="email" id="email" name="email" required style="
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-sizing: border-box;
                ">
            </div>
            <div style="margin-bottom: 15px; text-align: left;">
                <label for="password" style="font-weight: bold;">Password</label>
                <input type="password" id="password" name="password" required style="
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-sizing: border-box;
                ">
            </div>
            <button type="submit" style="
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 15px;
                width: 100%;
                font-size: 16px;
                border-radius: 5px;
                cursor: pointer;
                transition: background 0.3s;
            " onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'">
                Login
            </button>
        </form>

        <p style="margin-top: 15px;">
            Don't have an account? <a href="signup.php" style="color: #007bff; text-decoration: none;">Sign Up</a>
        </p>
        <p>
            Did you forget your password? <a href="recover_password.php" style="color: #007bff; text-decoration: none;">Forgot password</a>
        </p>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
