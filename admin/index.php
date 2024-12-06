<?php

session_start();

$config = require_once '../config/config.php';

if (!isset($_SESSION['user'])) {
    Header("location: {$config['BASE_URL']}/login.php");
    die();
}

$isAdmin = !empty(array_filter($_SESSION['user']['role'], function ($role) {
    return $role['role'] === 'ADMIN';
}));

if(!$isAdmin){
    Header("location: {$config['BASE_URL']}/login.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var page = urlParams.get('page') || 'add_product';
        var id = urlParams.get('id'); // Lấy id từ URL nếu có
        loadContent(page + '.php', id);

        // Xử lý sự kiện khi nhấp vào menu
        $('.menu-item').click(function() {
            var page = $(this).data('page') + '.php';
            loadContent(page);
        });
    });

    function loadContent(page, id = null) {
        // Truyền thêm id vào URL nếu có
        var url = 'fe/load_content.php?page=' + page;
        if (id) {
            url += '&id=' + id;
        }
        $('#FRAGMENT').load(url);
    }
    </script>

</head>

<body>

    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <p style="text-align:center;"><a style="color:white;" href="<?php echo $config['BASE_URL']; ?>">Trang
                web</a></p>
        <ul>
            <li class="disable-item">Thống kê</li>
            <li class="menu-item" data-page="revenue">Doanh thu</li>
            <li class="menu-item" data-page="statistic">Biểu đồ thống kê</li>
            <li class="disable-item">Hãng & Loại, Khác</li>
            <li class="menu-item" data-page="brand">Thêm Hãng Laptop</li>
            <li class="menu-item" data-page="type">Thêm Loại Laptop</li>
            <li class="menu-item" data-page="features">Tính năng</li>
            <li class="menu-item" data-page="special_tech">Công nghệ đặc biệt</li>
            <li class="disable-item">SẢN PHẨM</li>
            <li class="menu-item" data-page="add_product">Thêm Sản Phẩm</li>
            <li class="menu-item" data-page="list_product">Danh Sách Sản Phẩm</li>
            <li class="menu-item" data-page="discounted_products">Sản Phẩm Đang Giảm Giá</li>
            <li class="menu-item" data-page="orders">Đơn Hàng</li>
            <li class="disable-item">Người dùng & quyền</li>
            <li class="menu-item" data-page="roles">Quyền người dùng</li>
            <li class="menu-item" data-page="add_user">Thêm người dùng</li>
            <li class="menu-item" data-page="users">Quản lý</li>
            <li class="disable-item">Khác</li>
            <li class="menu-item" data-page="sliders">Slide & chương trình</li>
            <li class="menu-item" data-page="vouchers">Phiếu giảm giá - voucher</li>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h1><?php echo $config['PROJECT_NAME']; ?></h1>
        </div>
        <?php if (isset($_GET['message']) && isset($_GET['type'])): ?>
        <div class="alert <?php echo htmlspecialchars($_GET['type']); ?>">
            <span class="alert-icon">✔️</span>
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
        <?php endif; ?>
        <div id="FRAGMENT"></div>
    </div>

    <script src="../assets/js/main.js"></script>
</body>

</html>