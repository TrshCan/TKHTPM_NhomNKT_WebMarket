<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Item - NKT</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/items.css">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo">N<span>K</span>T</div>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.php" style="font-family: 'Arial', sans-serif;">Trang Chủ</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="cart.html" style="font-family: 'Arial', sans-serif;">Giỏ
                                Hàng</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="accountDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                style="font-family: 'Arial', sans-serif;">
                                Tài Khoản
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                <li><a class="dropdown-item" href="login.php"
                                        style="font-family: 'Arial', sans-serif;">Đăng Nhập</a></li>
                                <li><a class="dropdown-item" href="register.php"
                                        style="font-family: 'Arial', sans-serif;">Đăng Ký</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="search-box">
            <form action="search.php" method="get">
                <input type="text" id="search-input" name="query" placeholder="Tìm kiếm sản phẩm...">
                <button type="submit">🔍</button>
            </form>
        </div>
    </header>

    <?php
    require_once "Product_Database.php";
    $productsdb = new Product_Database();
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $products = $productsdb->getProductById($product_id);
        foreach ($products as $value) {
    ?>
    <!-- Product section-->
    <section class="product-section">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img src="../assets/images/$value[" image"] ?>" alt="<?= $value["name"] ?>" />
                </div>
                <div class="col-md-6">
                    <div class="small mb-1">Mã: <?= $value["product_id"] ?></div>
                    <h1 class="display-5 fw-bolder"><?= $value["name"] ?></h1>
                    <div class="fs-5 mb-3">
                        <span><?= number_format($value["price"], 0, ',', '.') ?>đ</span>
                    </div>
                    <p class="lead"><?= $value["description"] ?></p>
                    <div class="mb-3">
                        <label class="form-label">Kích Thước:</label>
                        <button class="size-option">S</button>
                        <button class="size-option">M</button>
                        <button class="size-option">L</button>
                        <button class="size-option">XL</button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Màu Sắc:</label>
                        <span class="color-option" style="background-color: white;"></span>
                        <span class="color-option" style="background-color: black;"></span>
                        <span class="color-option" style="background-color: gray;"></span>
                    </div>
                    <div class="d-flex">
                        <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1"
                            style="max-width: 3rem" />
                        <button class="btn-add-to-cart flex-shrink-0" type="button">
                            <i class="bi-cart-fill me-1"></i>
                            Thêm Vào Giỏ
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

    <!-- Related items section-->
    <section class="related-products">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Sản Phẩm Liên Quan</h2>
            <div class="product-list">
                <?php
                $related_products = $productsdb->getRelatedProducts($product_id);
                foreach ($related_products as $related) {
                ?>
                <div class="product">
                    <img src="../assets/images/$related[" image"] ?>" alt="<?= $related["name"] ?>" />
                    <h3><?= $related["name"] ?></h3>
                    <p class="price"><?= number_format($related["price"], 0, ',', '.') ?>đ</p>
                    <button class="add-to-cart">Thêm Vào Giỏ</button>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer>
        <div class="container">
            <p class="m-0 text-center text-white">Copyright © NKT 2025</p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>