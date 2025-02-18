<?php
session_start();
require 'includes/db.php';
include('mailer.php'); // Include mailer functionality

function redirectWithError($message) {
    $_SESSION['error'] = $message;
    header("Location: login.php");
    exit();
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get and sanitize form input
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirectWithError("Invalid email format.");
        }

        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Regenerate session ID to prevent fixation attacks
            session_regenerate_id(true);

            // Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Generate and store OTP with expiration time
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expiry'] = time() + 300; // OTP expires in 5 minutes

            // Send OTP via email (in real-world applications)
            // Uncomment below in production
            // $mailer = new Mailer();
            // $mailer->sendOtpEmail($email, $user['username'], $otp);

            // For testing: Show OTP in an alert
            echo "<script>alert('Your OTP is $otp');</script>";

            // Redirect to OTP verification page
            header("Location: verify_otp.php?email=" . urlencode($email));
            exit();
        } else {
            redirectWithError("Invalid email or password.");
        }
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    redirectWithError("A database error occurred. Please try again.");
} catch (Exception $e) {
    error_log("Unexpected error: " . $e->getMessage());
    redirectWithError("An unexpected error occurred. Please try again.");
}
?>

<?php include 'templates/header.php'; ?>

<!-- Display Errors -->
<?php if (isset($_SESSION['error'])): ?>
    <div style="color: red; text-align: center; margin-bottom: 15px;">
        <?= htmlspecialchars($_SESSION['error']); ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Login Form -->
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
