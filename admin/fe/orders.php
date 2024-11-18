<?php 
    require_once dirname(dirname(__DIR__)) . '/db/connect.php';

    $db = new Database();

    $orders = $db->findAll('t_orders', [], 'id','DESC');

    require_once dirname(dirname(__DIR__)) . '/db/order.php';
    
    $orderDb = new Order();
?>

<div id="mainContent">
    <h2>Đơn Hàng</h2>

    <table style="width: 100%;text-align: left" cellpadding="20" cellspacing="0" border="1">
        <tr>
            <th>STT</th>
            <th>Tên người nhận</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th colspan="3">Thao tác</th>
        </tr>
        <?php if ($orders): ?>
        <?php $i = 1; foreach ($orders as $order): ?>
        <tr>
            <td><?php echo $i; ?>
            <td><?php echo $order['name']; ?></td>
            <td><?php echo $order['phone']; ?></td>
            <td><?php echo $order['address']; ?></td>
            <td><?php echo (number_format($order['totalAmount'], 0, ',', '.')); ?> VNĐ</td>
            <td><?php echo $orderDb->formatOrderStatus($order['status']); ?></td>
            <td>
                <a href="javascript:void(0);"
                    onclick="loadContent('order_detail.php', <?php echo $order['id']; ?>);">Xem</a>
            </td>
            <td>
                <select></select>
            </td>
            <td>
                <?php if($order['status'] === 'pending'){ ?>
                <a>HỦy</a>
                <?php } else { ?>
                <!-- <b>Không được hủy</b> -->
                <?php }?>
            </td>
        </tr>
        <?php $i++; endforeach; ?>
        <?php else: ?>

        <?php endif; ?>
    </table>

</div>