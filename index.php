<?php

require_once 'includes/config.php';

// Test DB conn
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h1>Connected to MYSQL Database!</h1>";
} catch (PDOException $e) {
    die("<h1>Connection failed: " . $e->getMessage() . "</h1>");
}

// Test PHP func
echo "<p>PHP is working fine!</p>";
?>