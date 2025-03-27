<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<?php
include "header.php";
$conn = new mysqli("localhost", "root", "", "webbanhang");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$query = isset($_GET['query']) ? $_GET['query'] : '';
$stmt = $conn->prepare("SELECT product_id, name, price, image FROM products WHERE name LIKE ? OR description LIKE ?");
$searchTerm = "%$query%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<div class="product-list">';
    echo '<section class="products py-5">';
    echo '<div class="container">';
    echo '<div class="row row-cols-1 row-cols-md-4 g-4">';
    while ($product = $result->fetch_assoc()) {
        echo '<div class="col">';
        echo '<div class="card h-100">';
        echo '<img src="./public/assets/images/' . htmlspecialchars($product['image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>';
        echo '<p class="card-text price">' . number_format($product['price'], 0, ',', '.') . 'đ</p>';
        echo '<button class="btn btn-success add-to-cart">Thêm vào giỏ</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    echo '</section>';
    echo '</div>';
} else {
    echo '<p class="text-center">Không tìm thấy sản phẩm nào.</p>';
}

$stmt->close();
$conn->close();
include "footer.php";
?>
</body>
</html>

