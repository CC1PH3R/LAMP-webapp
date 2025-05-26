<?php
require_once 'config.php';

class DB {
  private static $instance = null;

  public static function getInstance() {
    if (!self::$instance) {
      try {
        self::$instance = new PDO(
          "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
          DB_USER,
          DB_PASS
        );
        self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
      }
    }
    return self::$instance;
  }
}
?>