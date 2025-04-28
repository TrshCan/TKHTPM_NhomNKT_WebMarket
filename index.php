<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = 'Trang Chủ';

if (file_exists('public/includes/db.php')) {
    require_once 'public/includes/db.php';
} else {
    die('Lỗi: Không tìm thấy file cơ sở dữ liệu.');
}
if (file_exists('public/includes/Product_Database.php')) {
    require_once 'public/includes/Product_Database.php';
} else {
    die('Lỗi: Không tìm thấy file Product_Database.');
}
if (file_exists('public/includes/Categories_Database.php')) {
    require_once 'public/includes/Categories_Database.php';
} else {
    die('Lỗi: Không tìm thấy file Categories_Database.');
}

$products_db = new Product_Database();
$categories_db = new Categories_Database();

$category_id = isset($_GET['category_id']) && is_numeric($_GET['category_id']) ? (int)$_GET['category_id'] : null;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$products = $products_db->getProducts($category_id, $offset, $per_page);
$categories = $categories_db->getCategories();
$total_products = $products_db->getTotalProducts($category_id);
$total_pages = ceil($total_products / $per_page);
?>

<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            margin: 0;
        }
        .banner {
            height: 80vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo BASE_URL; ?>public/assets/images/banner.jpg') no-repeat center center;
            background-size: cover;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .banner h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .banner p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }
        .banner .btn {
            background-color: #3b82f6;
            color: #ffffff;
            font-size: 1.1rem;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            border: none;
            transition: background-color 0.3s ease;
        }
        .banner .btn:hover {
            background-color: #1e40af;
        }
        .filter-section {
            padding: 2rem 0;
            background-color: #ffffff;
        }
        .filter-section .form-select {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        .filter-section .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        .products-section {
            padding: 4rem 0;
            background-color: #f9fafb;
        }
        .products-section h2 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 3rem;
        }
        .product-card {
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-8px);
        }
        .product-card img {
            height: 250px;
            width: 100%;
            object-fit: cover;
        }
        .product-card-body {
            padding: 1.5rem;
            text-align: center;
            flex-grow: 1;
        }
        .product-card-body .product-name {
            font-size: 1.25rem;
            font-weight: 500;
            color: #1f2937;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }
        .product-card-body .product-name:hover {
            color: #3b82f6;
        }
        .product-card-body p {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }
        .product-card-body .price {
            font-size: 1.2rem;
            font-weight: 600;
            color: #f59e0b;
        }
        .product-card-footer {
            padding: 1rem;
            background-color: #ffffff;
            margin-top: auto;
        }
        .product-card-footer .btn {
            width: 100%;
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            font-size: 0.9rem;
            border-radius: 0.5rem;
            text-decoration: none;
        }
        .product-card-footer .btn-outline-dark {
            color: #1f2937;
            border-color: #1f2937;
            transition: all 0.3s ease;
        }
        .product-card-footer .btn-outline-dark:hover {
            background-color: #1f2937;
            color: #ffffff;
        }
        .pagination .page-link {
            color: #1f2937;
            border-radius: 0.5rem;
            margin: 0 0.25rem;
        }
        .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: #ffffff;
        }
        .pagination .page-item.disabled .page-link {
            color: #9ca3af;
        }
        @media (max-width: 768px) {
            .banner {
                height: 60vh;
            }
            .banner h1 {
                font-size: 2.5rem;
            }
            .banner p {
                font-size: 1rem;
            }
            .products-section h2 {
                font-size: 2rem;
            }
            .product-card img {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <section class="banner">
        <div>
            <h1>Chào Mừng Đến Với NKT Shop!</h1>
            <p>Khám phá các sản phẩm chất lượng với ưu đãi hấp dẫn</p>
            <a href="#products" class="btn">Mua Ngay</a>
        </div>
    </section>
    <section class="filter-section">
        <div class="container">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <select name="category_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Tất Cả Danh Mục</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['category_id']); ?>" <?php echo $category['category_id'] == $category_id ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section class="products-section" id="products">
        <div class="container">
            <h2>Sản Phẩm Nổi Bật</h2>
            <div class="row gx-4 gy-4 row-cols-1 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                    <div class="col">
                        <div class="card product-card">
                            <img class="card-img-top" src="<?php echo BASE_URL; ?>public/assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                            <div class="card-body product-card-body">
                                <a href="<?php echo BASE_URL; ?>public/pages/items.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>" class="product-name">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </a>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</p>
                            </div>
                            <div class="card-footer product-card-footer">
                                <a class="btn btn-outline-dark" href="<?php echo BASE_URL; ?>public/pages/items.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>">Xem Chi Tiết</a>
                                <a class="btn btn-outline-dark add-to-cart" href="#" onclick="addToCart('<?php echo htmlspecialchars($product['product_id']); ?>'); return false;">Thêm Vào Giỏ</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-600">Không tìm thấy sản phẩm nào.</p>
                <?php endif; ?>
            </div>
            <div class="pagination justify-content-center mt-5">
                <ul class="pagination">
                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&category_id=<?php echo htmlspecialchars($category_id); ?>" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&category_id=<?php echo htmlspecialchars($category_id); ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&category_id=<?php echo htmlspecialchars($category_id); ?>" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addToCart(productId) {
            <?php if (!isset($_SESSION['name']) || $_SESSION['name'] === ''): ?>
                alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
                window.location.href = '<?php echo BASE_URL; ?>public/pages/login.php';
            <?php else: ?>
                window.location.href = '<?php echo BASE_URL; ?>public/includes/cart_crud.php?action=add&id=' + productId + '&quantity=1';
            <?php endif; ?>
        }
    </script>
</body>
</html>