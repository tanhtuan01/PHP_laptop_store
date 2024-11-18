<?php
session_start();

$config = require_once (dirname(__DIR__)) . '/config/config.php';

if (!isset($_SESSION['user'])) {
    Header('Location: ../index.php');
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ người dùng</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <style>

    </style>
</head>

<body>
    <a href="<?php echo $config['BASE_URL']; ?>">Quay lại trang chủ</a>
    <div class="container">
        <div class="profile-header">
            <img src="" alt="Avatar">
            <h1><?php echo $user['name'] ?? 'Người dùng'; ?></h1>
            <p>Email: <?php echo $user['email'] ?? 'Chưa cập nhật'; ?></p>
            <p>Email: <?php echo $user['phone'] ?? 'Chưa cập nhật'; ?></p>
        </div>

        <div class="profile-section">
            <h2>Thông tin cá nhân</h2>
            <table>
                <tr>
                    <th>Họ và tên</th>
                    <td><?php echo $user['name'] ?? 'Chưa cập nhật'; ?></td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td><?php echo $user['phone'] ?? 'Chưa cập nhật'; ?></td>
                </tr>
                <tr>
                    <th>Địa chỉ</th>
                    <td><?php echo $user['address'] ?? 'Chưa cập nhật'; ?></td>
                </tr>
            </table>
            <br> <a href="edit-profile.php" class="edit-btn">Cập nhật</a>
        </div>

        <div class="profile-section">
            <h2>Lịch sử đơn hàng</h2>
            <table>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                </tr>
                <!-- Lặp qua các đơn hàng từ cơ sở dữ liệu -->
                <?php
                if (!empty($user['orders'])) {
                    foreach ($user['orders'] as $order) {
                        echo "<tr>
                                <td>{$order['id']}</td>
                                <td>{$order['date']}</td>
                                <td>{$order['total']}</td>
                                <td>{$order['status']}</td>
                              </tr>";
                    }
                } else {
                    echo '<tr><td colspan="4">Chưa có đơn hàng nào.</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>