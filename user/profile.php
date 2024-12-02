<?php
session_start();

$config = require_once (dirname(__DIR__)) . '/config/config.php';

require_once (dirname(__DIR__)) . '/db/order.php';

$db = new Database();

$orderDb = new Order();


if (!isset($_SESSION['user'])) {
    Header('Location: ../index.php');
}

$user = $db->getOne('t_users', $_SESSION['user']['id']);

// Get order detail
$orders = $db->findAll('t_orders', ['userId' => $user['id']]);

$isAdmin = !empty(array_filter($_SESSION['user']['role'], function ($role) {
    return $role['role'] === 'ADMIN';
}));

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

    .popup .btn-close {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: red;
        color: white;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        border-radius: 50%;
        font-weight: bold;
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

    button,
    a {
        cursor: pointer;
    }


    /* Modal Styles */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Overlay effect */
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        text-align: center;
        position: relative;
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
            <?php if($isAdmin){ ?>
            <p>
                <a href="<?php echo $config['BASE_URL'] . '/admin/'; ?>">Tới trang quản lý</a>
            </p>
            <?php } ?>
            <form method="POST" action="edit_profile.php">
                <table>
                    <tr>
                        <th>Họ và tên</th>
                        <td><input required name="name" value="<?php echo $user['name'] ?? ''; ?>"
                                placeholder="Họ và tên">
                        </td>
                    </tr>
                    <tr>
                        <th>Số điện thoại</th>
                        <td><input required name="phone" value="<?php echo $user['phone'] ?? ''; ?>"
                                placeholder="Số điện thoại">
                        </td>
                    </tr>
                    <tr>
                        <th>Địa chỉ</th>
                        <td><input required name="address" value=" <?php echo $user['address'] ?? ''; ?>"
                                placeholder="Địa chỉ">
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><input placeholder="Email" required name="email"
                                value=" <?php echo $user['email'] ?? ''; ?>">
                        </td>
                    </tr>
                </table>
                <br>
                <button type="submit" class="btn-edit">Cập nhật</button>
                <button type="button" class="btn-edit" id="openModalBtn">Đổi mật khẩu</button>
                <br>
                <br><a href="<?php echo $config['BASE_URL'].'/utils/logout.php'; ?>">Đăng xuất</a>
            </form>
        </div>

        <div class="profile-section">
            <h2>Lịch sử đơn hàng</h2>
            <table>
                <tr>
                    <th>STT</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th colspan="2">Chi tiết</th>
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
                                    <td>
                                        <button class='view-order' data-order-id='{$order['id']}'>Xem</button>";

                            if ($order['status'] == 'pending') {
                                echo " <button class='cancel-order' data-order-id='{$order['id']}'>Hủy</button>";
                            }

                            echo "</td></tr>";
                            $i++;
                        }
                    } else {
                        echo '<tr><td colspan="5">Chưa có đơn hàng nào.</td></tr>';
                    }
                    ?>

            </table>
        </div>
    </div>

    <!-- Popup -->
    <div id="order-popup" class="popup">
        <button class="btn-close" onclick="closePopup()">X</button>
        <div class="popup-content">
            <h3>Chi tiết đơn hàng</h3>
            <p style="text-align:center"><small>Ấn vào ô sản phẩm để tới trang sản phẩm</small></p>
            <div id="popup-content-body"> </div>
        </div>
    </div>

    <!-- Modal For Change Password -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <a class="btn-close" id="closeModalBtn">&times;</a>
            <pre>Đang phát triển</pre>
            <h2>Đổi mật khẩu</h2>
            <form id="changePasswordForm">
                <div>
                    <label for="currentPassword">Mật khẩu hiện tại:</label>
                    <input type="password" id="currentPassword" name="currentPassword" required>
                </div>
                <div>
                    <label for="newPassword">Mật khẩu mới:</label>
                    <input type="password" id="newPassword" name="newPassword" required>
                </div>
                <div>
                    <label for="confirmPassword">Xác nhận mật khẩu:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                <button type="submit">Xác nhận</button>
            </form>
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


    // Change pass
    document.addEventListener('DOMContentLoaded', () => {
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modal = document.getElementById('modal');

        openModalBtn.addEventListener('click', () => {
            modal.style.display = 'flex'; // Show the modal
        });

        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none'; // Hide the modal
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
    </script>
</body>

</html>