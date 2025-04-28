<?php
session_start(); // Bắt đầu phiên làm việc

// Hủy bỏ tất cả các biến phiên
session_unset();

// Hủy phiên làm việc
session_destroy();

// Chuyển hướng đến trang đăng nhập
header("Location: login.php");
exit();
?>
