<?php
// class/Database.php
class Database {
    public PDO $conn;

    public function __construct() {
        $this->connect();
    }

    public function connect(): ?PDO {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            return $this->conn;
        } catch (PDOException $e) {
            // tampilkan pesan singkat (untuk pengembangan)
            echo "Database connection failed: " . $e->getMessage();
            exit;
        }
    }
}