<?php
require_once 'Product_Database.php';
echo "Action: " . $_POST['action'];
if (isset($_POST['product_id']) && isset($_POST['action'])) {
    $action = $_POST['action'];
    $product_id = $_POST['product_id'] ?? null; // Dùng null để tránh lỗi undefined
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $stock = $_POST['stock'];
    $status = $_POST['status'];
    $category_id = $_POST['category_id'];

    echo "Action: " . $action;

    $product_database = new Product_Database();

    if ($action == 'delete' && $id) {
        $product_database->delateProduct($id);
        header('location: ../pages/quanlysanpham.php');
        exit();
    }

    if ($action == "add") {
         $product_database->addProduct($category_id, $name, $description, $image, $price, $stock, $status);
        header('location: ../pages/quanlysanpham.php');
        exit();
    }

    if ($action == "edit" && $id) {
         $product_database->UpdateProduct($id, $name, $price, $description, $image, $category_id);
        header('location: ../pages/quanlysanpham.php');
        exit();
    }
}
?>
