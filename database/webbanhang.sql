-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 05:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webbanhang`
--
CREATE DATABASE IF NOT EXISTS `webbanhang` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `webbanhang`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Áo Quần Nam'),
(2, 'Áo Quần Nữ'),
(3, 'Giày Dép'),
(4, 'Thiết Bị Điện Tử'),
(5, 'Đồ Gia Dụng');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL CHECK (`total_price` >= 0),
  `status` enum('đang chờ','đã giao','hoàn thành') DEFAULT 'đang chờ',
  `payment_method` varchar(100) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `status`, `payment_method`, `address`, `order_date`) VALUES
(1, 1, 750000.00, 'đang chờ', NULL, '', '2025-04-25'),
(2, 18, 350000.00, 'đang chờ', 'cod', '213123, 9238, 258, 27', '2025-04-25'),
(3, 18, 700000.00, 'đang chờ', 'e-wallet', '213123, 11941, 317, 31', '2025-04-25'),
(4, 18, 750000.00, '', 'bank', '213123, Phường Phúc Thắng, Thành phố Phúc Yên, Tỉnh Vĩnh Phúc', '2025-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` > 0),
  `price` decimal(10,2) NOT NULL CHECK (`price` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(3, 2, 3, 1, 350000.00),
(4, 3, 3, 1, 350000.00),
(5, 3, 2, 1, 150000.00),
(6, 3, 1, 1, 200000.00),
(7, 4, 2, 1, 150000.00),
(8, 4, 3, 1, 350000.00),
(9, 4, 4, 1, 250000.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` enum('COD','credit_card','paypal') NOT NULL,
  `status` enum('đang chờ','đã thanh toán','thất bại') DEFAULT 'đang chờ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `status`) VALUES
(1, 1, 'COD', 'đang chờ');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL CHECK (`price` >= 0),
  `stock` int(11) NOT NULL CHECK (`stock` >= 0),
  `status` enum('có sẵn','hết hàng') DEFAULT 'có sẵn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `description`, `image`, `price`, `stock`, `status`) VALUES
(1, 1, 'Áo Sơ Mi Nam', 'Áo sơ mi nam đẹp', 'image1.jpg', 200000.00, 10, 'có sẵn'),
(2, 2, 'Áo Phông Nữ', 'Áo phông nữ đẹp', 'image2.jpg', 150000.00, 15, 'có sẵn'),
(3, 3, 'Giày Thể Thao', 'Giày thể thao chất lượng', 'image3.jpg', 350000.00, 20, 'hết hàng'),
(4, 1, 'Quần Jean Nam', 'Quần jean nam thời trang', 'image4.jpg', 250000.00, 25, 'có sẵn'),
(5, 2, 'Chân Váy Nữ', 'Chân váy nữ đẹp', 'image5.jpg', 180000.00, 30, 'có sẵn'),
(6, 3, 'Giày Da Nam', 'Giày da nam sang trọng', 'image6.jpg', 500000.00, 10, 'hết hàng'),
(7, 4, 'Laptop Dell', 'Laptop Dell XPS 13', 'image7.jpg', 12000000.00, 5, 'có sẵn'),
(8, 5, 'Tủ Lạnh Samsung', 'Tủ lạnh Samsung inverter', 'image8.jpg', 8000000.00, 8, 'có sẵn'),
(9, 1, 'Áo Khoác Nam', 'Áo khoác nam ấm áp', 'image9.jpg', 350000.00, 12, 'có sẵn'),
(10, 2, 'Áo Len Nữ', 'Áo len nữ thời trang', 'image10.jpg', 200000.00, 15, 'hết hàng'),
(11, 3, 'Giày Converse', 'Giày thể thao Converse', 'image11.jpg', 750000.00, 18, 'có sẵn'),
(12, 4, 'Điện Thoại iPhone 14', 'Điện thoại iPhone 14 chính hãng', 'image12.jpg', 22000000.00, 10, 'hết hàng'),
(13, 5, 'Máy Giặt LG', 'Máy giặt LG công nghệ tiên tiến', 'image13.jpg', 9000000.00, 7, 'có sẵn'),
(14, 1, 'Áo Thun Nam', 'Áo thun nam cổ tròn', 'image14.jpg', 150000.00, 20, 'có sẵn'),
(15, 2, 'Đầm Nữ', 'Đầm nữ đi tiệc', 'image15.jpg', 350000.00, 25, 'có sẵn'),
(16, 3, 'Giày Adidas', 'Giày Adidas thời trang', 'image16.jpg', 1200000.00, 15, 'hết hàng'),
(17, 4, 'Smartwatch Samsung', 'Đồng hồ thông minh Samsung', 'image17.jpg', 3500000.00, 10, 'có sẵn'),
(18, 5, 'Máy Xay Sinh Tố', 'Máy xay sinh tố đa năng', 'image18.jpg', 700000.00, 20, 'hết hàng'),
(19, 1, 'Áo Sơ Mi Họa Tiết', 'Áo sơ mi họa tiết độc đáo', 'image19.jpg', 220000.00, 22, 'có sẵn'),
(20, 2, 'Áo Khoác Nữ', 'Áo khoác nữ ấm áp', 'image20.jpg', 300000.00, 30, 'hết hàng'),
(21, 3, 'Giày Bóng Đá', 'Giày bóng đá Nike', 'image21.jpg', 1500000.00, 25, 'có sẵn'),
(22, 4, 'Tai Nghe Bluetooth', 'Tai nghe Bluetooth chất lượng', 'image22.jpg', 800000.00, 10, 'có sẵn'),
(23, 5, 'Lò Vi Sóng Panasonic', 'Lò vi sóng Panasonic hiện đại', 'image23.jpg', 1800000.00, 5, 'hết hàng'),
(24, 1, 'Áo Phông Nam', 'Áo phông nam cotton', 'image24.jpg', 120000.00, 18, 'có sẵn'),
(25, 2, 'Áo Vest Nữ', 'Áo vest nữ thanh lịch', 'image25.jpg', 550000.00, 12, 'có sẵn'),
(26, 3, 'Giày Boots Nam', 'Giày boots nam cao cấp', 'image26.jpg', 900000.00, 15, 'hết hàng'),
(27, 4, 'Tivi Sony', 'Tivi Sony 55 inch 4K', 'image27.jpg', 15000000.00, 10, 'có sẵn'),
(28, 5, 'Máy Pha Cà Phê', 'Máy pha cà phê tự động', 'image28.jpg', 5000000.00, 8, 'có sẵn'),
(29, 1, 'Áo Sơ Mi Caro', 'Áo sơ mi caro đẹp', 'image29.jpg', 240000.00, 20, 'hết hàng'),
(30, 2, 'Quần Legging Nữ', 'Quần legging nữ thời trang', 'image30.jpg', 180000.00, 15, 'có sẵn'),
(31, 3, 'Giày Thể Thao Nike', 'Giày thể thao Nike chất lượng', 'image31.jpg', 1800000.00, 12, 'có sẵn'),
(32, 4, 'Loa Bluetooth JBL', 'Loa Bluetooth JBL chất lượng', 'image32.jpg', 1000000.00, 10, 'hết hàng'),
(33, 5, 'Máy Hút Bụi', 'Máy hút bụi công suất lớn', 'image33.jpg', 2000000.00, 5, 'có sẵn'),
(34, 1, 'Áo Len Nam', 'Áo len nam giữ ấm', 'image34.jpg', 250000.00, 25, 'có sẵn'),
(35, 2, 'Áo Khoác Dạ Nữ', 'Áo khoác dạ nữ đẹp', 'image35.jpg', 500000.00, 20, 'hết hàng'),
(36, 3, 'Giày Sandal Nữ', 'Giày sandal nữ dễ thương', 'image36.jpg', 350000.00, 18, 'có sẵn'),
(37, 4, 'Máy Tính Bảng Samsung', 'Máy tính bảng Samsung Galaxy Tab', 'image37.jpg', 10000000.00, 8, 'có sẵn'),
(38, 5, 'Quạt Điện', 'Quạt điện công suất mạnh', 'image38.jpg', 600000.00, 15, 'hết hàng'),
(39, 1, 'Áo Thun Nam Có Cổ', 'Áo thun nam có cổ đẹp', 'image39.jpg', 180000.00, 22, 'có sẵn'),
(40, 2, 'Áo Croptop Nữ', 'Áo croptop nữ thời trang', 'image40.jpg', 120000.00, 18, 'có sẵn'),
(41, 3, 'Giày Thể Thao Puma', 'Giày thể thao Puma chất lượng', 'image41.jpg', 1200000.00, 15, 'hết hàng'),
(42, 4, 'Máy Chiếu Mini', 'Máy chiếu mini di động', 'image42.jpg', 3000000.00, 10, 'có sẵn'),
(43, 5, 'Bàn Ủi', 'Bàn ủi hơi nước', 'image43.jpg', 500000.00, 25, 'có sẵn'),
(44, 1, 'Áo Sơ Mi Xanh', 'Áo sơ mi xanh cho nam', 'image44.jpg', 200000.00, 30, 'hết hàng'),
(45, 2, 'Áo Khoác Nữ Hàn Quốc', 'Áo khoác nữ Hàn Quốc', 'image45.jpg', 400000.00, 20, 'có sẵn'),
(46, 3, 'Giày Sandal Nam', 'Giày sandal nam', 'image46.jpg', 250000.00, 18, 'có sẵn'),
(47, 4, 'Tai Nghe Sony', 'Tai nghe Sony chất lượng cao', 'image47.jpg', 1500000.00, 10, 'hết hàng'),
(48, 5, 'Nồi Cơm Điện', 'Nồi cơm điện cao tần', 'image48.jpg', 700000.00, 12, 'có sẵn'),
(49, 1, 'Áo Thun Nam Cổ Tròn', 'Áo thun nam cổ tròn', 'image49.jpg', 140000.00, 25, 'hết hàng'),
(50, 2, 'Đầm Dự Tiệc Nữ', 'Đầm dự tiệc nữ cao cấp', 'image50.jpg', 600000.00, 15, 'có sẵn');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '123456', '0123456789', 'Hà Nội', 'user', '2025-03-26 10:58:19'),
(2, 'Admin B', 'adminb@gmail.com', 'admin123', '0987654321', 'TP.HCM', 'admin', '2025-03-26 10:58:19'),
(3, 'hehuhu', 'nooobao86@gmail.com', '$2y$10$DhYVkG5gNCI0fVAYQ0Gv3OusbYxlGlKhXFsgNdA5DAtPQoH.DoTke', NULL, NULL, 'user', '2025-03-27 06:30:10'),
(4, 'anh ba', 'test@gmail.com', '$2y$10$vJzNHKUEmdCOiPx0qwao7.f/5Jh.1eBZkhVzmhyPTA1ahQLzeNSKO', '08262626', 'TP Hồ Chí Minh', 'user', '2025-03-27 06:33:24'),
(5, 'Anh Tư', 'anhtumientrung@gmail.com', '$2y$10$b6Q6xkYMdT2D46JHjRdEguYDctGx1pg.GI/rfXcKpyciiBl/kRd9S', '09091509', '34 vũ tùng', 'user', '2025-03-27 09:40:12'),
(6, 'Cậu ba', 'cauba@gmail.com', '$2y$10$TXqxwaZsl1GH/gza3bcI0.fesnlAjO68DO5xZ2dO/phko28J3NxxG', '012904091', 'sàasfa', 'user', '2025-03-27 09:43:43'),
(7, 'A Mẫn', 'aman@gmail.com', '$2y$10$MQ1OT8T5okxerD7OLgZNBOkOh6NnUNUp50b5rBrdXyOB9IAWgzN3G', '09128418', 'con là con ', 'user', '2025-03-27 11:54:01'),
(8, 'A báo', 'abao@gmail.com', '$2y$10$iQFVWVXS5jWV3jrTogpkeenGsIg.R7HAK3rEChoQlZ//ARaI1CwVi', '22222222222', 'sadasd', 'user', '2025-03-27 11:55:01'),
(9, 'lần cuối ta đi bên nhau', 'huhu@gmail.com', '$2y$10$5RTeFCHBesvABZNtCktkluEv2HCFOdpPwZhVx9ncUJQWIQBF3ezJW', '123123', 'sadasfas', 'user', '2025-03-27 12:54:05'),
(11, 'anh ba chà cú', 'anhbachacu@gmail.com', '$2y$10$8HTK6vRXZxgoGCXXVZghM.GbwNLi880hjXHxWZZSYimPhAdD3Ub7u', '08666633426', '123123', 'user', '2025-04-06 08:59:57'),
(12, 'anhhai', 'anhhai@gmail.com', '$2y$10$RKo7QhA5xYQCjv3UgONncu//PIIdxCYBFm1zVawJxow2bW2dn6lXu', '0949629860', '213123', 'user', '2025-04-06 09:00:59'),
(14, 'anhhaioi', 'anhhaioi@gmail.com', '$2y$10$nJge1frgHr7wX1V5Fn7g2eI64XAsP47KFHTffAZEprPV.IHgJFgL2', '010101010', 'asdasd', 'user', '2025-04-06 09:06:13'),
(15, 'kimoanh', 'kimoanh@gmail.com', '$2y$10$SbE4sJVjno/7XcLAaMLPN.Y8hI.l/6/MiDulDsJJBEXdLxgJSaFk.', '222223333', '123123', 'user', '2025-04-06 09:09:11'),
(16, 'phamthikimon', 'ptko@gmail.com', '$2y$10$WoD0yYpIvNoF5xUEaWfGreuE6GDAcclsqjKyFaC1wkRy4Y5Fybc1C', '8686868', '123', 'user', '2025-04-06 09:11:50'),
(17, 'cauba', 'cuba@gmail.com', '$2y$10$u6Z9s/fSplqRVKItihhvg.jcEOHujOhh4adhTUnPDhtI6YEP5fCHO', '189898', '123', 'user', '2025-04-06 09:15:35'),
(18, 'chiyeuminhem', 'chiyeuminhem@gmail.com', '$2y$10$X9XBrewwcc61oGO2RcWkjOtsorSmFsOIXS2bMHE9YIoIhNnL7THvK', '666666', '213123', 'admin', '2025-04-06 09:17:32'),
(19, '1lannua', '1lannua@gmail.com', '$2y$10$K2zpRtgwqqdQVGXL4d/xcOc3yy/yM3xQBSGJkx3k5IpjBa4CbjlHq', '3456678', '123123', 'user', '2025-04-06 09:19:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
