<?php
require_once '../includes/db.php';
require_once '../includes/header.php';
?>
<link rel="stylesheet" href="../assets/css/scoreboard.css">

<div class="scoreboard-container">
  <h1>Live Scoreboard</h1>
  <div id="scoreboard-content">
    <!-- Dynamically populated by JavaScript -->
    <div class="spinner"></div>
  </div>
</div>

<script src="../assets/js/scoreboard.js"></script>
</body>
</html>