<?php
require_once dirname(dirname(__DIR__)) . '/db/base.php';

$db = new Database();
$orders = $db->findAll('t_orders', [], 'id', 'DESC');

require_once dirname(dirname(__DIR__)) . '/db/order.php';
$orderDb = new Order();
?>

<style>
    /* Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Heading */
    .heading {
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    /* Table */
    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .order-table th,
    .order-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .order-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .order-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Buttons */
    .btn-view,
    .btn-cancel {
        display: inline-block;
        padding: 8px 12px;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn-view:hover,
    .btn-cancel:hover {
        background-color: #0056b3;
    }

    .btn-cancel {
        background-color: #dc3545;
    }

    .btn-cancel:hover {
        background-color: #c82333;
    }

    /* Select dropdown */
    .status-select {
        width: 150px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    .status-select option {
        padding: 8px;
    }

    /* General text and layout */
    .text-muted {
        color: #6c757d;
    }
</style>

<div class="container">
    <h2 class="heading">Danh sách Đơn Hàng</h2>

    <?php if ($orders): ?>
        <table class="order-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên người nhận</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th colspan="2">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td><?php echo htmlspecialchars($order['phone']); ?></td>
                        <td><?php echo htmlspecialchars($order['address']); ?></td>
                        <td><?php echo number_format($order['totalAmount'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo $orderDb->formatOrderStatus($order['status']); ?></td>
                        <td>
                            <a href="javascript:void(0);" class="btn-view"
                                onclick="loadContent('order_detail.php', <?php echo $order['id']; ?>);">
                                Xem
                            </a>
                        </td>
                        <!-- <td>
                    <select class="status-select">
                        <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>
                            Pending</option>
                        <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>
                            Processing</option>
                        <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>
                            Completed</option>
                    </select>
                </td> -->
                        <td>
                            <?php if ($order['status'] === 'pending') { ?>
                                <a href="#" class="btn-cancel">Hủy</a>
                            <?php } else { ?>
                                <!-- <span class="text-muted">Không được hủy</span> -->
                            <?php } ?>
                        </td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>