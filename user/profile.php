<?php
session_start();

$config = require_once (dirname(__DIR__)) . '/config/config.php';

require_once (dirname(__DIR__)) . '/db/order.php';

$db = new Database();

$orderDb = new Order();

if (!isset($_SESSION['user'])) {
    Header('Location: ../index.php');
}

$user = $_SESSION['user'];

// Get order detail
$orders = $db->findAll('t_orders', ['userId' => $user['id']]);


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
        /* CSS cho popup */
        .popup {
            position: fixed;
            top: 0;
            right: -500px;
            /* Để ẩn popup ra ngoài */
            width: 400px;
            height: 100%;
            background-color: #f4f4f4;
            box-shadow: -2px 0px 5px rgba(0, 0, 0, 0.2);
            padding: 20px;
            transition: right 0.3s ease;
            z-index: 1000;
        }

        .popup.show {
            right: 0;
            /* Hiển thị popup */
        }

        .popup .popup-content {
            max-height: 90%;
            overflow-y: auto;
        }

        .popup .close-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .detail-pop {
            background-color: white;
            padding: 5px 10px;
            margin: 2px 0;
            border: 1px solid silver;
            border-radius: 5px;
        }

        .detail-pop p {
            margin: 2px;
        }

        .detail-pop img {
            width: 100px;
            height: 80px;
            max-height: 80px;
            display: block;
            margin: auto;
        }

        .detail-pop a {
            text-decoration: none;
            color: black;
        }

        .detail-pop .info {
            display: flex;
            padding: 5px 0;
            justify-content: space-around;
        }

        h3 {
            margin: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <a href="<?php echo $config['BASE_URL']; ?>">Quay lại trang chủ</a>
    <div class="container">
        <div class="profile-header">
            <img src="" alt="Avatar">
            <h1>Xin chào: <?php echo $user['username'] ?? 'Người dùng'; ?></h1>
            <!-- <p>Email: <?php echo $user['email'] ?? 'Chưa cập nhật'; ?></p> -->
            <!-- <p>Email: <?php echo $user['phone'] ?? 'Chưa cập nhật'; ?></p> -->
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
                    <th>STT</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
                <!-- Lặp qua các đơn hàng từ cơ sở dữ liệu -->
                <?php
                if (!empty($orders)) {
                    $i = 1;
                    foreach ($orders as $order) {
                        echo "<tr>
                                <td>{$i}</td>
                                <td>{$order['orderDate']}</td>
                                <td>{$order['totalAmount']}</td>
                                <td>{$orderDb->formatOrderStatus($order['status'])}</td>
                                <td><button class='view-order' data-order-id='{$order['id']}'>Xem</button></td>
                              </tr>";
                        $i++;
                    }
                } else {
                    echo '<tr><td colspan="4">Chưa có đơn hàng nào.</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>

    <!-- Popup -->
    <div id="order-popup" class="popup">
        <button class="close-btn" onclick="closePopup()">Đóng</button>
        <div class="popup-content">
            <h3>Chi tiết đơn hàng</h3>
            <div id="popup-content-body"> </div>
        </div>
    </div>

    <script>
        function openPopup(orderId) {
            const baseUrl = window.location.origin + '/' + window.location.pathname.split('/')[1];

            const apiUrl = `${baseUrl}/rest/index.php?resource=order&action=findOrderDetailsByOrderId&id=${orderId}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const formatCurrency = (amount) => {
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(amount);
                        };

                        let content = data.map(order => `
                <div class='detail-pop'>
                    <a href="${baseUrl}/views/product.php?id=${order.productId}">
                    <h3>Sản phẩm: ${order.productName}</h3>
                    <div class='info'>
                        <p><strong>Giá:</strong> ${formatCurrency(order.price)}</p>
                        <p><strong>Số lượng:</strong> ${order.quantity}</p>
                        <p><strong>Tổng tiền:</strong> ${formatCurrency(order.totalPrice)}</p>
                    </div>
                    <img src="${baseUrl}/assets/images/products/${order.image}" alt="${order.productName}" width="100">
                    </a>
                </div>
            `).join('');

                        document.getElementById('popup-content-body').innerHTML = content;
                        document.getElementById('order-popup').classList.add('show');
                    } else {
                        alert('Không tìm thấy đơn hàng.');
                    }
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra:', error);
                    alert('Không thể lấy thông tin đơn hàng.');
                });

        }


        // Hàm đóng popup
        function closePopup() {
            document.getElementById('order-popup').classList.remove('show');
        }

        // Thêm sự kiện cho các nút "Xem"
        document.querySelectorAll('.view-order').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                openPopup(orderId);
            });
        });
    </script>
</body>

</html>