<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: portal.php");
  exit();
}

// Sanitize inputs
$judge_id = filter_input(INPUT_POST, 'judge_id', FILTER_VALIDATE_INT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
$points = filter_input(INPUT_POST, 'points', FILTER_VALIDATE_INT);

// Validate inputs
$errors = [];
if (!$judge_id) $errors[] = "Invalid judge selection.";
if (!$user_id) $errors[] = "Invalid user selection.";
if (!$points || $points < 1 || $points > 100) $errors[] = "Points must be between 1-100.";

if (!empty($errors)) {
  header("Location: portal.php?error=" . urlencode(implode(" ", $errors)));
  exit();
}

try {
  $db = DB::getInstance();
  
  // Verify judge/user existence (prevent spoofed IDs)
  $stmt = $db->prepare("SELECT id FROM judges WHERE id = ?");
  $stmt->execute([$judge_id]);
  if (!$stmt->fetch()) throw new Exception("Judge does not exist.");
  
  $stmt = $db->prepare("SELECT id FROM users WHERE id = ?");
  $stmt->execute([$user_id]);
  if (!$stmt->fetch()) throw new Exception("User does not exist.");

  // Insert score
  $stmt = $db->prepare("INSERT INTO scores (judge_id, user_id, points) VALUES (?, ?, ?)");
  $stmt->execute([$judge_id, $user_id, $points]);
  
  header("Location: portal.php?success=1");
} catch (Exception $e) {
  header("Location: portal.php?error=" . urlencode($e->getMessage()));
}
exit();