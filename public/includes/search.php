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
$stmt = $conn->prepare("SELECT product_id, name, price, image FROM products WHERE name LIKE ?");
$searchTerm = "%$query%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

echo '<div class="product-list">';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product">';
        echo '<img src="public/images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
        echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
        echo '<p class="price">' . number_format($row['price'], 0, ',', '.') . 'đ</p>';
        echo '<button class="add-to-cart">Thêm vào giỏ</button>';
        echo '</div>';
    }
} else {
    $allProducts = $conn->query("SELECT product_id, name, price, image FROM products");
    while ($row = $allProducts->fetch_assoc()) {
        echo '<div class="product">';
        echo '<img src="public/images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
        echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
        echo '<p class="price">' . number_format($row['price'], 0, ',', '.') . 'đ</p>';
        echo '<button class="add-to-cart">Thêm vào giỏ</button>';
        echo '</div>';
    }
}

echo '</div>';

$stmt->close();
$conn->close();
include "footer.php";
?>
</body>
</html>

