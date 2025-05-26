<?php
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
  $db = DB::getInstance();
  $stmt = $db->query("
    SELECT 
      u.id AS user_id,
      u.name AS user_name,
      COALESCE(SUM(s.points), 0) AS total_points
    FROM users u
    LEFT JOIN scores s ON u.id = s.user_id
    GROUP BY u.id
    ORDER BY total_points DESC
  ");
  $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode(['data' => $scores]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Failed to fetch scores']);
}