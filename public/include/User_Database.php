<?php
require_once "Database.php"; // Đảm bảo bạn đã import file Database.php

class User_Database {
    private $connection;

    public function __construct() {
        // Khởi tạo kết nối từ class Database
        new Database(); // Đảm bảo Database được khởi tạo trước
        $this->connection = Database::$connection;
    }

    public function getUserInfo($email) {
        if (!$this->connection) {
            return null;
        }

        $stmt = $this->connection->prepare("SELECT name, email, phone, address FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
}
?>
