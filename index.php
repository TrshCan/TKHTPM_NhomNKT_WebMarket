<?php
include "public/includes/Product_Database.php";
$products = (new Product_Database())->getAllProducts();
?>

<!DOCTYPE html>
<html lang="vi">
s
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Bán Hàng</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>

<body>
    <?php include "public/includes/header.php" ?>
    <!-- Banner -->
    <section class="banner">
        <h1>Chào mừng bạn đến với cửa hàng!</h1>
        <p>Mua sắm những sản phẩm chất lượng với giá tốt nhất</p>
        <button>Mua Ngay</button>
    </section>

    <!-- Danh sách sản phẩm -->
    <section class="products">
        <h2>Sản Phẩm Mới</h2>
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="public/assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="price"><?php echo $product['price'] . 'đ'; ?></p>
                    <a href="public/includes/cart_crud.php?action=add&id=<?php echo $product['product_id']; ?>&quantity=1" class="add-to-cart">Thêm vào giỏ</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php include "public/includes/footer.php" ?>
</body>

