<?php
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function getProducts() {
        $conn = $this->db->connect();
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $products = array();
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        } else {
            echo "0 results";
        }
        $conn->close();

        return $products;
    }

    public function getProductById($id) {
        $conn = $this->db->connect();
        $sql = "SELECT * FROM products WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {
            echo "0 results";
        }
        $conn->close();

        return $product;
    }
}
?>