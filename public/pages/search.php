<?php
$searchTerm = isset($_GET['query']) ? trim($_GET['query']) : '';
$products = [];
include '../includes/Product_Database.php';
if (!empty($searchTerm)) {
    $products = (new Product_Database())->searchProducts($searchTerm);
}
// var_dump($searchTerm);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết Quả Tìm Kiếm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./public/assets/css/style.css">
</head>
<body>
    <?php include "../includes/header.php"; ?>
    
    <section class="products py-5">
        <div class="container">
            <h2 class="text-center">Kết Quả Tìm Kiếm</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php if (!empty($products)) {
                    foreach ($products as $product) { ?>
                        <div class="col mb-5">
                            <div class="card h-100">
                                <img class="card-img-top" src="..//assets/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <a href="../pages/items.php?product_id=<?= $product['product_id'] ?>" class="product-name">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </a>
                                        <p class="price"><?= number_format($product['price'], 0, ',', '.') ?>đ</p>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <a class="btn btn-outline-dark mt-auto" href="public/pages/items.php?product_id=<?= $product['product_id'] ?>">View options</a>
                                        <button class="btn btn-outline-dark mt-2 add-to-cart">
                                            <a href="public/includes/cart_crud.php?action=add&id=<?= $product['product_id'] ?>&quantity=1">Thêm vào giỏ</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <p class="text-center">Không tìm thấy sản phẩm nào.</p>
                <?php } ?>
            </div>
        </div>
    </section>
    
    <?php include "../includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>