<?php
require_once "Database.php";
class Product_Database extends Database
{
    private $product_id;
    private $category_id;
    private $name;
    private $description;
    private $image;
    private $price;
    private $stock;
    private $status;

    // function __construct($id, $name, $price, $desc, $image)
    // {
    //     $this->id = $id;
    //     $this->name = $name;
    //     $this->price = $price;
    //     $this->description = $desc;
    //     $this->image = $image;
    // }

    // function __construct_with_id($id, $name, $price, $desc, $image, $category_id)
    // {
    //     $this->id = $id;
    //     $this->name = $name;
    //     $this->price = $price;
    //     $this->description = $desc;
    //     $this->image = $image;
    //     $this->category_id = $category_id;
    // }

    public function getProductId() {
        return $this->product_id;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getAllProducts()
    {
        $sql = self::$connection->prepare("SELECT * FROM products");
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }

    public function getProductById($id)
    {
        $sql = self::$connection->prepare("SELECT * FROM products WHERE product_id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_assoc();
        return $item;
    }
}
