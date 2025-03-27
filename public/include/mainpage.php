<?php
require_once "Product_Database.php";

$products = (new Product_Database())->getAllProducts();
?>

<!-- Banner -->
<section class="banner text-center py-5 bg-light">
    <div class="container">
        <h1 class="display-4">Chào mừng bạn đến với cửa hàng!</h1>
        <p class="lead">Mua sắm những sản phẩm chất lượng với giá tốt nhất</p>
        <button class="btn btn-primary btn-lg">Mua Ngay</button>
    </div>
</section>

<!-- Danh sách sản phẩm -->
<section class="products py-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php foreach ($products as $product) : ?>
                <div class="col">
                    <div class="card h-100 text-center">
                        <img src="./public/assets/images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text price"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</p>
                            <button class="btn btn-success add-to-cart mt-auto">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

