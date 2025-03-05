<?php 
session_start();
require 'includes/dbb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST["message"]);
    $feedback = htmlspecialchars($_POST["feedback"]);

    if (!empty($name) && !empty($email) && !empty($message) && !empty($feedback)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message, feedback) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $message, $feedback]);
            $successMessage = "Thank you for reaching out! We will get back to you soon.";
        } catch (PDOException $e) {
            $errorMessage = "Error submitting form: " . $e->getMessage();
        }
    } else {
        $errorMessage = "Please fill out all fields.";
    }
}
?>

<?php include 'templates/header.php'; ?>

<!-- Custom Styling -->
<style>
    body {
        background-color: #FCE4EC; /* Pastel Pink */
        font-family: 'Arial', sans-serif;
    }
    .contact-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        color: #d63384; /* Soft Pink */
        font-weight: bold;
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        font-weight: bold;
        color: #444;
    }
    input, textarea, select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    textarea {
        resize: vertical;
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
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<div class="contact-container">
    <h2>📩 Contact Us</h2>
    
    <!-- Display Success or Error Messages -->
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?= $successMessage ?></div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php endif; ?>

    <form action="contact.php" method="POST">
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="email">Your Email:</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="message">Your Message:</label>
            <textarea name="message" id="message" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="feedback">How was your experience?</label>
            <select name="feedback" id="feedback" required>
                <option value="" disabled selected>Select your feedback</option>
                <option value="excellent">🌟 Excellent - I love it!</option>
                <option value="good">😊 Good - Satisfied</option>
                <option value="average">😐 Average - Could be better</option>
                <option value="poor">😞 Poor - Not happy</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">💌 Send Message</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>
