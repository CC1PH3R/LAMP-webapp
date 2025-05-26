<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

$db = DB::getInstance();

// Fetch existing judges
try {
  $stmt = $db->query("SELECT * FROM judges ORDER BY id DESC");
  $judges = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Error fetching judges: " . $e->getMessage());
}

// Success message after adding a judge
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : 0;
?>

  <div class="form-container">
    <h1>Add a New Judge</h1>
    <?php if ($success): ?>
      <div class="alert alert-success">Judge added successfully!</div>
    <?php endif; ?>
    <form action="create_judge.php" method="POST">
      <label>Username:</label>
      <input type="text" name="username" required placeholder="e.g., judge_mike">

      <label>Display Name:</label>
      <input type="text" name="display_name" required placeholder="e.g., Judge Mike Brown">

      <button type="submit">Add Judge</button>
    </form>
  </div>

  <div class="judges-list">
    <h2>Existing Judges</h2>
    <?php if (count($judges) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Display Name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($judges as $judge): ?>
            <tr>
              <td><?= htmlspecialchars($judge['id']) ?></td>
              <td><?= htmlspecialchars($judge['username']) ?></td>
              <td><?= htmlspecialchars($judge['display_name']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No judges added yet.</p>
    <?php endif; ?>
  </div>
</div>
</body>
</html>