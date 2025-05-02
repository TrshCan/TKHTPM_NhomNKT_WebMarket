<?php
require_once "Database.php";

class Admin_Database extends Database {


    public function getAllUser() {
        $sql = self::$connection->prepare("SELECT user_id,name,email,password,phone,address FROM users");
        $sql->execute();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items; // Array of orders
    }
    public function addUser($name, $email, $password, $phone, $address) {
        $sql = "INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
        $stmt  = self::$connection->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);
        return $stmt->execute();
    }

    public function updateUser($user_id, $name, $email, $password, $phone, $address) {
        $sql = "UPDATE users SET name = ?, email = ?, password = ?, phone = ?, address = ? WHERE user_id = ?";
        $stmt  = self::$connection->prepare($sql);
        $stmt->bind_param("sssssi", $name, $email, $password, $phone, $address, $user_id);
        return $stmt->execute();
    }

    public function deleteUser($user_id) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    public function getTotalUsers() {
        $conn = new mysqli("localhost", "root", "", "webbanhang");
        if ($conn->connect_error) return 0;
        $result = $conn->query("SELECT COUNT(*) as total FROM users");
        $row = $result->fetch_assoc();
        $conn->close();
        return $row['total'];
    }
    
    public function getTotalOrders() {
        $conn = new mysqli("localhost", "root", "", "webbanhang");
        if ($conn->connect_error) return 0;
        $result = $conn->query("SELECT COUNT(*) as total FROM orders");
        $row = $result->fetch_assoc();
        $conn->close();
        return $row['total'];
    }
    
    public function getTotalProducts() {
        $conn = new mysqli("localhost", "root", "", "webbanhang");
        if ($conn->connect_error) return 0;
        $result = $conn->query("SELECT COUNT(*) as total FROM products");
        $row = $result->fetch_assoc();
        $conn->close();
        return $row['total'];
    }
    
    public function getTotalRevenue() {
        $conn = new mysqli("localhost", "root", "", "webbanhang");
        if ($conn->connect_error) return 0;
        $result = $conn->query("SELECT SUM(total_price) as total FROM orders WHERE status = 'Hoàn thành'");
        $row = $result->fetch_assoc();
        $conn->close();
        return $row['total'] ?: 0;
    }
    
    public function getRecentOrders($limit) {
        $conn = new mysqli("localhost", "root", "", "webbanhang");
        if ($conn->connect_error) return [];
        $stmt = $conn->prepare("
            SELECT o.order_id, o.total_price, o.status, u.name as user_name
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.user_id
            ORDER BY o.order_date DESC
            LIMIT ?
        ");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conn->close();
        return $orders;
    }
    
    public function getMonthlyRevenue() {
        $conn = new mysqli("localhost", "root", "", "webbanhang");
        if ($conn->connect_error) return [];
        $result = $conn->query("
            SELECT DATE_FORMAT(order_date, '%Y-%m') as month, SUM(total_price) as revenue
            FROM orders
            WHERE status = 'Hoàn thành'
            GROUP BY DATE_FORMAT(order_date, '%Y-%m')
            ORDER BY month DESC
            LIMIT 6
        ");
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $data;
    }
    
    public function getCategoryDistribution() {
        $conn = new mysqli("localhost", "root", "", "webbanhang");
        if ($conn->connect_error) return [];
        $result = $conn->query("
            SELECT c.category_name, COUNT(p.product_id) as count
            FROM categories c
            LEFT JOIN products p ON c.category_id = p.category_id
            GROUP BY c.category_id, c.category_name
        ");
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $data;
    }
}
?>
