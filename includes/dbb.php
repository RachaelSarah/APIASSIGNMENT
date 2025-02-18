<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=summer21", "root", "12345");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>