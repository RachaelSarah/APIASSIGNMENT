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
<h2>Sign Up</h2>
<?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form action="signup.php" method="POST">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Sign Up</button>
</form>
<?php include 'templates/footer.php'; ?>
