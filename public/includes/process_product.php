<?php
require_once 'Product_Database.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $product_id = $_GET['product_id'] ?? null; // Dùng null để tránh lỗi undefined
    $name = $_GET['name'];
    $price = $_GET['price'];
    $description = $_GET['description'];
    $image = $_GET['image'];
    $stock = $_GET['stock'];
    $status = $_GET['status'];
    $category_id = $_GET['category_id'];

    echo "Action: " . $action;

    $product_database = new Product_Database();

    if ($action == 'delete') {
        $product_database->delateProduct($product_id);
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
