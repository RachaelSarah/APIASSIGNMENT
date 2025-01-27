<?php
session_start();
if (!isset($_SESSION['otp'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp'];
    if ($enteredOtp == $_SESSION['otp']) {
        unset($_SESSION['otp']);
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<?php include 'templates/header.php'; ?>
<h2>Verify OTP</h2>
<?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form action="verify_otp.php" method="POST">
    <div class="mb-3">
        <label for="otp" class="form-label">Enter OTP</label>
        <input type="text" class="form-control" id="otp" name="otp" required>
    </div>
    <button type="submit" class="btn btn-primary">Verify</button>
</form>
<?php include 'templates/footer.php'; ?>
