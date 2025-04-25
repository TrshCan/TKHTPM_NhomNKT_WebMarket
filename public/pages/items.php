<?php include "../includes/header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Item - NKT</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/items.css">
    <style>
    /* Sản phẩm liên quan */
    .related-products {
        padding: 60px 0;
        background-color: #ffffff;
    }

    .related-products h2 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 40px;
    }

    .related-products .product-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        padding: 0 15px;
    }

    .related-products .product {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .related-products .product:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .related-products .product img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .related-products .product h3 {
        font-size: 1.2rem;
        margin: 10px 0;
        color: #333;
        font-weight: 500;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .related-products .product .price {
        font-size: 1.1rem;
        color: #e74c3c;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .related-products .product button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
        font-size: 1rem;
    }

    .related-products .product button:hover {
        background-color: #0056b3;
    }

    .related-products .product button a {
        color: #fff;
        text-decoration: none;
        display: block;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .related-products .product-list {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
        }

        .related-products .product img {
            height: 150px;
        }

        .related-products .product h3 {
            font-size: 1rem;
        }

        .related-products .product .price {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .related-products .product-list {
            grid-template-columns: 1fr;
        }

        .related-products .product img {
            height: 200px;
        }
    }

    /* Ensure footer is not overlapped */
    footer {
        clear: both;
        position: relative;
        z-index: 1;
    }

    /* Existing styles for other sections */
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f2f5;
    }

    /* Banner */
    .banner {
        height: 100vh;
        background: url('public/assets/images/banner.jpg') no-repeat center center;
        background-size: cover;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .banner h1 {
        font-size: 4rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .banner p {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .banner button {
        padding: 15px 40px;
        background-color: #ff5722;
        color: white;
        font-size: 1.2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .banner button:hover {
        background-color: #e64a19;
    }

    /* Products Section */
    .products-section {
        padding: 60px 0;
        background-color: #ffffff;
    }

    .products-section h2 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 50px;
    }

    /* Product Card */
    .product-card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-10px);
    }

    .product-card img {
        height: 300px;
        width: 100%;
        object-fit: cover;
        border-bottom: 2px solid #eee;
    }

    .product-card-body {
        padding: 20px;
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .product-card-body .product-name {
        font-size: 1.5rem;
        color: #333;
        font-weight: 500;
        text-decoration: none;
        display: block;
        margin-bottom: 10px;
    }

    .product-card-body .product-name:hover {
        color: #007bff;
    }

    .product-card-body p {
        font-size: 1.1rem;
        color: #777;
        margin-bottom: 15px;
    }

    .product-card-body .price {
        font-size: 1.3rem;
        color: #e74c3c;
        font-weight: bold;
    }

    .product-card-footer {
        padding: 20px;
        background-color: #f8f9fa;
        margin-top: auto;
    }

    .product-card-footer .btn {
        width: 100%;
        margin-bottom: 10px;
        padding: 10px;
        font-size: 1rem;
        border-radius: 5px;
        text-decoration: none;
    }

    .product-card-footer .btn-outline-dark {
        color: #333;
        border-color: #333;
    }

    .product-card-footer .btn-outline-dark:hover {
        background-color: #333;
        color: white;
    }

    /* Pagination */
    .pagination .page-link {
        color: #333;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    /* Footer */
    .footer {
        background-color: #212529;
        color: white;
        text-align: center;
        padding: 30px 0;
    }

    .footer a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
    }

    .footer a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>

    <?php
    require_once "../includes/Product_Database.php";
    $productsdb = new Product_Database();
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $products = $productsdb->getProductById($product_id);
        foreach ($products as $value) {
    ?>
    <section class="product-section">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <img width="600" height="500" src="../assets/images/<?= $value["image"] ?>"
                        alt="<?= $value["name"] ?>" />
                </div>
                <div class="col-md-6">
                    <div class="small mb-1">Mã: <?= $value["product_id"] ?></div>
                    <h1 class="display-5 fw-bolder"><?= $value["name"] ?></h1>
                    <div class="fs-5 mb-3">
                        <span><?= number_format($value["price"], 0, ',', '.') ?>đ</span>
                    </div>
                    <p class="lead"><?= $value["description"] ?></p>
                    <div class="d-flex">
                        <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1"
                            style="max-width: 3rem" />
                        <button class="btn-add-to-cart flex-shrink-0">
                            <a style="text-decoration: none;"
                                href="../includes/cart_crud.php?action=add&id=<?php echo $value['product_id']; ?>&quantity=1">Thêm
                                vào giỏ</a>
                        </button>
                        <button class="btn-buy-now flex-shrink-0" type="button">
                            Mua Ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
        }
    }
    ?>

    <section class="related-products">
        <div class="container px-3 px-lg-5">
            <h2 class="fw-bolder mb-4">Sản Phẩm Liên Quan</h2>
            <div class="product-list">
                <?php
                $related_products = $productsdb->getRelatedProducts($product_id);
                foreach ($related_products as $related) {
                ?>
                <div class="product">
                    <img src="../assets/images/<?= $related["image"] ?>" alt="<?= $related["name"] ?>" />
                    <h3><?= $related["name"] ?></h3>
                    <p class="price"><?= number_format($related["price"], 0, ',', '.') ?>đ</p>
                    <button class="add-to-cart">
                        <a class="text-white"
                            href="../includes/cart_crud.php?action=add&id=<?= $related["product_id"] ?>&quantity=1">Thêm
                            Vào Giỏ</a>
                    </button>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <script src="js/scripts.js"></script>
    <?php include "../../footer.php" ?>
</body>

</html>