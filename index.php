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
$per_page = 10; // Số sản phẩm mỗi trang
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <style>
        /* Giao diện mới cho trang chủ */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        /* Banner full-screen */
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
            margin-bottom: 20px;
            font-weight: bold;
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
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .banner button:hover {
            background-color: #e64a19;
        }

        /* Phần sản phẩm */
        .products-section {
            padding: 60px 0;
            background-color: #ffffff;
        }

        .products-section h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
            font-weight: bold;
        }

        .product-card {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-bottom: 2px solid #eee;
        }

        .product-card-body {
            padding: 20px;
            text-align: center;
        }

        .product-card-body h5 {
            font-size: 1.6rem;
            margin-bottom: 10px;
        }

        .product-card-body p {
            font-size: 1.2rem;
            color: #777;
            margin-bottom: 15px;
        }

        .product-card-body .price {
            font-size: 1.3rem;
            color: #ff5722;
            font-weight: bold;
        }

        .product-card-footer {
            padding: 20px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-card-footer .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .product-card-footer .btn:hover {
            background-color: #0056b3;
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
                                <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] == $category_id ? 'selected' : '' ?>><?= $category['category_name'] ?></option>
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
            <div class="row">
                <?php foreach ($products as $product) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="product-card">
                            <img src="public/assets/images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" />
                            <div class="product-card-body">
                                <h5><?= $product['name'] ?></h5>
                                <p><?= $product["description"] ?></p>
                                <p class="price"><?= number_format($product['price'], 0, ',', '.') ?>đ</p>
                            </div>
                            <div class="product-card-footer">
                                <a href="public/pages/items.php?product_id=<?= $product['product_id'] ?>" class="btn">Xem Chi Tiết</a>
                                <a href="public/includes/cart_crud.php?action=add&id=<?= $product['product_id'] ?>&quantity=1" class="btn">Thêm vào Giỏ</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Phân trang -->
            <div class="pagination">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>&category_id=<?= $category_id ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&category_id=<?= $category_id ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>&category_id=<?= $category_id ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Cửa Hàng Online</p>
        <p><a href="#">Chính Sách Bảo Mật</a> | <a href="#">Điều Khoản Dịch Vụ</a></p>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
