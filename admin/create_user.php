<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim(htmlspecialchars($_POST['name']));
  $email = trim(htmlspecialchars($_POST['email']));

  // Validate inputs
  if (empty($name)) {
    die("Name is required.");
  }

  try {
    $db = DB::getInstance();
    
    // Check for duplicate email (if provided)
    if (!empty($email)) {
      $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
      $stmt->execute([':email' => $email]);
      if ($stmt->fetch()) {
        die("Email already exists. Choose a unique email or leave blank.");
      }
    }

    // Insert new user
    $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
    $stmt->execute([
      ':name' => $name,
      ':email' => !empty($email) ? $email : null // Store NULL if email is empty
    ]);
    
    header("Location: users.php?success=1");
    exit();
  } catch (PDOException $e) {
    die("Error adding user: " . $e->getMessage());
  }
} else {
  header("Location: users.php");
  exit();
}
?>