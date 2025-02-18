<?php
session_start();

// Regenerate session ID to prevent fixation attacks
session_regenerate_id(true);

// Ensure OTP exists in session and has not expired
if (!isset($_SESSION['otp']) || !isset($_SESSION['id']) || time() > $_SESSION['otp_expiry']) {
    // Clear all session data related to login/OTP
    unset($_SESSION['otp']);
    unset($_SESSION['otp_expiry']);
    unset($_SESSION['id']);

    $_SESSION['error'] = "OTP session expired or invalid. Please log in again.";
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = trim($_POST['otp']);

    // Check if OTP is valid and not expired
    if ($enteredOtp === $_SESSION['otp'] && time() <= $_SESSION['otp_expiry']) {
        // Clear OTP-related session data
        unset($_SESSION['otp']);
        unset($_SESSION['otp_expiry']);

        // Regenerate session ID again after successful OTP verification
        session_regenerate_id(true);

        // Store success message and redirect to home page
        $_SESSION['success'] = "OTP verified successfully!";
        header("Location: index.php");
        exit();
    } else {
        // Increment failed attempt counter (optional for brute force protection)
        if (!isset($_SESSION['failed_attempts'])) {
            $_SESSION['failed_attempts'] = 0;
        }
        $_SESSION['failed_attempts']++;

        // Lockout after 3 failed attempts (optional)
        if ($_SESSION['failed_attempts'] >= 3) {
            unset($_SESSION['otp']);
            unset($_SESSION['otp_expiry']);
            unset($_SESSION['id']);
            $_SESSION['error'] = "Too many failed attempts. Please log in again.";
            header("Location: login.php");
            exit();
        }

        $_SESSION['error'] = "Invalid or expired OTP. Please try again.";
        header("Location: verify_otp.php");
        exit();
    }
}
?>

<?php include 'templates/header.php'; ?>
<h2>Verify OTP</h2>

<!-- Display session error messages -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php 
            echo htmlspecialchars($_SESSION['error']); 
            unset($_SESSION['error']); // Clear error message after displaying
        ?>
    </div>
<?php endif; ?>

<form action="verify_otp.php" method="POST">
    <div>
        <label for="otp">Enter OTP</label>
        <input type="text" id="otp" name="otp" required>
    </div>
    <button type="submit">Verify</button>
</form>

<?php include 'templates/footer.php'; ?>