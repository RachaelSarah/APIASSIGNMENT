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

<!-- Background Video -->
<div style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    z-index: -1;
">
    <iframe style="
        position: absolute;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        pointer-events: none;
    " src="" frameborder="0" allowfullscreen>
    </iframe>
</div>

<!-- Signup Form -->
<div style="
    position: relative;
    z-index: 1;
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
        <h2 style="margin-bottom: 20px; color: #333;">Sign Up</h2>
        <?php if (isset($error)) echo "<div style='color: red; margin-bottom: 15px;'>$error</div>"; ?>

        <form action="signup.php" method="POST">
            <div style="margin-bottom: 15px; text-align: left;">
                <label for="username" style="font-weight: bold;">Username</label>
                <input type="text" id="username" name="username" required style="
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-sizing: border-box;
                ">
            </div>
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
                Sign Up
            </button>
        </form>

        <p style="margin-top: 15px;">
            Already have an account? <a href="login.php" style="color: #007bff; text-decoration: none;">Login</a>
        </p>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
