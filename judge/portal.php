<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

// Fetch judges and users for dropdowns
try {
  $db = DB::getInstance();
  
  // Get all judges
  $judges_stmt = $db->query("SELECT id, username, display_name FROM judges");
  $judges = $judges_stmt->fetchAll(PDO::FETCH_ASSOC);
  
  // Get all users
  $users_stmt = $db->query("SELECT id, name FROM users");
  $users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Error fetching data: " . $e->getMessage());
}

// Handle success/error messages
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : null;
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : null;
?>
<link rel="stylesheet" href="../assets/css/judge.css">
<div class="form-container">
  <h1>Assign Points</h1>
  
  <?php if ($success): ?>
    <div class="alert alert-success">Score submitted successfully!</div>
  <?php endif; ?>
  
  <?php if ($error): ?>
    <div class="alert alert-error"><?= $error ?></div>
  <?php endif; ?>

  <form action="submit_score.php" method="POST">
    <!-- Judge Selection -->
    <label>Select Judge:</label>
    <select name="judge_id" required>
      <option value="">Choose a Judge</option>
      <?php foreach ($judges as $judge): ?>
        <option value="<?= htmlspecialchars($judge['id']) ?>">
          <?= htmlspecialchars($judge['display_name']) ?> (<?= htmlspecialchars($judge['username']) ?>)
        </option>
      <?php endforeach; ?>
    </select>

    <!-- User Selection -->
    <label>Select User:</label>
    <select name="user_id" required>
      <option value="">Choose a User</option>
      <?php foreach ($users as $user): ?>
        <option value="<?= htmlspecialchars($user['id']) ?>">
          <?= htmlspecialchars($user['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <!-- Points Input -->
    <label>Points (1-100):</label>
    <input type="number" name="points" min="1" max="100" required>

    <button type="submit" class="btn-submit">
      <i class="fas fa-check"></i> Submit Score
    </button>
  </form>
</div>
</body>
</html>