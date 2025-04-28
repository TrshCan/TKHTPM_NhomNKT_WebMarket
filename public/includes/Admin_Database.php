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
}
?>
