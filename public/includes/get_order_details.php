<?php
require_once "./OrderDetail_Database.php";
require_once "./Product_Database.php";

header('Content-Type: application/json');

if (!isset($_GET['order_id'])) {
    echo json_encode(['error' => 'Missing order_id']);
    exit;
}

$order_id = intval($_GET['order_id']);
$order_detail_db = new Order_Detail_Database();
$product_db = new Product_Database();

$order_details = $order_detail_db->getOrderDetailsByOrderId($order_id);
$products = $product_db->getAllProducts();

$product_map = [];
foreach ($products as $product) {
    $product_map[$product['product_id']] = $product['name'];
}

// Add product name to each order detail
foreach ($order_details as &$detail) {
    $detail['product_name'] = $product_map[$detail['product_id']] ?? 'Unknown';
}

echo json_encode($order_details);