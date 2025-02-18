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

<div style="max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; box-shadow: 2px 2px 12px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #333;">Contact Us</h2>
    
    <?php if (isset($successMessage)): ?>
        <div style="padding: 10px; background-color: #d4edda; color: #FFDFDD; border-radius: 5px; margin-bottom: 15px;">
            <?= $successMessage ?>
        </div>
    <?php elseif (isset($errorMessage)): ?>
        <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 5px; margin-bottom: 15px;">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>

    <form action="contact.php" method="POST">
        <div style="margin-bottom: 15px;">
            <label for="name" style="font-weight: bold;">Name:</label>
            <input type="text" name="name" id="name" required 
                style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email" style="font-weight: bold;">Email:</label>
            <input type="email" name="email" id="email" required 
                style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="message" style="font-weight: bold;">Message:</label>
            <textarea name="message" id="message" rows="4" required 
                style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;"></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="feedback" style="font-weight: bold;">Feedback:</label>
            <select name="feedback" id="feedback" required 
                style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="" disabled selected>Select your opinion</option>
                <option value="excellent">Excellent - I love it!</option>
                <option value="good">Good - Satisfied with the product</option>
                <option value="average">Average - Could be better</option>
                <option value="poor">Poor - Not happy with it</option>
            </select>
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background-color: #e8afd8; color: Black; border: none; border-radius: 5px; cursor: pointer;">
            Send Message
        </button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>