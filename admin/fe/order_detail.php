<?php
require_once dirname(dirname(__DIR__)) . '/db/base.php';
require_once dirname(dirname(__DIR__)) . '/db/order.php';

$config = require_once dirname(dirname(__DIR__)) . '/config/config.php';

$db = new Database();
$orderDb = new Order();

$id = $_GET['id'] ?? null;
if (!$id) {
    die('Đơn hàng không hợp lệ');
}

$order = $db->getOne('t_orders', $id);
if (!$order) {
    die('Không tìm thấy đơn hàng');
}

$orderDetails = $orderDb->findOrderDetailsByOrderId($id);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <!-- Sử dụng Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Chi tiết đơn hàng</h3>

        <div class="mb-3">
            <p><strong>Trạng thái:</strong>
                <?php echo ($orderDb->formatOrderStatus($order['status'])); ?></p>
        </div>

        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá tiền</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orderDetails) { ?>
                <?php $i = 1;
                    foreach ($orderDetails as $orderDetail): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo htmlspecialchars($orderDetail['productName']); ?></td>
                    <td><?php echo $orderDetail['quantity']; ?></td>
                    <td><?php echo number_format($orderDetail['price'], 0, ',', '.'); ?> VNĐ</td>
                    <td><?php echo number_format($orderDetail['totalPrice'], 0, ',', '.'); ?> VNĐ</td>
                </tr>
                <?php $i++;
                    endforeach; ?>
                <?php } else { ?>
                <tr>
                    <td colspan="5">Không có chi tiết đơn hàng</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <a href="<?php echo $config['BASE_URL'] . '/admin/index.php?page=orders'; ?>" class="btn btn-secondary">Danh
                sách đơn hàng</a>

            <div>
                <?php if ($order['status'] != 'processing' && $order['status'] != 'completed' && $order['status'] != 'cancelled') { ?>
                <a style="background:red;color:white;border:none"
                    href="be/order.php?orderId=<?php echo $id; ?>&action=cancelled" class="btn btn-primary">Hủy đơn
                    hàng</a>
                <a href=" be/order.php?orderId=<?php echo $id; ?>&action=processing" class="btn btn-primary">Xác
                    nhận đơn
                    hàng</a>

                <?php } ?>

                <?php if ($order['status'] == 'processing') { ?>
                <a href="be/order.php?orderId=<?php echo $id; ?>&action=completed" class="btn btn-success">Hoàn thành
                    đơn hàng</a>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>