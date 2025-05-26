<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim(htmlspecialchars($_POST['username']));
  $display_name = trim(htmlspecialchars($_POST['display_name']));

  // Validate inputs
  if (empty($username) || empty($display_name)) {
    die("Username and display name are required.");
  }

  try {
    $db = DB::getInstance();
    
    // Check if username already exists
    $stmt = $db->prepare("SELECT id FROM judges WHERE username = :username");
    $stmt->execute([':username' => $username]);
    if ($stmt->fetch()) {
      die("Username already exists. Choose a unique username.");
    }

    // Insert new judge
    $stmt = $db->prepare("INSERT INTO judges (username, display_name) VALUES (:username, :display_name)");
    $stmt->execute([':username' => $username, ':display_name' => $display_name]);
    
    header("Location: judges.php?success=1");
    exit();
  } catch (PDOException $e) {
    die("Error adding judge: " . $e->getMessage());
  }
} else {
  header("Location: judges.php");
  exit();
}
?>