<?php include "header.php" ?>
<?php
include "public/includes/db.php";
include "public/includes/Product_Database.php";
include "public/includes/Categories_Database.php";

$products = (new Product_Database())->getAllProducts();
$categories = (new Categories_Database())->getCategories();
// Xử lý lọc theo danh mục
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Lấy sản phẩm theo danh mục hoặc tất cả sản phẩm
$products = (new Product_Database())->getProducts($category_id, $offset, $per_page);

// Tính toán số trang
$total_products = (new Product_Database())->getTotalProducts($category_id);
$total_pages = ceil($total_products / $per_page);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Bán Hàng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <style>
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
    <!-- Banner -->
    <section class="banner">
        <div>
            <h1>Chào Mừng Bạn Đến Với Cửa Hàng!</h1>
            <p>Khám phá các sản phẩm mới và ưu đãi hấp dẫn</p>
            <button>Mua Ngay</button>
        </div>
    </section>
    <!-- Lọc theo danh mục -->
    <section class="filter-section">
        <div class="container">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <select name="category_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Chọn Danh Mục</option>
                            <?php foreach ($categories as $category) { ?>
                            <option value="<?= $category['category_id'] ?>"
                                <?= $category['category_id'] == $category_id ? 'selected' : '' ?>>
                                <?= $category['category_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Danh sách sản phẩm -->
    <section class="products-section">
        <div class="container">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php if (!empty($products)) {
                    foreach ($products as $product) { ?>
                <div class="col mb-5">
                    <div class="card product-card">
                        <img class="card-img-top"
                            src="./public/assets/images/<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>" />
                        <div class="card-body product-card-body">
                            <a href="items.php?product_id=<?= $product['product_id'] ?>" class="product-name">
                                <?= htmlspecialchars($product['name']) ?>
                            </a>
                            <p><?= htmlspecialchars($product['description']) ?></p>
                            <p class="price"><?= number_format($product['price'], 0, ',', '.') ?>đ</p>
                        </div>
                        <div class="card-footer product-card-footer border-top-0 bg-transparent">
                            <a class="btn btn-outline-dark"
                                href="items.php?product_id=<?= $product['product_id'] ?>">View options</a>
                            <a class="btn btn-outline-dark add-to-cart"
                                href="public/includes/cart_crud.php?action=add&id=<?= $product['product_id'] ?>&quantity=1">Thêm
                                vào giỏ</a>
                        </div>
                    </div>
                </div>
                <?php }
                } else { ?>
                <p class="text-center">Không tìm thấy sản phẩm nào.</p>
                <?php } ?>
            </div>

            <!-- Phân trang -->
            <div class="pagination justify-content-center">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>&category_id=<?= $category_id ?>"
                            aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&category_id=<?= $category_id ?>"><?= $i ?></a>
                    </li>
                    <?php } ?>
                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>&category_id=<?= $category_id ?>"
                            aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <p>© 2025 Cửa Hàng Online</p>
        <p><a href="#">Chính Sách Bảo Mật</a> | <a href="#">Điều Khoản Dịch Vụ</a></p>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>