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

    public function getProductById($product_id)
    {
        $sql = self::$connection->prepare("SELECT * FROM products WHERE product_id = ?");
        $sql->bind_param("i", $product_id);
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById2($product_id)
    {
        $sql = self::$connection->prepare("SELECT * FROM products WHERE product_id = ?");
        $sql->bind_param("i", $product_id);
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_assoc();
    }
    
    
    public function searchProducts($keyword)
    {
        $sql = self::$connection->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
        if (!$sql) {
            die("Lỗi truy vấn: " . self::$connection->error);
        }
    
        $keyword = '%' . $keyword . '%';
        $sql->bind_param("ss", $keyword, $keyword);
        $sql->execute();
        
        $result = $sql->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
    
        $sql->close(); // Đóng truy vấn để tránh rò rỉ bộ nhớ
        return $items;
    }
    
    public function getRelatedProducts($product_id)
    {
        $sql = self::$connection->prepare("SELECT * FROM products WHERE category_id = (SELECT category_id FROM products WHERE product_id = ?) AND product_id != ? LIMIT 4");
        $sql->bind_param("ii", $product_id, $product_id);
        $sql->execute();
        $result = $sql->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
        $sql->close();
        return $items;
    }
    public function delateProduct($id)
    {
        $sql = self::$connection->prepare("DELETE FROM products WHERE product_id=?");
        $sql->bind_param("i", $id);
        $result = $sql->execute();

        return $result;
    }
    public function addProduct($category_id, $name, $description, $image, $price, $stock, $status) {
        $sql = self::$connection->prepare("INSERT INTO products (category_id, name, description, image, price, stock, status) VALUES (?,?,?,?,?,?,?)");
        $sql->bind_param("isssiis", $category_id, $name, $description, $image, $price, $stock, $status);
        $result = $sql->execute();
        return $result;
    }
    

    // Update function for a product
    public function UpdateProduct($id, $name, $price, $desc, $image, $category_id)
    {
        // Prepare the SQL statement to update the product based on the ID
        $sql = self::$connection->prepare("UPDATE products SET name=?, price=?, `desc`=?, image=?, category_id=? WHERE id=?");

        // Bind parameters: s for string, i for integer, d for double
        $sql->bind_param("sissii", $name, $price, $desc, $image, $category_id, $id);

        // Execute the statement
        $result = $sql->execute();

        // Close the prepared statement
        $sql->close();

        // Return the result of the execution
        return $result;
    }

}

