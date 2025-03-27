<?php
include "db.php";
include "Products.php";
$products = (new ProductModel())->getProducts();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Bán Hàng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
    /* Định dạng thẻ a trong sản phẩm */
    .product-name {
        text-decoration: none;
        /* Bỏ gạch chân */
        font-size: 1.5rem;
        /* Cỡ chữ to hơn (24px) */
        font-family: 'Roboto', sans-serif;
        /* Font chữ đẹp */
        color: #333;
        /* Màu chữ xám đậm */
        font-weight: 500;
        /* Độ đậm vừa phải */
    }

    .product-name:hover {
        color: #007bff;
        /* Màu xanh dương khi hover */
    }

    /* Optional: Định dạng giá sản phẩm */
    .price {
        font-size: 1.2rem;
        /* Cỡ chữ giá */
        color: #e74c3c;
        /* Màu đỏ nổi bật */
        font-weight: bold;
    }

    /* Định dạng thẻ a trong sản phẩm */
    .product-name {
        text-decoration: none;
        /* Bỏ gạch chân */
        font-size: 1.5rem;
        /* Cỡ chữ to hơn (24px) */
        font-family: 'Roboto', sans-serif;
        /* Font chữ đẹp */
        color: #333;
        /* Màu chữ xám đậm */
        font-weight: 500;
        /* Độ đậm vừa phải */
    }

    .product-name:hover {
        color: #007bff;
        /* Màu xanh dương khi hover */
    }

    /* Định dạng giá sản phẩm */
    .price {
        font-size: 1.2rem;
        /* Cỡ chữ giá */
        color: #e74c3c;
        /* Màu đỏ nổi bật */
        font-weight: bold;
    }

    /* Cân bằng chiều cao sản phẩm */
    .card {
        height: 100%;
        /* Đảm bảo thẻ card chiếm toàn bộ chiều cao của cột */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* Căn chỉnh nội dung bên trong */
    }

    /* Cố định chiều cao hình ảnh */
    .card-img-top {
        height: 400px;
        /* Chiều cao cố định cho hình ảnh */
        object-fit: cover;
        /* Đảm bảo hình ảnh không bị méo */
        width: 100%;
        /* Chiều rộng đầy đủ */
    }

    /* Đảm bảo phần nội dung bên dưới đồng đều */
    .card-body {
        flex-grow: 1;
        /* Phần nội dung mở rộng để lấp đầy không gian */
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* Căn giữa nội dung */
    }

    /* Đảm bảo phần nút ở dưới cùng */
    .card-footer {
        margin-top: auto;
        /* Đẩy nút xuống dưới cùng */
    }

    /* Định dạng nút "View options" và "Thêm vào giỏ" */
    .btn-outline-dark {
        width: 100%;
        /* Nút chiếm toàn bộ chiều rộng */
        margin-bottom: 5px;
        /* Khoảng cách giữa các nút */
    }
    </style>
</head>

<body>
    <?php include "header.php" ?>
    <!-- Banner -->
    <section class="banner">
        <h1>Chào mừng bạn đến với cửa hàng!</h1>
        <p>Mua sắm những sản phẩm chất lượng với giá tốt nhất</p>
        <button>Mua Ngay</button>
    </section>

    <!-- Danh sách sản phẩm -->
    <section class="products">
        <h2>Sản Phẩm Mới</h2>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                foreach ($products as $product) {
                ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="public/images/<?= $product['image'] ?>"
                            alt="<?= $product['name'] ?>" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <a href="items.php?product_id=<?= $product['product_id'] ?>" class="product-name">
                                    <?= $product['name'] ?>
                                </a>
                                <!-- Product price-->
                                <p class="price"><?= number_format($product['price'], 0, ',', '.') ?>đ</p>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto"
                                    href="items.php?product_id=<?= $product['product_id'] ?>">View options</a>
                                <button class="btn btn-outline-dark mt-2 add-to-cart">Thêm vào giỏ</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <?php include "footer.php" ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>