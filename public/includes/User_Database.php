<?php
require_once "Database.php"; // Đảm bảo bạn đã import file Database.php

class User_Database
{
    private $connection;

    public function __construct()
    {
        // Khởi tạo kết nối từ class Database
        new Database(); // Đảm bảo Database được khởi tạo trước
        $this->connection = Database::$connection;
    }

    public function getUserInfo($email)
    {
        if (!$this->connection) {
            return null;
        }

        $stmt = $this->connection->prepare("SELECT name, email,password, phone, address FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getUserInfo2($email)
    {
        if (!$this->connection) {
            return null;
        }

        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
    public function updatePassword($email, $password_hash) {
    $conn = new mysqli("localhost", "root", "", "webbanhang");
    if ($conn->connect_error) {
        return false;
    }
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $password_hash, $email);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}
}