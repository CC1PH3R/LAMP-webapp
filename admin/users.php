<?php
require_once '../includes/db.php';
$db = DB::getInstance();

// Fetch existing users
try {
  $stmt = $db->query("SELECT * FROM users ORDER BY id DESC");
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Error fetching users: " . $e->getMessage());
}

// Success message after adding a user
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : 0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Users</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="form-container">
    <h1>Add a New User</h1>
    <?php if ($success): ?>
      <div class="alert alert-success">User added successfully!</div>
    <?php endif; ?>
    <form action="create_user.php" method="POST">
      <label>Full Name:</label>
      <input type="text" name="name" required placeholder="e.g., Alice Johnson">

      <label>Email (Optional):</label>
      <input type="email" name="email" placeholder="e.g., alice@example.com">

      <button type="submit">Add User</button>
    </form>
  </div>

  <div class="judges-list"> <!-- Reuse CSS class -->
    <h2>Existing Users</h2>
    <?php if (count($users) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['id']) ?></td>
              <td><?= htmlspecialchars($user['name']) ?></td>
              <td><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No users added yet.</p>
    <?php endif; ?>
  </div>
</body>
</html>