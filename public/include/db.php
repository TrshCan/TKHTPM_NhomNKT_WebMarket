<?php
class DB {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'webbanhang';

    public function connect() {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}

// Khởi tạo kết nối CSDL và lưu vào biến $conn
$db = new DB();
$conn = $db->connect();
?>
