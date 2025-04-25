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
    /* Cải tiến phần giao diện sản phẩm liên quan */
    /* Cải tiến phần giao diện sản phẩm liên quan */
    .related-products .product-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .related-products .product {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .related-products .product img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .related-products .product h3 {
        font-size: 1.1rem;
        margin: 10px 0;
    }

    .related-products .product .price {
        font-size: 1rem;
        color: #333;
        margin-bottom: 10px;
    }

    .related-products .product button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .related-products .product:hover {
        transform: translateY(-5px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .related-products .product button:hover {
        background-color: #0056b3;
    }

    /* Ensuring there's space below the related products section */
    .related-products {
        margin-bottom: 100px;
        /* Adjust the space below the related products section */
    }

    /* Ensuring the footer is not overlapped */
    footer {
        clear: both;
        /* Clear the float above */
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

    <section class="related-products mt-3">
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